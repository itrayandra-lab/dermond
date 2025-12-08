<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XenditService implements PaymentGatewayInterface
{
    private string $secretKey;

    private string $apiUrl;

    public function __construct()
    {
        $this->secretKey = config('xendit.secret_key') ?? '';
        $this->apiUrl = config('xendit.api_url') ?? 'https://api.xendit.co';
    }

    public function createTransaction(Order $order): array
    {
        $order->loadMissing(['items', 'user']);

        $payload = [
            'external_id' => $order->order_number,
            'amount' => $order->total,
            'description' => 'Order #'.$order->order_number,
            'invoice_duration' => config('xendit.invoice.duration', 86400),
            'currency' => 'IDR',
            'customer' => [
                'given_names' => $order->user?->name ?? 'Customer',
                'email' => $order->user?->email,
                'mobile_number' => $this->formatPhoneNumber($order->phone),
            ],
            'customer_notification_preference' => [
                'invoice_created' => ['email'],
                'invoice_reminder' => ['email'],
                'invoice_paid' => ['email'],
            ],
            'success_redirect_url' => config('xendit.success_redirect_url')
                ?: route('checkout.confirmation', ['order' => $order->id]),
            'failure_redirect_url' => config('xendit.failure_redirect_url')
                ?: route('checkout.error'),
            'items' => $this->mapItems($order),
        ];

        try {
            $response = $this->client()
                ->post('/v2/invoices', $payload);

            if (! $response->successful()) {
                Log::error('Xendit createTransaction failed', [
                    'order_number' => $order->order_number,
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                throw new \RuntimeException('Gagal membuat transaksi pembayaran.');
            }

            $data = $response->json();

            return [
                'snap_token' => $data['id'] ?? null,
                'redirect_url' => $data['invoice_url'] ?? null,
                'token' => $data['id'] ?? null,
            ];
        } catch (\Throwable $e) {
            Log::error('Xendit createTransaction exception', [
                'order_number' => $order->order_number,
                'message' => $e->getMessage(),
            ]);

            throw new \RuntimeException('Gagal membuat transaksi pembayaran.');
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function mapItems(Order $order): array
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->product_price,
                'category' => 'Product',
            ];
        }

        if ($order->shipping_cost > 0) {
            $items[] = [
                'name' => 'Shipping Cost',
                'quantity' => 1,
                'price' => $order->shipping_cost,
                'category' => 'Shipping',
            ];
        }

        // Xendit doesn't support negative items, handle voucher differently
        // The total amount already accounts for the discount

        return $items;
    }

    public function verifyNotification(array $data): bool
    {
        // Xendit uses x-callback-token header for verification
        // This is checked in the controller before calling this method
        // Here we do additional validation if needed
        return true;
    }

    public function parseNotification(array $data): array
    {
        return [
            'order_id' => $data['external_id'] ?? null,
            'transaction_id' => $data['id'] ?? null,
            'transaction_status' => $this->mapStatus($data['status'] ?? null),
            'payment_type' => $data['payment_method'] ?? $data['payment_channel'] ?? null,
            'fraud_status' => null,
            'status_code' => null,
            'gross_amount' => $data['paid_amount'] ?? $data['amount'] ?? null,
            'xendit_status' => $data['status'] ?? null,
        ];
    }

    public function getTransactionStatus(string $orderId): ?array
    {
        try {
            // Find invoice by external_id
            $response = $this->client()
                ->get('/v2/invoices', [
                    'external_id' => $orderId,
                ]);

            if (! $response->successful()) {
                return null;
            }

            $invoices = $response->json();

            if (empty($invoices)) {
                return null;
            }

            // Get the most recent invoice
            $invoice = $invoices[0];

            return [
                'order_id' => $invoice['external_id'] ?? null,
                'transaction_id' => $invoice['id'] ?? null,
                'transaction_status' => $this->mapStatus($invoice['status'] ?? null),
                'payment_type' => $invoice['payment_method'] ?? $invoice['payment_channel'] ?? null,
                'fraud_status' => null,
                'status_code' => null,
                'gross_amount' => $invoice['paid_amount'] ?? $invoice['amount'] ?? null,
            ];
        } catch (\Throwable $e) {
            Log::error('Xendit getTransactionStatus failed', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Verify webhook callback token.
     */
    public function verifyCallbackToken(string $token): bool
    {
        $expectedToken = config('xendit.webhook_token');

        return $expectedToken && hash_equals($expectedToken, $token);
    }

    /**
     * Map Xendit status to Midtrans-compatible status.
     */
    private function mapStatus(?string $xenditStatus): ?string
    {
        return match ($xenditStatus) {
            'PAID', 'SETTLED' => 'settlement',
            'PENDING' => 'pending',
            'EXPIRED' => 'expire',
            default => null,
        };
    }

    /**
     * Format phone number to E.164 format.
     */
    private function formatPhoneNumber(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert 08xx to +628xx
        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        }

        // Add + prefix if not present
        if (! str_starts_with($phone, '+')) {
            $phone = '+'.$phone;
        }

        return $phone;
    }

    private function client(): PendingRequest
    {
        return Http::withBasicAuth($this->secretKey, '')
            ->acceptJson()
            ->asJson();
    }
}

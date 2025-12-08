<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderNotificationMail;
use App\Mail\OrderFailedMail;
use App\Mail\OrderPaidMail;
use App\Models\Order;
use App\Models\SiteSetting;
use App\Services\Payment\XenditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentWebhookController extends Controller
{
    public function __construct(
        private XenditService $xenditService,
    ) {}

    public function xendit(Request $request): JsonResponse
    {
        $payload = $request->all();
        $callbackToken = $request->header('x-callback-token', '');

        if (! $this->xenditService->verifyCallbackToken($callbackToken)) {
            Log::warning('Xendit notification rejected: invalid callback token', [
                'payload' => $payload,
            ]);

            return response()->json(['message' => 'Invalid callback token'], 400);
        }

        $data = $this->xenditService->parseNotification($payload);
        $order = Order::where('order_number', $data['order_id'] ?? null)->first();

        if (! $order) {
            Log::warning('Xendit notification order not found', ['order_id' => $data['order_id'] ?? null]);

            return response()->json(['message' => 'Order not found'], 404);
        }

        // Idempotency check - skip if already in final state
        if (in_array($order->payment_status, ['paid', 'failed', 'expired', 'refunded'], true)) {
            Log::info('Xendit notification skipped: already processed', [
                'order_id' => $order->order_number,
                'current_status' => $order->payment_status,
            ]);

            return response()->json(['message' => 'Already processed']);
        }

        $xenditStatus = $data['xendit_status'] ?? null;
        $transactionStatus = $data['transaction_status'] ?? null;

        if ($xenditStatus === 'PAID' || $xenditStatus === 'SETTLED') {
            $order->payment_status = 'paid';
            $order->status = $order->status === 'pending_payment' ? 'confirmed' : $order->status;
            $order->paid_at = now();
        } elseif ($xenditStatus === 'PENDING') {
            $order->payment_status = 'unpaid';
            $order->status = 'pending_payment';
        } elseif ($xenditStatus === 'EXPIRED') {
            $order->payment_status = 'expired';
            $order->status = 'expired';
            $order->cancelled_at = now();
            $order->restoreStock();
        }

        $order->payment_type = $data['payment_type'] ?? $order->payment_type;
        $order->payment_callback_data = $payload;
        $order->save();

        // Send email notifications
        $this->sendEmailNotifications($order, $transactionStatus);

        Log::info('Xendit notification processed', [
            'order_id' => $order->order_number,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'xendit_status' => $xenditStatus,
        ]);

        return response()->json(['message' => 'OK']);
    }

    private function sendEmailNotifications(Order $order, ?string $transactionStatus): void
    {
        try {
            $order->load('items', 'user');

            // Payment success - send to customer and admin
            if (in_array($transactionStatus, ['capture', 'settlement'], true) && $order->payment_status === 'paid') {
                // Email to customer
                if ($order->user?->email) {
                    Mail::to($order->user->email)->send(new OrderPaidMail($order));
                }

                // Email to admin
                $adminEmail = SiteSetting::getValue('contact.support_email');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new NewOrderNotificationMail($order));
                }
            }

            // Payment failed/expired - send to customer
            if (in_array($transactionStatus, ['deny', 'cancel', 'expire'], true) && $order->user?->email) {
                $reason = $transactionStatus === 'expire' ? 'expired' : 'failed';
                Mail::to($order->user->email)->send(new OrderFailedMail($order, $reason));
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to send order email notification', [
                'order_id' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

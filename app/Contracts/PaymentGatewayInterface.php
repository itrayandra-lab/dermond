<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Create a payment transaction for the given order.
     *
     * @return array{
     *     redirect_url?: string|null,
     *     token?: string|null,
     * }
     */
    public function createTransaction(Order $order): array;

    /**
     * Verify notification payload from gateway.
     */
    public function verifyNotification(array $data): bool;

    /**
     * Parse notification data into normalized array.
     *
     * @return array<string, mixed>
     */
    public function parseNotification(array $data): array;

    /**
     * Get transaction status from gateway.
     *
     * @return array<string, mixed>|null
     */
    public function getTransactionStatus(string $orderId): ?array;
}

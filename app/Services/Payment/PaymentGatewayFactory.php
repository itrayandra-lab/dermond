<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;

class PaymentGatewayFactory
{
    public function make(?string $gateway = null): PaymentGatewayInterface
    {
        $selected = $gateway ?? config('cart.default_gateway', 'xendit');

        return match ($selected) {
            'xendit', default => app(XenditService::class),
        };
    }
}

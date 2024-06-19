<?php

namespace App\Repositories\Mappers;

use App\Repositories\DTOs\PaymentMethodDTO;

class PaymentMethodMapper
{
    public static function toDTO($paymentMethod): PaymentMethodDTO
    {
        return new PaymentMethodDTO(
            $paymentMethod['method_id'],
            $paymentMethod['fix'],
            $paymentMethod['rate'],
        );
    }
}

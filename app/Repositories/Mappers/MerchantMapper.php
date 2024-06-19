<?php

namespace App\Repositories\Mappers;

use App\Repositories\DTOs\MerchantDTO;
use Illuminate\Support\Facades\Log;

class MerchantMapper
{
    public static function toDTO($merchantInfo, $paymentMethods = []): MerchantDTO
    {
        $paymentMethodDTOs = !empty($paymentMethods) ? collect($paymentMethods)->map(function ($paymentMethod) {
            return PaymentMethodMapper::toDTO($paymentMethod);
        })->toArray() : [];

        return new MerchantDTO(
            $merchantInfo['id'],
            $merchantInfo['sub_id'],
            $merchantInfo['first_name'],
            $merchantInfo['last_name'],
            $merchantInfo['full_name'],
            $merchantInfo['va_option'],
            $merchantInfo['partner_code'],
            $paymentMethodDTOs
        );
    }
}

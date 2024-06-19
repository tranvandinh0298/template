<?php

namespace App\Repositories\Mappers;

use App\Repositories\DTOs\BillDTO;
use App\Repositories\DTOs\CustomerDTO;
use App\Repositories\DTOs\MerchantDTO;

class CustomerMapper
{
    public static function toDTO($customerInfo, MerchantDTO $merchantDTO, Array $billDTOs = []): CustomerDTO
    {
        return new CustomerDTO(
            $customerInfo['idNo'],
            $customerInfo['contractNo'],
            $customerInfo['customerName'],
            $customerInfo['customerAddress'],
            null,
            $merchantDTO,
            $billDTOs
        );
    }
}

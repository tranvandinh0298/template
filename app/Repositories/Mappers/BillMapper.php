<?php

namespace App\Repositories\Mappers;

use App\Repositories\DTOs\BillDTO;

class BillMapper
{
    public static function toDTO(array $bill, $billId = null): BillDTO
    {
        return new BillDTO(
            $bill['CycleId'],
            $billId,
            $bill['CycleName'] ?? $bill['CycleDate'],
            $bill['PaymentAmount'],
            $bill['CycleDate'] ?? '',
            $bill['payDate'] ?? '',
            $bill['Status'],
            collect($bill['Detail'])->map(function ($detail) {
                return ['itemName' => $detail['ItemName'], 'itemAmount' => $detail['ItemAmount']];
            })->toArray() ?? []
        );
    }
}

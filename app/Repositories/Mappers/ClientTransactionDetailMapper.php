<?php

namespace App\Repositories\Mappers;

use App\Models\ClientTransactionDetail;
use App\Repositories\DTOs\ClientTransactionDetailDTO;

class ClientTransactionDetailMapper
{
    public static function toDTO(ClientTransactionDetail $clientTransDetail): ClientTransactionDetailDTO
    {
        return new ClientTransactionDetailDTO(
            $clientTransDetail->id,
            $clientTransDetail->transaction_id,
            $clientTransDetail->bill_id,
            $clientTransDetail->name,
            $clientTransDetail->amount,
            json_decode($clientTransDetail->details, true)
        );
    }

    public static function toEntity(ClientTransactionDetailDTO $clientTransDetailDTO): ClientTransactionDetail
    {
        return self::fillEntity(new ClientTransactionDetail(), $clientTransDetailDTO);
    }

    private static function fillEntity(ClientTransactionDetail $clientTransDetail, ClientTransactionDetailDTO $clientTransDetailDTO): ClientTransactionDetail
    {
        $clientTransDetail->id = $clientTransDetailDTO->id;
        $clientTransDetail->transaction_id = $clientTransDetailDTO->transactionId;
        $clientTransDetail->bill_id = $clientTransDetailDTO->billId;
        $clientTransDetail->name = $clientTransDetailDTO->name;
        $clientTransDetail->amount = $clientTransDetailDTO->amount;
        $clientTransDetail->details = json_encode($clientTransDetailDTO->details);

        return $clientTransDetail;
    }
}

<?php

namespace App\Repositories\Mappers;

use App\Models\ClientTransaction;
use App\Repositories\DTOs\ClientTransactionDTO;

class ClientTransactionMapper
{
    public static function toDTO(ClientTransaction $trans): CLientTransactionDTO
    {
        $transDetailDTOs = $trans->relationLoaded("clientTransactionDetails") ? $trans->clientTransactionDetails->map(function ($detail) {
            return ClientTransactionDetailMapper::toDTO($detail);
        })->toArray() : [];

        return new ClientTransactionDTO(
            $trans->id,
            $trans->contract_no,
            $trans->customer_name,
            $trans->customer_address,
            $trans->sub_id,
            $trans->merchant_code,
            $trans->trx_id,
            $trans->mgp_id,
            $trans->amount,
            $trans->fixed_fee,
            $trans->rated_fee,
            $trans->total_amount,
            $trans->method_id,
            $trans->status,
            $trans->mgp_status,
            $trans->mgp_msg,
            $trans->mgp_success_time,
            $trans->mgp_response_code,
            $trans->bank_code,
            $trans->bank_name,
            $trans->va_number,
            $trans->va_name,
            $trans->va_start_date,
            $trans->va_end_date,
            $trans->va_qr_code,
            $trans->va_content,
            $trans->note,
            $trans->created_at,
            $trans->updated_at,
            $transDetailDTOs
        );
    }

    public static function toEntity(ClientTransactionDTO $dto): ClientTransaction
    {
        return self::fillEntity(new ClientTransaction(), $dto);
    }

    public static function updateFromDTO(ClientTransactionDTO $dto, ClientTransaction $trans): ClientTransaction
    {
        return self::fillEntity($trans, $dto);
    }

    private static function fillEntity(ClientTransaction $trans, ClientTransactionDTO $dto): ClientTransaction
    {
        $trans->id = $dto->id;
        $trans->contract_no = $dto->contractNo;
        $trans->customer_name = $dto->customerName;
        $trans->customer_address = $dto->customerAddress;
        $trans->sub_id = $dto->subId;
        $trans->merchant_code = $dto->merchantCode;
        $trans->trx_id = $dto->trxId;
        $trans->mgp_id = $dto->mgpId;
        $trans->amount = $dto->amount;
        $trans->fixed_fee = $dto->fixedFee;
        $trans->rated_fee = $dto->ratedFee;
        $trans->total_amount = $dto->totalAmount;
        $trans->method_id = $dto->methodId;
        $trans->status = $dto->status;
        $trans->mgp_status = $dto->mgpStatus;
        $trans->mgp_msg = $dto->mgpMsg;
        $trans->mgp_success_time = $dto->mgpSuccessTime;
        $trans->mgp_response_code = $dto->mgpResponseCode;
        $trans->bank_code = $dto->bankCode;
        $trans->bank_name = $dto->bankName;
        $trans->va_number = $dto->vaNumber;
        $trans->va_name = $dto->vaName;
        $trans->va_start_date = $dto->vaStartDate;
        $trans->va_end_date = $dto->vaEndDate;
        $trans->va_qr_code = $dto->vaQrCode;
        $trans->va_content = $dto->vaContent;
        $trans->note = $dto->note;

        return $trans;
    }
}

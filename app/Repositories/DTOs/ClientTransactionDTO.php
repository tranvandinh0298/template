<?php

namespace App\Repositories\DTOs;

class ClientTransactionDTO
{
    public $id;
    public $contractNo;
    public $customerName;
    public $customerAddress;
    public $subId;
    public $merchantCode;
    public $trxId;
    public $mgpId;
    public $amount;
    public $fixedFee;
    public $ratedFee;
    public $totalAmount;
    public $methodId;
    public $status;
    public $mgpStatus;
    public $mgpMsg;
    public $mgpSuccessTime;
    public $mgpResponseCode;
    public $bankCode;
    public $bankName;
    public $vaNumber;
    public $vaName;
    public $vaStartDate;
    public $vaEndDate;
    public $vaQrCode;
    public $vaContent;
    public $note;
    public $createdAt;
    public $updatedAt;
    public $clientTransactionDetailDTOs = [];
    public $paymentMethodDTO = null;

    public function __construct(
        $id,
        $contractNo,
        $customerName,
        $customerAddress,
        $subId,
        $merchantCode,
        $trxId,
        $mgpId,
        $amount,
        $fixedFee,
        $ratedFee,
        $totalAmount,
        $methodId,
        $status,
        $mgpStatus,
        $mgpMsg,
        $mgpSuccessTime,
        $mgpResponseCode,
        $bankCode,
        $bankName,
        $vaNumber,
        $vaName,
        $vaStartDate,
        $vaEndDate,
        $vaQrCode,
        $vaContent,
        $note,
        $createdAt,
        $updatedAt,
        $transactionDetailDTOs = []
    )
    {
        $this->id = $id;
        $this->contractNo = $contractNo;
        $this->customerName = $customerName;
        $this->customerAddress = $customerAddress;
        $this->subId = $subId;
        $this->merchantCode = $merchantCode;
        $this->trxId = $trxId;
        $this->mgpId = $mgpId;
        $this->amount = $amount;
        $this->fixedFee = $fixedFee;
        $this->ratedFee = $ratedFee;
        $this->totalAmount = $totalAmount;
        $this->methodId = $methodId;
        $this->status = $status;
        $this->mgpStatus = $mgpStatus;
        $this->mgpMsg = $mgpMsg;
        $this->mgpSuccessTime = $mgpSuccessTime;
        $this->mgpResponseCode = $mgpResponseCode;
        $this->bankCode = $bankCode;
        $this->bankName = $bankName;
        $this->vaNumber = $vaNumber;
        $this->vaName = $vaName;
        $this->vaStartDate = $vaStartDate;
        $this->vaEndDate = $vaEndDate;
        $this->vaQrCode = $vaQrCode;
        $this->vaContent = $vaContent;
        $this->note = $note;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->clientTransactionDetailDTOs = $transactionDetailDTOs;
    }

    public function isTransactionSuccess(): bool
    {
        return $this->status == TRANS_STATUS_SUCCESS;
    }
}

<?php

namespace App\Repositories\DTOs;

class ClientTransactionDetailDTO
{
    public $id;
    public $transactionId;
    public $billId;
    public $name;
    public $amount;
    public $details = [];

    public function __construct(
        $id,
        $transactionId,
        $billId,
        $name,
        $amount,
        $details = []
    ) {
        $this->id = $id;
        $this->transactionId = $transactionId;
        $this->billId = $billId;
        $this->name = $name;
        $this->amount = $amount;
        $this->details = $details;
    }
}

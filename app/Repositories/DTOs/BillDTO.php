<?php

namespace App\Repositories\DTOs;

class BillDTO
{
    public $id;
    public $billId;
    public $name;
    public $amount;
    public $date;
    public $paymentDate;
    public $status;
    public $details;

    public function __construct($id, $billId, $name, $amount, $date, $paymentDate, $status, $details)
    {
        $this->id = $id;
        $this->billId = $billId;
        $this->name = $name;
        $this->amount = $amount;
        $this->date = $date;
        $this->paymentDate = $paymentDate;
        $this->status = $status;
        $this->details = $details;
    }

    public static function fromObject($billObject): BillDTO
    {
        return new self(
            $billObject->id,
            $billObject->billId,
            $billObject->name,
            $billObject->amount,
            $billObject->date,
            $billObject->paymentDate,
            $billObject->status,
            $billObject->details
        );
    }
}

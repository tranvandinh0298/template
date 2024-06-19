<?php

namespace App\Repositories\DTOs;

class MerchantDTO
{
    public $id;
    public $subId;
    public $firstName;
    public $lastName;
    public $fullName;
    public $vaOption;
    public $merchantCode;
    public $paymentMethodDTOs = [];

    public function __construct($id, $subId, $firstName, $lastName, $fullName, $vaOption, $merchantCode, $paymentMethodDTOs = [])
    {
        $this->id = $id;
        $this->subId = $subId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->fullName = $fullName;
        $this->vaOption = $vaOption;
        $this->merchantCode = $merchantCode;
        $this->paymentMethodDTOs = $paymentMethodDTOs;
    }

    public static function fromObject($merchantObject): MerchantDTO
    {
        $paymentMethodDTOs = collect($merchantObject->paymentMethodDTOs)->map(function($paymentMethodObject) {
            return PaymentMethodDTO::fromObject($paymentMethodObject);
        })->toArray();

        return new self(
            $merchantObject->id,
            $merchantObject->subId,
            $merchantObject->firstName,
            $merchantObject->lastName,
            $merchantObject->fullName,
            $merchantObject->vaOption,
            $merchantObject->merchantCode,
            $paymentMethodDTOs,
        );
    }
}

<?php

namespace App\Repositories\DTOs;

class PaymentMethodDTO
{
    public $id;
    public $priority;
    public $code;
    public $name;
    public $mgpCode;
    public $mgpBankCode;
    public $images;
    public $fix;
    public $rate;
    public $onDisplay;
    public $isRequired;

    public function __construct($methodId, $fixedFee, $ratedFee)
    {
        $paymentMethods = config('client.payment_methods');
        if (!empty($paymentMethods[$methodId])) {
            $currentMethod = $paymentMethods[$methodId];

            $this->id = $currentMethod['id'];
            $this->priority = $currentMethod['priority'];
            $this->code = $currentMethod['code'];
            $this->name = $currentMethod['name'];
            $this->mgpCode = $currentMethod['mgpCode'];
            $this->mgpBankCode = $currentMethod['mgpBankCode'];
            $this->images = collect($currentMethod['images'])->map(function ($image) {
                return url($image);
            })->toArray();
            $this->fix = $fixedFee;
            $this->rate = $ratedFee;
            $this->onDisplay = $currentMethod['onDisplay'];
            $this->isRequired = $currentMethod['isRequired'];
        }
    }

    public static function fromObject($paymentMethodObject): PaymentMethodDTO
    {
        return new self(
            $paymentMethodObject->id,
            $paymentMethodObject->fix,
            $paymentMethodObject->rate,
        );
    }
}

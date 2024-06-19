<?php

namespace App\Services\Merchant;

use Illuminate\Support\Facades\Log;

class MerchantService
{
    private $merchantSessionService;

    public function __construct(MerchantSessionService $merchantSessionService)
    {
        $this->merchantSessionService = $merchantSessionService;
    }

    public function setNewMerchantSession() {
        $this->merchantSessionService->setSession(
            ['partnerCode' => request()->partnerCode ?? env("PARTNER_CODE_UUVIET")]
        );
    }

    public function getCurrentMerchantCode(): ?string
    {
        return $this->merchantSessionService->getCurrentKey();
    }
}

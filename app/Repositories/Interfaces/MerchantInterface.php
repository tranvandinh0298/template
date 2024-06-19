<?php

namespace App\Repositories\Interfaces;

interface MerchantInterface {
    public function getMerchantBySubIdAndPartnerCode($subId, $partnerCode);
}

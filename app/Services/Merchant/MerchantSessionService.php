<?php

namespace App\Services\Merchant;

use App\Traits\SessionTrait;

class MerchantSessionService {
    use SessionTrait;
    public function __construct() {
        $this->sessionLabel = config('client.partner_session');
        $this->keyLabel = 'partnerCode';
    }
}


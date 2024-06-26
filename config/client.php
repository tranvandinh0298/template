<?php

return [
    'customer_session' => env('CUSTOMER_SESSION', 'customer'),
    'partner_session' => env("PARTNER_SESSION", 'partner'),
    'partners' => [
        strtoupper(env("PARTNER_CODE_UUVIET")) => [
            'key_hash' => 'key_hash_uuviet_123456',
            'key_triple_des' => 'tP@1BHAjjlp42JzO'
        ],
    ],
    'core' => [
        'get_partner_url' => env("GET_PARTNER_URL"),
        'check_bill_url' => env("CHECK_BILL_URL"),
        'paying_bill_url' => env("PAYING_BILL_URL"),
    ],
    'payment_methods' => [
        1 => [
            'id' => 1,
            'priority' => 1,
            'code' => 'ATM',
            'name' => 'Thẻ ATM',
            'mgpCode' => 'DC',
            'mgpBankCode' => '',
            'images' => [
                'images/payment_method_atm.png'
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => true,
            'isRequired' => true,
        ],
        5 => [
            'id' => 5,
            'priority' => 2,
            'code' => 'DEPOSIT_CODE',
            'name' => 'Chuyển khoản',
            'mgpCode' => 'VA',
            'mgpBankCode' => '',
            'images' => [
                'images/payment_method_deposit_code.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => true,
            'isRequired' => true,
        ],
        4 => [
            'id' => 4,
            'priority' => 3,
            'code' => 'MOMO',
            'name' => 'Ví MoMo',
            'mgpCode' => 'EW',
            'mgpBankCode' => 'MOMO',
            'images' => [
                'images/payment_method_momo.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        3 => [
            'id' => 3,
            'priority' => 4,
            'code' => 'ZALOPAY',
            'name' => 'Ví ZaloPay',
            'mgpCode' => 'EW',
            'mgpBankCode' => 'ZALO',
            'images' => [
                'images/payment_method_zalo.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        7 => [
            'id' => 7,
            'priority' => 5,
            'code' => 'SHOPEEPAY',
            'name' => 'Ví ShopeePay',
            'mgpCode' => 'EW',
            'mgpBankCode' => 'SHPP',
            'images' => [
                'images/payment_method_shopee.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        8 => [
            'id' => 8,
            'priority' => 6,
            'code' => 'VIETTEL_MONEY',
            'name' => 'Ví Viettel Money',
            'mgpCode' => 'EW',
            'mgpBankCode' => 'VTTP',
            'images' => [
                'images/payment_method_viettel_money.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        2 => [
            'id' => 2,
            'priority' => 7,
            'code' => 'CREDIT',
            'name' => 'Thẻ quốc tế phát hành trong nước',
            'mgpCode' => 'IC',
            'mgpBankCode' => '',
            'images' => [
                'images/payment_method_visa.png',
                'images/payment_method_jcb.png',
                'images/payment_method_mastercard.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        10 => [
            'id' => 10,
            'priority' => 8,
            'code' => 'CREDIT_OVERSEA',
            'name' => 'Thẻ quốc tế phát hành nước ngoài',
            'mgpCode' => 'IC',
            'mgpBankCode' => '',
            'images' => [
                'images/payment_method_visa.png',
                'images/payment_method_jcb.png',
                'images/payment_method_mastercard.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        9 => [
            'id' => 9,
            'priority' => 9,
            'code' => 'VNPAY_QR',
            'name' => 'Mã VNPAY-QR',
            'mgpCode' => 'QR',
            'mgpBankCode' => '',
            'images' => [
                'images/payment_method_vnpay.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        13 => [
            'id' => 13,
            'priority' => 13,
            'code' => 'HOMECREDIT',
            'name' => 'Trả sau HomeCredit',
            'mgpCode' => 'PL',
            'mgpBankCode' => 'HMCM',
            'images' => [
                'images/payment_method_homecredit.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],
        14 => [
            'id' => 14,
            'priority' => 14,
            'code' => 'KREDIVO',
            'name' => 'Trả sau Kredivo',
            'mgpCode' => 'PL',
            'mgpBankCode' => 'KRED',
            'images' => [
                'images/payment_method_kredivo.png',
            ],
            'fix' => 0,
            'rate' => 0,
            'onDisplay' => false,
            'isRequired' => false,
        ],

    ],
];

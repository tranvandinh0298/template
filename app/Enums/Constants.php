<?php

declare(strict_types=1);

/**
 * Transaction status
 */
const TRANS_STATUS_SUCCESS = 1;
const TRANS_STATUS_FAILED = 3;
const TRANS_STATUS_WAITING = 4;
const TRANS_STATUS_PENDING = 0;
const ALLOWED_UPDATE_TRANSACTION_FIELDS = [
    'mgpId', 'status', 'mgpStatus', 'mgpMsg', 'mgpSuccessTime', 'mgpResponseCode', 'note','bankCode', 'bankName', 'note'
];

/**
 * Transaction MGP status
 */
const TRANS_MGP_STATUS_SUCCESS = '00_000';
const TRANS_MGP_STATUS_PENDING = '99';
const TRANS_MGP_STATUS_WAITING = '00_005';
const TRANS_MGP_STATUS = [-3, -2, -1, 0, 1, 2, 5];
const PAYMENT_METHOD_DEPOSIT_CODE_ID = 5;

/**
 * Bill status
 */
const ALLOW_BILL_PAYMENT = 0;
const COMPLETED_BILL_PAYMENT = 1;
const DENY_BILL_PAYMENT = 2;

/**
 * Core return code
 */
const CORE_SUCCESS_CODE = 200;
const CORE_FAILED_CODE = 11;
const CORE_PENDING_CODE = 422;

const RECORD_ACTIVE = 1;
const RECORD_INACTIVE = 0;

const BILL_PAID = 1;
const BILL_UNPAID = 0;

const CUSTOMER_FIRST_NAME = [
    'Kiên',
    'Nhật Anh',
    'Đăng Anh',
    'Thiên Bảo',
    'Gia Bảo',
    'Mạnh',
    'Nam',
    'Tài',
    'Đức',
    'Phúc Hưng',
    'Bá Hoàng',
    'Khôi Nguyên',
    'Thịnh',
    'Đạt',
    'Kiệt',
    'Hùng',
    'Tú',
    'Tâm',
    'Khang',
    'Hưng',
    'Điền',
    'An',
    'Nghĩa',
    'Nhân',
    'Lâm',
    'Minh',
    'Bảo',
    'Sơn',
    'Tú',
    'Thắng',
    'Phú',
    'Khiêm',
    'Vinh',
    'Việt'
];
const CUSTOMER_LAST_NAME = [
    'Nguyễn',
    'Trần',
    'Lê',
    'Phạm',
    'Hoàng',
    'Huỳnh',
    'Phan',
    'Vũ',
    'Võ',
    'Đặng',
    'Bùi',
    'Đỗ',
    'Hồ',
    'Ngô',
    'Dương',
    'Lý'
];
const CUSTOMER_MIDDLE_NAME = [
    'Anh',
    'Bảo',
    'Bình',
    'Công',
    'Quang',
    'Chí',
    'Tuấn',
    'Văn',
    'Thành',
    'Trung',
    'Nhật',
    'Mạnh',
    'Ngọc',
    'Tâm',
    'Trọng',
    'Khải',
    'Phan',
    'Liêm',
    'Quốc',
    'Quý',
    'Huy',
    'Quốc',
    'Gia',
    'Nam',
    'Minh',
    'Vĩnh',
    'Tùng',
    'Bình',
    'Hải',
    'Lâm',
    'Giang',
    'Hiểu'
];
const CUSTOMER_ADDRESS = [
    'Lá 1, Mầm non',
    'Lá 2, Mầm non',
    'Lá 3, Mầm non',
    'Lá 4, Mầm non',
    'Lá 5, Mầm non',
    'Lá 6, Mầm non',
    '1A Tiểu học',
    '1B Tiểu học',
    '1C Tiểu học',
    '1D Tiểu học',
    '2A Tiểu học',
    '2B Tiểu học',
    '2C Tiểu học',
    '2D Tiểu học',
    '3A Tiểu học',
    '3B Tiểu học',
    '3C Tiểu học',
    '3D Tiểu học',
    '4A Tiểu học',
    '4B Tiểu học',
    '4C Tiểu học',
    '4D Tiểu học',
    '5A Tiểu học',
    '5B Tiểu học',
    '5C Tiểu học',
    '5D Tiểu học',
    '6A Trung học',
    '6B Trung học',
    '6C Trung học',
    '6D Trung học',
];

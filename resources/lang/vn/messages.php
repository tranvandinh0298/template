<?php

return [
    'contract_no' => [
        'required' => 'Mã khách hàng (contractNo) là bắt buộc',
        'qr_required' => 'Mã QR không hợp lệ',
        'invalid' => 'Mã khách hàng (contractNo) không hợp lệ, vui lòng thử lại',
        'unable_to_decrypt_triple_des' => 'Không thể giải mã token dành cho QR',
        'unable_to_encrypt_triple_des' => 'Không thể mã hóa token dành cho QR',
    ],
    'partner' => [
        'missing_key_hash' => 'Key hash của đối tác đang thiếu',
    ],
    'bill' => [
        'required' => 'Cần chọn tối thiểu 1 hóa đơn để thanh toán',
        'invalid' => 'Danh sách hóa đơn đã chọn không hợp lệ, vui lòng kiểm tra lại',
        'array_format' => 'Danh sách hóa đơn đã chọn không đúng định dạng, vui lòng kiểm tra lại'
    ],
    'payment_method' => [
        'required' => 'Cần chọn 1 phương thức thanh toán để tiếp tục',
        'invalid' => 'Phương thức thanh toán không hợp lệ, vui lòng thử lại',
        'non_existent' => 'Phương thức thanh toán không hợp lệ, vui lòng thử lại'
    ],
    'megapay' => [
        'missing_config' => 'Thiếu cấu hình MID',
        'timeout' => 'Không thể kết nối đến Megapay',
        'empty_data' => 'Dữ liệu nhận về từ MGP rỗng',
        'failed_token' => 'Xác thực token Megapay thất bại',
        'result' => [
            'success' => 'Thanh toán thành công',
            'waiting' => 'Tạo mã nộp tiền thành công, chờ thanh toán',
            'pending' => 'Giao dịch đang được xử lý',
            'failure' => 'Giao dịch thất bại',
        ],
    ],
    'client_transaction' => [
        'not_found' => 'Không tìm thấy giao dịch',
    ],
    'core_portal' => [
        'timeout' => 'Không thể thực hiện kết nối đến Core Portal',
        'missing_return_code' => 'Core Portal không trả về Return Code',
        'missing_data' => 'Core Portal không trả về Data',
    ],
    'error' => [
        'server_error' => 'Xảy ra lỗi trên hệ thống, vui lòng thử lại sau'
    ],
];

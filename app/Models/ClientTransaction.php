<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientTransaction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_no',
        'customer_name',
        'customer_address',
        'sub_id',
        'merchant_code',
        'trx_id',
        'mgp_id',
        'reference_id',
        'amount',
        'fixed_fee',
        'rated_fee',
        'financial_fee',
        'total_amount',
        'method_id',
        'status',
        'mgp_status',
        'reference_status',
        'mgp_msg',
        'reference_msg',
        'mgp_success_time',
        'reference_success_time',
        'mgp_response_code',
        'reference_response_code',
        'bank_code',
        'bank_name',
        'va_number',
        'va_name',
        'va_start_date',
        'va_end_date',
        'va_qr_code',
        'va_content',
        'note',
    ];

    public function clientTransactionDetails(): HasMany
    {
        return $this->hasMany(ClientTransactionDetail::class, 'transaction_id', 'id');
    }

    /**
     * Get the VA QR code
     *
     * @param string|null $value
     * @return string|null
     */
    public function getVaQrCodeAttribute(?string $value): ?string
    {
        return $value ? "data:image/png;base64,".$value : null;
    }
}

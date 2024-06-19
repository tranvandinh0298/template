<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('client_transactions')) {
            Schema::create('client_transactions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('contract_no', 50)->index()->comment('Mã hóa đơn/ bill ID/ Mã khách hàng');
                $table->string('customer_name', 100);
                $table->string('customer_address', 200);
                $table->string('sub_id', 50)->comment('mã 1 đơn vị của đối tác');
                $table->string('merchant_code', 50)->comment('Mã đối tác định nghĩa trên hệ thống Portal');
                $table->string('trx_id', 100)->unique()->comment('Mã giao dịch của Portal');
                $table->string('mgp_id', 100)->nullable()->comment('Mã giao dịch của MGP');
                $table->string('reference_id', 100)->nullable()->comment('Mã giao dịch của đối tác');
                $table->double('amount')->default(0)->comment('Số tiền hóa đơn');
                $table->double('fixed_fee')->default(0)->comment('Phí thanh toán cố định (phí xử lý giao dịch)');
                $table->double('rated_fee')->default(0)->comment('phí thanh toán theo % (phí thanh toán)');
                $table->double('financial_fee')->default(0)->comment('Phí thanh toán từ đơn vị tài chính');
                $table->double('total_amount')->default(0)->comment('Tổng số tiền giao dịch');
                $table->integer('method_id')->comment('Mã PTTT');
                $table->tinyInteger('status')->default(0)->comment('0: đang chờ xử lý, 1: thanh toán thành công, 3: thanh toán thất bại, 4: đang chờ nạp tiền');
                $table->tinyInteger('mgp_status')->nullable()->comment('0: đang chờ xử lý, 1: thanh toán thành công, 3: thanh toán thất bại, 4: đang chờ nạp tiền');
                $table->tinyInteger('reference_status')->nullable()->comment('0: đang chờ xử lý, 1: thanh toán thành công, 3: thanh toán thất bại, 4: đang chờ nạp tiền');
                $table->string('mgp_msg', 100)->nullable()->comment('thông tin trả về từ MGP');
                $table->string('reference_msg', 100)->nullable()->comment('thông tin trả về từ phía đối tác (nếu có)');
                $table->datetime('mgp_success_time')->nullable()->comment('Thời gian mã Portal nhận được IPN thanh toán thành công từ MGP');
                $table->datetime('reference_success_time')->nullable()->comment('Thời gian mã Portal nhận được thông báo thành công từ đối tác (nếu có)');
                $table->string('mgp_response_code', 50)->nullable()->comment('mã phản hồi trả về từ phía mgp (nếu có)');
                $table->string('reference_response_code', 50)->nullable()->comment('mã phản hồi trả về từ phía đối tác (nếu có)');
                $table->string('bank_code', 50)->nullable();
                $table->string('bank_name', 50)->nullable();
                $table->string('va_number', 50)->nullable();
                $table->string('va_name', 50)->nullable();
                $table->string('va_start_date')->nullable();
                $table->string('va_end_date')->nullable();
                $table->text('va_qr_code')->nullable();
                $table->string("va_content", 50)->nullable();
                $table->string('note', 100)->nullable();
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_transactions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("client_transaction_details")) {
            Schema::create('client_transaction_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('transaction_id');
                $table->string('bill_id', 20)->comment('Mã kỳ thanh toán, primary key của bill');
                $table->string('name', 50);
                $table->double('amount')->default(0);
                $table->text("details")->nullable();
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
        Schema::dropIfExists('client_transaction_details');
    }
}

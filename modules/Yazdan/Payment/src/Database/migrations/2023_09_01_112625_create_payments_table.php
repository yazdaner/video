<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Yazdan\Payment\Repositories\PaymentRepository;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->morphs('paymentable');
            $table->string('amount',10);
            $table->string('invoice_id');
            $table->string('gateway');
            $table->enum('status',PaymentRepository::$confirmationStatuses);
            $table->unsignedTinyInteger('seller_percent');
            $table->string('seller_share',10);
            $table->string('site_share',10);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

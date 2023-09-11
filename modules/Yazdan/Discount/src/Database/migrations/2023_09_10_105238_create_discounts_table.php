<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Yazdan\Discount\App\Policies\DiscountPolicy;
use Yazdan\Discount\Repositories\DiscountRepository;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId("user_id");
            $table->foreign("user_id")->references('id')->on('users')->onDelete('CASCADE');

            $table->string("code")->nullable();

            $table->enum("type", [DiscountRepository::$types])
            ->default(DiscountRepository::TYPE_ALL);

            $table->unsignedTinyInteger("percent");
            $table->unsignedBigInteger("usage_limitation")->nullable(); // null means unlimited
            $table->timestamp("expire_at")->nullable();
            $table->string("link", 300)->nullable();
            $table->string("description")->nullable();
            $table->unsignedBigInteger("uses")->default(0);
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
        Schema::dropIfExists('discounts');
    }
}

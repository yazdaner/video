<?php

use Yazdan\User\App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Yazdan\User\Repositories\UserRepository;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('username', 50)->nullable();
            $table->string('mobile', 14)->nullable();

            $table->string('headline')->nullable();
            $table->text('bio')->nullable();

            $table->string('telegram')->nullable();
            $table->string('ip')->nullable();

            $table->string('card_number', 16)->nullable();
            $table->string('shaba', 24)->nullable();

            $table->foreignId('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('media')->onDelete('set null');

            $table->enum('status', UserRepository::$statuses)->default(UserRepository::STATUS_ACTIVE);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

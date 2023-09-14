<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Yazdan\Course\Repositories\LessonRepository;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('CASCADE');

            $table->foreignId('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('SET NULL');

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->foreignId('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('SET NULL');

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->unsignedTinyInteger('time')->nullable();
            $table->unsignedInteger('priority')->nullable();


            $table->enum('type', LessonRepository::$types)
            ->default(LessonRepository::TYPE_CASH);

            $table->enum('confirmation_status',LessonRepository::$confirmationStatuses)
            ->default(LessonRepository::CONFIRMATION_STATUS_PENDING);


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
        Schema::dropIfExists('lessons');
    }
}

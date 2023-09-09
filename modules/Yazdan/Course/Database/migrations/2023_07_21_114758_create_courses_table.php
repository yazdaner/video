<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Yazdan\Course\Repositories\CourseRepository;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->foreignId('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');

            $table->foreignId('banner_id')->nullable();
            $table->foreign('banner_id')->references('id')->on('media')->onDelete('SET NULL');

            $table->string('title');
            $table->string('slug')->unique();
            $table->float('priority')->nullable();
            $table->string('price', 10);
            $table->string('percent', 5);
            $table->enum('type', CourseRepository::$types);
            $table->enum('status', CourseRepository::$statuses);
            $table->enum('confirmation_status',CourseRepository::$confirmationStatuses)
                ->default(CourseRepository::CONFIRMATION_STATUS_PENDING);
            $table->longText('body')->nullable();
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
        Schema::dropIfExists('courses');
    }
}

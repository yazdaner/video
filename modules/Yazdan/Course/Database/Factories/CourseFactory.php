<?php

namespace Yazdan\Course\Database\Factories;

use Yazdan\User\App\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Yazdan\Course\App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Yazdan\Category\App\Models\Category;
use Yazdan\Media\Services\MediaFileService;
use Yazdan\Course\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Yazdan\RolePermissions\Repositories\RoleRepository;

class CourseFactory extends Factory
{

    protected $model = Course::class;

    public function definition()
    {
        return [
            "title" =>  $this->faker->title(),
            "slug" => $this->faker->slug(),
            "priority" => random_int(1,100),
            "price" => random_int(10000,1000000),
            "percent" => random_int(1,100),
            "teacher_id" => User::factory()->create()->assignRole(RoleRepository::ROLE_TEACHER)->id,
            "type" => collect(CourseRepository::$types)->random(),
            "status" => collect(CourseRepository::$statuses)->random(),
            "category_id" => Category::factory()->create()->id,
            "body" => $this->faker->text(),
            'banner_id' => MediaFileService::publicUpload(UploadedFile::fake()->image(uniqid().'.jpg'))->id
        ];
    }

}

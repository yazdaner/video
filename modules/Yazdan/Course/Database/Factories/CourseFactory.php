<?php

namespace Yazdan\Course\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Yazdan\Category\App\Models\Category;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Media\Services\MediaFileService;
use Yazdan\RolePermissions\Repositories\RoleRepository;
use Yazdan\User\App\Models\User;

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

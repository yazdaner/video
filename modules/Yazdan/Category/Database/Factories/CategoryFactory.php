<?php

namespace Yazdan\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Yazdan\Category\App\Models\Category;

class CategoryFactory extends Factory
{

    protected $model = Category::class;

    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'slug' => $this->faker->slug(),
            'parent_id' => null,
        ];
    }


    public function subCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Category::factory()->create()->id,
            ];
        });
    }
}

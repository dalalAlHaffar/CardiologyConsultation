<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->text(200),
            'brief_description' => $this->faker->text(200),
            'category_id' => rand(1,4),
            'views' => rand(1,1000),
            'image' =>$this->faker->imageUrl($width = 640, $height = 480),
            'user_id' =>1, // password
        ];
    }

}

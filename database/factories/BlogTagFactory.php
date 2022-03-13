<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\BlogTag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogTagFactory extends Factory
{
    protected $model = BlogTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'blog_id' => rand(Blog::min('id'),Blog::max('id')),
        ];
    }

}

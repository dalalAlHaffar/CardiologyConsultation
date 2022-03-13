<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Consulate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConsulateFactory extends Factory
{
    protected $model = Consulate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->text(500),
            'medical_history' => $this->faker->text(200),
            'user_id' =>2, // password
        ];
    }

}

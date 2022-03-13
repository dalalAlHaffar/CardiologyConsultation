<?php

namespace Database\Seeders;

use App\Models\Consulate;
use Illuminate\Database\Seeder;

class ConsoluteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Consulate::factory()->count(20)->create();
    }
}

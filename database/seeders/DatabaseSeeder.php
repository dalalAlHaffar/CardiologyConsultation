<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Blog::factory(100)->create();
        $this->call([
            CategoryTableSeeder::class,
            BlogTableSeeder::class,
            BlogTagTableSeeder::class,
            BlogCommentTableSeeder::class,
        ]);

    }
}

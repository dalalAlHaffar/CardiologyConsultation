<?php

namespace Database\Seeders;

use App\Models\BlogComment;
use App\Models\BlogTag;
use Illuminate\Database\Seeder;

class BlogCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogComment::factory()->count(150)->create();
    }
}

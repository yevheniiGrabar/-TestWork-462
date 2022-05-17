<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Database\Factories\CategoryPostFactory;
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
        Post::factory(100)->create();
        Category::factory(5)->create();

        $this->call([
            CategoryPostSeeder::class
        ]);
    }
}

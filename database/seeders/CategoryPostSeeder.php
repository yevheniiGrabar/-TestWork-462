<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        $posts = Post::all();
        foreach ($categories as $category) {
            foreach ($posts as $post) {
                DB::table('category_post')->insert([
                    'category_id' => $category->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryPostFactory extends Factory
{

    public function definition()
    {
        DB::table('category_post')->insert([
            'category_id' => Category::query()->select('id')->orderByRaw("RAND()")->first()->id,
            'post_id' => Post::query()->select('id')->orderByRaw("RAND()")->first()->idm
        ]);
    }
}

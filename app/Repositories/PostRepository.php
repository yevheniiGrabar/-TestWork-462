<?php

namespace App\Repositories;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class PostRepository
{
    /** @var Post */
    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return LengthAwarePaginator
     * @noinspection PhpRedundantOptionalArgumentInspection
     */
    public function getPosts(): LengthAwarePaginator
    {
        $post = $this->post->newQuery();
        $post->select('*');

//        $post->whereRaw("1 = 1");

        //filters by id
        if (request()->filled('id')) {
            $post->where('id', '=', request('id'));
        }
        //filters by title
        if (request()->filled('title')) {
            $post->where('title', '=', request('title'));
        }
        //filter by description
        if (request()->filled('description')) {
            $post->where('description', '=', request('description'));
        }
        //filters by content
        if (request()->filled('content')) {
            $post->where('content', '=', request('content'));
        }
        //search
        if (request()->filled('search_query')) {
            $post->where(function ($query) {
                $query->where('id', '=', request('search_query'));
                $query->orWhere('title', 'LIKE', '%', request('search_query') . '%');
                $query->orWhere('content', 'LIKE', '%', request('search_query') . '%');
                $query->orWhere('description', 'LIKE', '%', request('search_query') . '%');
            });
        }
        //sorting by id,title,description,content,views
        if (in_array(request('sort_order'), array('asc', 'desc')) && request('order_by') != '') {
            switch (request('order_by')) {
                case 'id':
                    $post->orderBy('id', request('sort_order'));
                    break;
                case 'title':
                    $post->orderBy('title', request('sort_order'));
                    break;
                case 'description':
                    $post->orderBy('description', request('sort_order'));
                    break;
                case 'content':
                    $post->orderBy('content', request('sort_order'));
                    break;
                case 'views':
                    $post->orderBy('views', request('sort_order'));
                    break;
            }
        } else {
            //default sorting
            $post->orderBy('id', 'asc');
        }
        return $post->paginate(5);
    }

    /**
     *
     * @param $input
     * @return Post
     */
    public function createPost($input): Post
    {
        $categoryIds = $input['category_id'];
        $post = Post::create($input);
        $post->categories()->attach($categoryIds);
        $post->save();
//        }

        return $post;
    }

    /**
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getPostById(int $id): Model|Collection|Builder|array|null
    {
        return Post::query()->with('categories')->find($id);
    }

    public function updatePost($input, $id)
    {

        $post = Post::query()->find($id);
        $post = $post->update($input);

        return $post;
    }

    public function deletePost(int $id)
    {
        return Post::query()->find($id)->delete();
    }
}

<?php

namespace App\Repositories;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostRepository
{

    /**
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getPostById(int $id): Model|Collection|Builder|array|null
    {

        return Post::query()->with('categories')->find($id);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPosts(): LengthAwarePaginator
    {
        return Post::query()->with('categories')->paginate(10);
    }

    /**
     * @param PostStoreRequest $postStoreRequest
     * @return Post
     */
    public function createPost(PostStoreRequest $postStoreRequest): Post
    {
        $post = new Post();
        $categoryIds = $postStoreRequest->get('category');
        $post->title       = $postStoreRequest->get('title');
        $post->description = $postStoreRequest->get('description');
        $post->content     = $postStoreRequest->get('content');
        $post->categories()->attach($categoryIds);

        if ($postStoreRequest->hasFile('image')) {
            $file = $postStoreRequest->file('image');
            $imageFileName = $file->getClientOriginalName();
            $path = public_path() . 'uploads/images';
            $file->move($path, $imageFileName);
            $post->image       = $postStoreRequest->file('image');
            $post->save();
        }
        return $post;
     }

    /**
     * @param PostUpdateRequest $postUpdateRequest
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function updatePost(PostUpdateRequest $postUpdateRequest, $id): Model|Collection|Builder|array|null
    {

        $post = Post::query()->find($id);
        $post->update($postUpdateRequest->validated());


        return $post;
    }

    public function deletePost(int $id)
    {
        return Post::query()->find($id)->delete();
    }
}

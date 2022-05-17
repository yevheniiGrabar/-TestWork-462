<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class PostController extends Controller
{

    /** @var PostRepository */
    public PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $posts = $this->postRepository->getPosts($request);

        return new JsonResponse($posts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PostStoreRequest $request
     * @return JsonResponse
     */
    public function store(PostStoreRequest $request): JsonResponse
    {
        $newPost = $this->postRepository->createPost($request);

        return new JsonResponse($newPost);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
         $post = $this->postRepository->getPostById($id);

        return new JsonResponse($post);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PostUpdateRequest $request, int $id): JsonResponse
    {
        $post = $this->postRepository->updatePost($request, $id);

        if (!$post) {
            return new JsonResponse(['errors' => 'Something wrong'], 422);
        }

        return new JsonResponse($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $post = $this->postRepository->deletePost($id);

        if (!$post) {
            return new JsonResponse(['errors' => 'Something  wrong'], 422);
        }

        return new JsonResponse($post);
    }
}

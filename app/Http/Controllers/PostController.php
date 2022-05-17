<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->getPosts();

        return new JsonResponse($posts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title'       => 'required|min:3|max:100',
            'description' => 'required|min:3|max:150',
            'content'     => 'required|min:3|max:255',
            'status'      =>  'boolean',
        ]);
        if($validator->fails()){
            return new JsonResponse(['Validation Error.', $validator->errors()]);
        }
        $newPost = $this->postRepository->createPost($input);

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

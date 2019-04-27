<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostsController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $posts = PostResource::collection(Post::paginate(10));
        return $this->apiResponse($posts);
    }

    public function show(Post $post)
    {
        $post->findOrFail($post);
            return $this->apiResponse(New PostResource($post));

    }

    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 422);
        }

        $posts = Post::create($request->all());
        if ($posts) {
            return $this->apiResponse(New PostResource($posts), null, 201);
        }
        return $this->apiResponse(null, 'unknown error', 520);
    }

    public function update(Post $post, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);
        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 422);
        }

        $post->findOrFail($post);

        $post->update($request->all());

        if ($post) {
            return $this->apiResponse(New PostResource($post), null, 201);
        }
        return $this->apiResponse(null, 'unknown error', 520);
    }

}

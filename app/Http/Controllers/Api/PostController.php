<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Helpers\UploadHelper;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('files')->get();
        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated(); 
          
        $post = Post::create($validated); 

        if(!empty($validated['images'])) { 
            UploadHelper::uploadPostFiles($request, $post);
        } 

        return new PostResource($post); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {     
        return new PostResource($post); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated(); 

        $post->update($validated);  
 
        if(!empty($validated['files'])) {
            UploadHelper::deleteOldPostFiles($post);
            UploadHelper::uploadPostFiles($request, $post);
        }

        return new PostResource($post); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
 
        return response()->noContent();
    }
}

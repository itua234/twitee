<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\{
    User, Post
};
use App\Util\CustomResponse;
use App\Interfaces\IPostInterface;
use Illuminate\Support\Facades\{   
    DB
};
use Illuminate\Http\Request;
use App\Http\Requests\CreatePost;
use App\Http\Resources\PostResource;


class PostRepository implements IPostInterface
{
    public function getAll()
    {
        $post = Post::with('comments')->get();
        $post = PostResource::collection($post);
        return CustomResponse::success('All Posts: ', $post);
    }

    public function create(CreatePost $request)
    {
        $user = auth()->user();
        try{
            $post = Post::create([
                'user_id' => $user->id,
                'content' => $request->content
            ]);
            $message = 'Post created successfully';
            return CustomResponse::success($message, new PostResource($post));
        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }
    }

    public function getById($id)
    {
        try{
            $post = Post::find($id);
            if(!$post) return CustomResponse::error('No post wih ID:'.$id.'exist', 404);
            return CustomResponse::success('Post detail:', new PostResource($post));
        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }
    }

    public function delete($id)
    {
        $user = auth()->user();
        try{
            $post = Post::find($id);
            if(!$post) return CustomResponse::error('Post does not exist', 404);

            if($user->id !== $post->user_id):
                $message = "You don't have access to delete this post:".$post->content."!";
                return CustomResponse::error($message, 403);
            endif;

            $post->delete();
            return CustomResponse::success('Post deleted', null, 204);
        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }
    }

}
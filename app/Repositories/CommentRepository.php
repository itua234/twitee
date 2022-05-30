<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\{
    User, Post, Comment
};
use App\Util\CustomResponse;
use App\Interfaces\ICommentInterface;
use Illuminate\Support\Facades\{   
    DB
};
use Illuminate\Http\Request;
use App\Http\Requests\CreateComment;
use App\Http\Resources\CommentResource;


class CommentRepository implements ICommentInterface
{
    public function create(CreateComment $request, $post_id)
    {
        $user = auth()->user();
        try{
            $comment = Comment::create([
                'user_id' => $user->id,
                'post_id' => $post_id,
                'comment_text' => $request->comment_text
            ]);
            $message = 'Comment created successfully';
            return CustomResponse::success($message, new CommentResource($comment));
        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }
    }

    public function delete($post_id, $id)
    {
        $user = auth()->user();
        try{
            $comment = Comment::find($id);
            $post = Post::find($post_id);
            if(!$post || !$comment) return CustomResponse::error('Rating or book does not exist', 404);
            
            if(!$post && !$comment) return CustomResponse::error('Rating and book does not exist', 404);

            if($user->id != $post->user_id):
                $message = "You don't have access to delete this rating!";
                return CustomResponse::error($message, 403);
            endif;

            $comment->delete();
            return CustomResponse::success('Comment deleted', null, 204);
        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }
    }

}
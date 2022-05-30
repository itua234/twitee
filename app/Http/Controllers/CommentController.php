<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ICommentInterface;
use App\Http\Requests\CreateComment;

/** 
* @group Comment
*
*API endpoints for managing Comment
*/

class CommentController extends Controller
{
    protected $commentInterface;

    public function __construct(ICommentInterface $commentInterface)
    {
        $this->commentInterface = $commentInterface;
    }
    
    public function create(CreateComment $request, $post_id)
    {
        return $this->commentInterface->create($request, $post_id);
    }

    public function delete($post_id, $id)
    {
        return $this->commentInterface->delete($post_id, $id);
    }
}

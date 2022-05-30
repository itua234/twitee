<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\CreateComment;

interface ICommentInterface
{
    public function create(CreateComment $request, $post_id);

    public function delete($post_id, $id);
}
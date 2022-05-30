<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePost;

interface IPostInterface
{
    public function getAll();

    public function create(CreatePost $request);

    public function getById($id);

    public function delete($id);
}
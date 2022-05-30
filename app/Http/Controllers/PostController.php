<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\IPostInterface;
use App\Http\Requests\CreatePost;

/** 
* @group Post
*
*API endpoints for managing Post
*/

class PostController extends Controller
{
    protected $postInterface;

    public function __construct(IPostInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }
    
    public function getAll()
    {
        return $this->postInterface->getAll();
    }

    public function create(CreatePost $request)
    {
        return $this->postInterface->create($request);
    }

    public function getById($id)
    {
        return $this->postInterface->getById($id);
    }

    public function delete($id)
    {
        return $this->postInterface->delete($id);
    }
}

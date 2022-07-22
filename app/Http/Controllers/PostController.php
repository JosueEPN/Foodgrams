<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Comments;
use App\Models\Likes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private $post;
    private $comments;
    private $likes;

    public function __construct(Posts $post,Comments $comments, Likes $likes){
        $this->post = $post;
        $this->comments = $comments;
        $this->likes = $likes;
    }
    public function index()
    {

    }

    public function create(){

        return Inertia::render('Post/CreatePost');

    }

    public function getPosts(){
        return $this->post->getPost(Auth::id());
    }





    public function store(ImageRequest $request)
    {
        Posts::createPost($request);
        return Inertia::render('Dashboard');

    }


    public function show(Posts $posts)
    {
        //
    }


    public function edit(Posts $posts)
    {
        //
    }

    public function update(Request $request, Posts $posts)
    {
        //
    }


    public function destroy(Posts $posts)
    {
        //
    }
}

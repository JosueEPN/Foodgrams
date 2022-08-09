<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Carbon\Carbon;
use App\Models\Comments;
use App\Models\Likes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\RequestEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

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
        return Inertia::render('Dashboard',[
            'posts' => Posts::getPost(Auth::id())
           ]);    
    }

    public function create(){

        return Inertia::render('Post/CreatePost');

    }

    public function getPosts(){
      
    }





    public function store(ImageRequest $request)
    {
        Posts::createPost($request);
        return redirect() -> route('dashboard');
    }


    public function show(Posts $posts)
    {
        //
    }


    public function edit()
    {
        if(request()->has("posts")){
            $PostEdit = request("posts");
        }
        return Inertia::render('Post/Edit',compact('PostEdit'));
    }

    public function update(RequestEdit $request, Posts $posts)
    {
        $editpost= $request->all();
        
        if($request->file('image')){
            Storage::delete('public'. $request->image_path);
            $file = $request->file('image');
            $name = uniqid().$file->getClientOriginalName();
            $storage = Storage::disk('public')->put($name,$file);
            $editpost['image'] = asset('storage/'.$storage);

        }else{
            unset($editpost['image']);
        }
  
        $posts->update($editpost);
        return $editpost;


        //return redirect() -> route('dashboard');
        
    }


    public function destroy(Posts $posts)
    {
        $posts->delete();
        unset($posts['image']);
        return $posts;
        //return redirect() -> route('dashboard');
    }
}

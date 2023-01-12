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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

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
        
        //return   Posts::getPost(Auth::id());
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


    public function show(Posts $post)
    {
       
         return Inertia::render('Post/Edit',[
            'PostEdit' => $post
         ]);
       
    }

    public function view(Request $request)
    {
        $id = $request->post;
       
        $post = Posts::getPostView($id);
        
        return Inertia::render('Post/View',[
            'post' => $post[0]
        ]);
       
    }

    public function update(Request $request)
    {
       $editpost = Posts::find($request->id);
         if($file = $request->file('image')){
            Storage::delete('public/'. $request->image_path);
            $file = $request->file('image');
            $name = uniqid().$file->getClientOriginalName();
            $storage = Storage::disk('public')->put($name,$file);
            $request['image_path'] = asset('storage/'.$storage);

        }else{
            unset($request['image']);
        }

        $editpost->title = $request->title;
        $editpost->image_path =$request->image_path;
        $editpost->description=$request->description;
        $editpost->ingredients= $request->ingredients;
        $editpost->portions = $request->portions;
        $editpost->date_post = Carbon::now();

  
        $editpost ->save();
        return redirect() -> route('dashboard');

       
        
    }


    public function destroy(Posts $post)
    {

        $likes = $post->likes;
        
        foreach($likes as $item) { //foreach element in $arr
            $deleteLikes = Likes::find($item['id']);
            $deleteLikes ->delete(); 
            //etc
        }
        
        $comments = $post->comments;
        

        foreach($comments as $item) { //foreach element in $arr
            $deleteComments = Comments::find($item['id']);
            $deleteComments ->delete(); 
            //etc
        }
        $url = str_replace('storage', 'public', "post");
        Storage::delete( $url,$post->image_path);
        $post->delete();
        return redirect() -> route('dashboard');        
    }

    public function likeOrDislike(Request $request){
        try {
            
            $postId = $request->post_id;
            $userId = auth()->user()->id;
    
            if($this->likes->where('post_id',$postId)->where('user_id',$userId)->exists()){
                $this->likes->deleteLike($postId,$userId);
    
                return response()->json(['like' => false,'likes' => $this->likes->where('post_id',$postId)->get()]);
            }else{
                $this->likes->like($postId,$userId);
    
                return response()->json(['like' => true,'likes' => $this->likes->where('post_id',$postId)->get()]);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }
    }

    public function comment(Request $request){
        try {
            
            $comment = $this->comments->create($request->all());

            return $this->comments->with('user:id,name,nick_name,profile_photo_path')->where('id',$comment->id)->first();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }
    }
    
}

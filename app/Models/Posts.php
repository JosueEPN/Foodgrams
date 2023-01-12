<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'description',
        'ingredients',
        'portions',
        'date_post',
        'user_id',
    ];
    public $appends = ['countComments','countLikes'];

    public function getCountCommentsAttribute(){
        return $this->comments->count();
    }

    public function getCountLikesAttribute(){
        return $this->likes->count();
    }

     public function user() {
            return $this->belongsTo(User::class);
    }

  
    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(Likes::class, 'post_id');
    }

    public static function createPost($request){
        $file = $request->file('image');
        $name = uniqid().$file->getClientOriginalName();
        $url = null;

        $storage = Storage::disk('public')->put($name,$file);
        $url = asset('storage/'.$storage);

        $post = (new static)::create([
            'title' => $request->text,
            'image_path' => $url,
            'description' => $request->text3,
            'ingredients'=> $request->text2,
            'portions' => $request->number,
            'date_post' => Carbon::now(),
            'user_id' => Auth::id(),
        ]);

        return (new static)::with([
            'user',
            'comments',
            'likes'
        ])->find($post->id);
    }

    public static function getPost($id,$profile = null){
        $querry = (new static)::with([
            'user',
            'comments' => function($query){
                $query->with('user:id,name,nick_name,profile_photo_path');
            },
            'likes'
        ])
        ->where('user_id',$id);
        if(is_null($profile)){
            $querry = $querry ->orWhereIn('user_id',Followers::select('user_id')->where('follower_id',$id)->get());
        }
        
       return $querry->orderBy('created_at','desc')
        ->get();

    }

    public static function getPostSearch($title){

        $querry = (new static)
        ->where('title' ,'like' ,'%'.$title."%")
        ->get();
      

        return $querry;
        
    }

    public static function getPostView($id)
    {
        $querry = (new static)::with( [
            'user',
            'comments' => function($query){
                $query->with('user:id,name,nick_name,profile_photo_path');
            },
            'likes'
            
        ])
        ->where('id' , '=' ,$id)
        ->get();
      

        return $querry;
    }
/*

 

*/

}

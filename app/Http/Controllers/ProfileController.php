<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use App\Models\Posts;
use App\Models\User;
use App\Notifications\NotifyFollow;
use Illuminate\Http\Request;
use Inertia\Inertia;



class ProfileController extends Controller
{
    private $user;
    private $followers;

    public function __construct(User $user, Followers $followers){
        $this->user = $user;
        $this->followers = $followers;
    }

    public function index($nick_name){
        $user = $this->user->where('nick_name',$nick_name)->first();

        $followers = $user->followers()->count();
        $followed = $this->followers->where('follower_id',$user->id)->count();
        $postsCount = $user->post()->count();
        $posts = Posts::getPost($user->id,true);

        return Inertia::render('UserProfile/index',[
            'userProfile' => $user,
            'followers' => $followers,
            'followed' => $followed,
            'postsCount' => $postsCount,
            'posts' => $posts,
        ]);
    }

    public function followUser(Request $request){

        return 'si entro al controlador';
        $user = User::find($request->user_id);

        $user->notify(new NotifyFollow(auth()->user()));

        //return $this->followers->follow($request->user_id);
    }

    public function unFollow(Request $request){
        $follow = $this->followers->where('user_id',$request->user_id)->where('follower_id',auth()->user()->id)->first();

        return $follow->delete();
    }

    public function existsFollow($user_id){
        return $this->followers->where('user_id',$user_id)->where('follower_id',auth()->user()->id)->exists()
        ? ['exists' => true] : ['exists' => false];
    }

    public function markAsRead(){
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return $user->notifications;
    }

    public function FunctionName()
    {
        # code...
    }

}

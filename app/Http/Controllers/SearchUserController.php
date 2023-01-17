<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;

class SearchUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::orderBy("id");

        if(request()->has("search")){
            $title=request("search");
            $posts = Posts::getPostSearch($title); 
        }

        

        $users = User::orderBy("id");

        if(request()->has("search")){
            $nick_name=request("search");
            $users = User::getUserSearch($nick_name);
        }

        
        //return $users;

        return Inertia::render('Search', 
        [
            'posts' => $posts,
            'users' => $users

        ]);
    }

    public function usersIFollow($nick_name){
        return User::select('id','name','nick_name','profile_photo_path')
        ->whereHas('followers',function(Builder $query){
            $query->where('follower_id',auth()->user()->id);
        })
        ->where('nick_name','like','%'.$nick_name.'%')
        ->get();
    }


   

}

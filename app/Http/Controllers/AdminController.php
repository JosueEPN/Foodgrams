<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Followers;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Chats;
use App\Models\Messages;
use App\Models\Likes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Spatie\Permission\Models\Role;
use DB;


class AdminController extends Controller 
{


    public function indexUser(){
        $users = User::get();

        

        return Inertia::render('Admin/index',[
            'users' => $users,
           
        ]);
    }
    public function indexPost(){
        $posts = Posts::get();

        return Inertia::render('Admin/indexPost',[
            'posts' => $posts,
           
        ]);
    }

    public function edit(User $user){

        $roles = Role::all();
     
        return Inertia::render('Admin/EditUser',[
            'userEdit' => $user,
            'roles' => $roles
           
        ]);
    }

    public function update( Request $request)
    {
        //return $request;
        
        $editUser = User::find($request->id);   
         $this->validate($request, [
            'nick_name' => 'string', 'max:255',  Rule::unique('users')->ignore($editUser->id),
            'presentation' =>  'nullable','string', 'max:255',
            'web_site' => 'nullable','string','max:255',
            'email' => 'required', 'email', 'max:255', Rule::unique('users')->ignore($editUser->id),
            'photo' => 'nullable', 'mimes:jpg,jpeg,png', 'max:1024',
        ]);
      
      
        if (isset($request->photo)) {
            $editUser->updateProfilePhoto($request->photo);
        } else {
            $editUser->forceFill([
                'nick_name' => $request->nick_name,
                'presentation' => $request->presentation,
                'web_site' => $request->web_site,
                'email' => $request->email,
            ])->save();
    
            
        }

        if(isset($request->role) )
        {
            $editUser->assignRole($request->role);
        }
        return to_route('index.user.admin')->with(['msg'=>'Se actualizao el usuarios']);
        
    }


    public function destroyPhoto(User $user)
    {
        
        $user->deleteProfilePhoto();

        return back(303)->with('status', 'profile-photo-deleted');
    }

    public function delete(User $user)
    {
        
        $posts = Posts::getPost($user->id);
        foreach($posts as $post) 
        {
            $likes = $post->likes;
        
            foreach($likes as $item) { //foreach element in $arr
                $deleteLikes = Likes::find($item['id']);
                $deleteLikes ->delete(); 
 
            }
            
            $comments = $post->comments;
            

            foreach($comments as $item) { 
                $deleteComments = Comments::find($item['id']);
                $deleteComments ->delete(); 

            }
            $url = str_replace('storage', 'public', "post");
            Storage::delete( $url,$post->image_path);
            $post->delete(); 

        }

        
        $messaID = Messages::getMessagesUser($user->id);
        if(count($messaID) > 0)
        {
            $allMessages = Messages::getMessagesAll($messaID[0]->chat_id);
            $idChat = $messaID[0]->chat_id;

            foreach($allMessages as $messages)
            {
                $messages->delete();
            }


            $chat = Chats::getChat($idChat);
            $chat[0]->delete();
   
        }

        $follwers = Followers::getFollow($user->id);
        if(count($follwers) > 0)
        {
            
            foreach($follwers as $follower)
            {
                $follower->delete();
            }
   
        }
        
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();

        
        
        return to_route('index.user.admin');
    }

    public function show(Posts $post, User $user)
    {
        
         return Inertia::render('Post/Edit',[
                'PostEdit' => $post
             ]);
        
       
    }

    public function destroy(Posts $post, User $user)
    {
            $likes = $post->likes;

            foreach($likes as $item) { //foreach element in $arr
                $deleteLikes = Likes::find($item['id']);
                $deleteLikes ->delete(); 
            }
            
            $comments = $post->comments;

            foreach($comments as $item) { 
                $deleteComments = Comments::find($item['id']);
                $deleteComments ->delete(); 
            }
            $url = str_replace('storage', 'public', "post");
            Storage::delete( $url,$post->image_path);
            $post->delete(); 
            return redirect() -> route('index.post.admin')->with(['msg'=>'Se borro el post']);  
    }

    public function create()
    {
        return Inertia::render('Admin/CreateUser');
    }
    public function register(Request $request)
    {
            $validated = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'nick_name' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' =>'required', 'string', new Password, 'confirmed',
                'password_confirmation' => 'required|same:password'
            ])->validate();
    
            User::create([
                'name' => $request->name,
                'nick_name' => $request->nick_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(30),
            ])->assignRole('Creador');
    
        
        
            return to_route('index.user.admin');
        
    }


    //Controlladores Admin api

    public function indexUserApi(){
        $users = User::get();

        return $users;
    }

    public function indexPostApi(){
        $posts = Posts::get();

       
            return $posts;
           
    }

    public function editUserApi(User $user){

        return $user;
     
        return Inertia::render('Admin/EditUser',[
            'userEdit' => $user,
           
        ]);
    }

    public function updateUserApi( Request $request)
    {
        $editUser = User::find($request->id);   
         $this->validate($request, [
            'nick_name' => 'string', 'max:255',  Rule::unique('users')->ignore($editUser->id),
            'presentation' =>  'nullable','string', 'max:255',
            'web_site' => 'nullable','string','max:255',
            'email' => 'required', 'email', 'max:255', Rule::unique('users')->ignore($editUser->id),
            'photo' => 'nullable', 'mimes:jpg,jpeg,png', 'max:1024',
        ]);
        
        if (isset($request->photo)) {
            $editUser->updateProfilePhoto($request->photo);
        } else {
            $editUser->forceFill([
                'nick_name' => $request->nick_name,
                'presentation' => $request->presentation,
                'web_site' => $request->web_site,
                'email' => $request->email,
            ])->save();
        }
        return with(['msg'=>'Se actualizo el usuario']);
    }



    public function deleteUserApi(User $user)
    {
        
        $posts = Posts::getPost($user->id);
        foreach($posts as $post) 
        {
            $likes = $post->likes;
        
            foreach($likes as $item) { //foreach element in $arr
                $deleteLikes = Likes::find($item['id']);
                $deleteLikes ->delete(); 
 
            }
            
            $comments = $post->comments;
            

            foreach($comments as $item) { 
                $deleteComments = Comments::find($item['id']);
                $deleteComments ->delete(); 

            }
            $url = str_replace('storage', 'public', "post");
            Storage::delete( $url,$post->image_path);
            $post->delete(); 

        }

        
        $messaID = Messages::getMessagesUser($user->id);
        if(count($messaID) > 0)
        {
            $allMessages = Messages::getMessagesAll($messaID[0]->chat_id);
            $idChat = $messaID[0]->chat_id;

            foreach($allMessages as $messages)
            {
                $messages->delete();
            }


            $chat = Chats::getChat($idChat);
            $chat[0]->delete();
   
        }

        $follwers = Followers::getFollow($user->id);
        if(count($follwers) > 0)
        {
            
            foreach($follwers as $follower)
            {
                $follower->delete();
            }
   
        }
        
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();

        
        
        return with(['msg'=>'Se elimino el usuario']);
    }
    
    public function showPostApi(Posts $post, User $user)
    {
        
         return  $post;
        
       
    }

    public function destroyPostApi(Posts $post, User $user)
    {
            $likes = $post->likes;

            foreach($likes as $item) { //foreach element in $arr
                $deleteLikes = Likes::find($item['id']);
                $deleteLikes ->delete(); 
            }
            
            $comments = $post->comments;

            foreach($comments as $item) { 
                $deleteComments = Comments::find($item['id']);
                $deleteComments ->delete(); 
            }
            $url = str_replace('storage', 'public', "post");
            Storage::delete( $url,$post->image_path);
            $post->delete(); 
            return  with(['msg'=>'Se elimino el post']);  
    }

    public function createApi()
    {
        return  with(['msg'=>'Se Ingreso a la vista']);
    }
    public function registerApi(Request $request)
    {
            $validated = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'nick_name' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' =>'required', 'string', new Password, 'confirmed',
                'password_confirmation' => 'required|same:password'
            ])->validate();
    
            User::create([
                'name' => $request->name,
                'nick_name' => $request->nick_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(30),
            ])->assignRole('Creador');
    
        
        
            return with(['msg' => 'Se registro el usuario']);
        
    }


    
    

    
}

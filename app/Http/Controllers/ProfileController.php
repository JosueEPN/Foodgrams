<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use App\Models\User;
use App\Notifications\NotifyFollow;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Chats;
use App\Models\Messages;
use App\Models\Likes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    private $user;
    private $followers;

    public function __construct(User $user, Followers $followers){
        $this->user = $user;
        $this->followers = $followers;
    }

    public function index($nick_name){
        
        $user = $this->user->where('nick_name','=',$nick_name)->first();
            if($user === null)
            {
                return redirect()->route('dashboard');
            }
            try
            {
                $followers = $user->followers()->count();                
                $followed = $this->followers->where('follower_id',$user->id)->count();
                $postsCount = $user->post()->count();
                $posts = Posts::getPost($user->id,true);
        
                
    
            }catch(\Exception $e)
            {
                return redirect()->route('dashboard');
            }

        return Inertia::render('UserProfile/index',[
            'userProfile' => $user,
            'followers' => $followers,
            'followed' => $followed,
            'postsCount' => $postsCount,
            'posts' => $posts,
        ]);

       
    }

    public function followUser(Request $request){

        $user = User::find($request->user_id);

        $user->notify(new NotifyFollow(Auth::user()));

        return $this->followers->follow($request->user_id);
    }

    public function unFollow(Request $request){
        $follow = $this->followers->where('user_id',$request->user_id)->where('follower_id','=',Auth::id())->first();

        return $follow->delete();
    }

    public function existsFollow($user_id){
        return $this->followers->where('user_id',$user_id)->where('follower_id','=',Auth::id())->exists()
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

    //Api User

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

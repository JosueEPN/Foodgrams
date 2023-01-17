<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesUsers;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Chats;
use App\Models\Messages;
use App\Models\Likes;
use Illuminate\Support\Facades\Storage;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
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
        
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
        
    }
}

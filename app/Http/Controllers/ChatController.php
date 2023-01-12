<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Models\Chats;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ChatController extends Controller
{
    private $chat;
    private $messages;

    public function __construct(Chats $chat,Messages $message){
        $this->chat = $chat;
        $this->messages = $message;
    }

    public function index(){
        $chats = $this->chat->with([
            'usersent',
            'userrecive',
            'messages' => function($query){
                $query->latest();
            }
        ])->where('user_send',auth()->user()->id)
        ->orWhere('user_recive',auth()->user()->id)
        ->get();

        return Inertia::render('Chat/index',['chats' => $chats]);
    }

    public function getChat($id){
        return $this->chat->with([
            'usersent',
            'userrecive',
            'messages'
        ])->where('id',$id)
        ->first();
    }

    public function getNewChat($id){
        $chat = $this->chat->create([
            'user_recive' => $id,
            'user_send' => auth()->user()->id,
        ]);

        return $this->getChat($chat->id);
    }
    public function checkChat($id){
        $chat = null;
        $query1 = $this->chat->select('id')->where('user_send',Auth::id())->where('user_recive',$id);
        $query2 = $this->chat->select('id')->where('user_send',$id)->where('user_recive',Auth::id());

        if(!$query1->exists()){
            if($query2->exists()){
                $chat = $query2->first();
                $chat = $this->getChat($chat->id);
            }else{
                $chat = $this->getNewChat($id);
            }
        }else{
            $chat = $this->getChat($id);
        }

        return $chat;
    }

    public function createChatIfNotExists($id){
        return $this->checkChat($id);
    }
    

    public function sendMessage(Request $request){
        $message = $this->messages->createMessage($request);

        event(new NewMessage($message));
    }

    public function sendFile(Request $request){
        $rules = $request->has('image') ? ['image' => 'required|max:5000|mimes:jpeg,jpg,png']
        : ['file' => 'required|max:5000|mimes:pdf,doc,docx,txt'];
        $messages = $request->has('image') ? ['required' => 'La imagen es requerida',
        'max' => 'La imagen no puede ser mayor a 5MB','mimes' => 'Debe ser solo tipo jpeg,jpg,png']
        : ['required' => 'El documento es requerido',
        'max' => 'El documento no puede ser mayor a 5MB','mimes' => 'Debe ser solo tipo pdf,doc,docx,txt'];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],422);
        }
        $message = $this->messages::sendFile($request);

        event(new NewMessage($message));
    }

    public function directMessage($id){
        $chat = $this->checkChat($id);

        return Inertia::render('Chat/DirectMessage',[
            'chat' => $chat
        ]);
    }

}

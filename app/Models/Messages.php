<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'file_path',
        'file_name',
        'send_date',
        'type',
    ];

   


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function chat()
    {
        return $this->belongsTo(Chats::class);
    }

    public static function createMessage($request){
        return (new static)::create([
            'chat_id' => $request->chat_id,
            'user_id' => $request->user_id,
            'message' => $request->message,
            'send_date' => Carbon::now()
        ]);
    }

    public static function getUrl($file){
        $name = $file->getClientOriginalName();
        
        $storage = Storage::disk('public')->put($name,$file);
        return asset('storage/'.$storage);
    }

    public static function sendFile($request){
        $file = $request->file('file') ? $request->file('file') : $request->file('image');

        return (new static)::create([
            'chat_id' => $request->chatid,
            'user_id' => $request->user_id,
            'type' => $request->has('image') ? 'image' : 'document',
            'file_name' => $file->getClientOriginalName(),
            'file_path' => self::getUrl($file),
            'send_date' => Carbon::now()
        ]);
    }


}

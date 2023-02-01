<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_send',
        'user_recive',
    ];

    
    public function usersent()
    {
        return $this->belongsTo(User::class,'user_send');
    }

    
    public function userrecive()
    {
        return $this->belongsTo(User::class,'user_recive');
    }

   
    public function messages()
    {
        return $this->hasMany(Messages::class,'chat_id');
    }


    public static function getChat($id)
    {
        $querry = (new static)
        ->where('id' ,'=' ,$id)
        ->get();
      

        return $querry;
    }
}

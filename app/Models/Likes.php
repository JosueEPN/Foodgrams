<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    
    public function post()
    {
        return $this->belongsTo(Posts::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function like($postId,$userId){
        return (new static)::create([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
    }

    public static function deleteLike($postId,$userId){
        (new static)::where([
            'post_id' => $postId,
            'user_id' => $userId,
        ])->delete();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',        
        'comment',
    ];

    /**
     * The roles that post to the Comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function post()
    {
        return $this->belongsTo(Posts::class);
    }

    /**
     * The roles that user to the Comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    } 


    public function getComment($id)
    {
        $querry = (new static)::with( [
            
               'name',
               'nick_name',
               'profile_photo_path'
            
            
        ])
        ->where('post_id','=',$id)
        ->get();

        return $querry;

    }
}

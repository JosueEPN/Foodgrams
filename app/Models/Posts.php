<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'description',
        'ingredients',
        'portions',
        'date_post',
        'user_id',
    ];


     public function user() {
            return $this->belongsTo(User::class);
    }

    /**
     * Get all of the comments for the posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id');
    }

    /**
     * Get all of the likes for the posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Likes::class, 'post_id');
    }

}

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
     * Get the user that owns the Likes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

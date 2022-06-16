<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    /**
     * Get the user that owns the Followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the follower that owns the Followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function follower()
    {
        return $this->belongsTo(User::class);
    }
}

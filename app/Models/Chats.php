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

    /**
     * Get the usersent that owns the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usersent()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the userrecive that owns the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userrecive()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the messages for the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Messages::class,'chat_id');
    }
}

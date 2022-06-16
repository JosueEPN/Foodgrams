<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Get the user that owns the Messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the chat that owns the Messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat()
    {
        return $this->belongsTo(Chats::class);
    }
}

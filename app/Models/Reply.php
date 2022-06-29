<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['reply_text', 'user_id', 'advertisement_id'];

    /**
     * Get the user that owns the reply.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the advertisement that owns the reply.
     */
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}

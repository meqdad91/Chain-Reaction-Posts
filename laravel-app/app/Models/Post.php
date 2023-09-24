<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;


    /**
     * define the relation between the user
     * and his posts
     * each post should belong to a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

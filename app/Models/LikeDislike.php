<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{
    use HasFactory, BelongsToUser,  SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'like',
        'dislike'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

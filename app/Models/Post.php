<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, BelongsToUser,  SoftDeletes;

    protected $fillable = [
        'user_id','content'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(LikeDislike::class, 'post_id')->sum('like');
    }

    public function dilikes()
    {
        return $this->hasMany(LikeDislike::class, 'post_id')->sum('dislike');
    }

}

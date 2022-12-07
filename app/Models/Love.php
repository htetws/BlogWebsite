<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Love extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id'];

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}

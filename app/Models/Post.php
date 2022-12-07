<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'category_id', 'view_count', 'description', 'user_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function loves()
    {
        return $this->belongsTo(Love::class, 'post_id', 'id');
    }
}

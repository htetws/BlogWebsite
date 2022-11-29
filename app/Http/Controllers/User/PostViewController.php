<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostViewController extends Controller
{
    public function post()
    {
        $posts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $order_view = Post::orderBy('view_count', 'desc')->take(3)->get();
        $categories = Category::get();
        $tags = Tag::get();
        return view('USR.blog', compact('posts', 'order_view', 'categories', 'tags'));
    }

    public function categoryFilter($slug)
    {
        $categories = Category::get();
        $tags = Tag::get();
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $posts = Post::where('category_id', $category->id)->paginate(9);
            return view('USR.filter', compact('posts', 'categories', 'tags'));
        } else {
            abort(404);
        }
    }

    public function tagFilter($slug)
    {
        $categories = Category::get();
        $tags = Tag::get();
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $posts = Post::whereHas('tag', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->paginate(9);
            return view('USR.filter', compact('posts', 'categories', 'tags'));
        } else {
            abort(404);
        }
    }
}

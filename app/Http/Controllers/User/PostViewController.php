<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostViewController extends Controller
{
    //home page
    public function post()
    {
        $posts = Post::orderBy('created_at', 'desc')->take(3)->get();
        // dd($posts->toArray());
        $order_view = Post::orderBy('view_count', 'desc')->take(6)->get();
        $categories = Category::get();
        $tags = Tag::get();
        return view('USR.blog', compact('posts', 'order_view', 'categories', 'tags'));
    }

    //filter by category
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

    //filter by tag (many to many relationship)
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

    //detail page with slug
    public function detail($slug)
    {
        $posts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $categories = Category::get();
        $tags = Tag::get();
        $post = Post::where('slug', $slug)->first();

        $nextpost = Post::where('id', '>', $post->id)->min('id');
        $prevpost = Post::where('id', '<', $post->id)->max('id');

        $next = Post::where('id', $nextpost)->first();
        $prev = Post::where('id', $prevpost)->first();

        return view('USR.detail', compact('post', 'categories', 'tags', 'posts', 'next', 'prev'));
    }

    //view count with ajax
    public function ViewCount(Request $request)
    {
        if ($request->slug) {
            $post = Post::where('slug', $request->slug)->first();
            $post->view_count +=  1;
            $post->save();
            return response()->json($post, 200);
        } else {
            abort(404);
        }
    }

    //Blog Page
    public function blog()
    {
        $categories = Category::get();
        $tags = Tag::get();
        $posts = Post::orderBy('created_at', 'asc')->when(request('s'), function ($q) {
            return $q->where('title', 'like', '%' . request('s') . '%');
        })->paginate(20);
        return view('USR.All', compact('posts', 'categories', 'tags'));
    }


    //live search by ajax
    public function searchKeyon(Request $request)
    {
        if ($request->input != '') {
            $keyon = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')->where('title', 'like', '%' . $request->input . '%')->get();
        } else {
            $keyon = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')->get();
        }
        return response()->json($keyon, 200);
    }

    //sort by ajax
    public function sortMulti(Request $request)
    {
        if ($request->value == 'view') {
            $data = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->orderBy('view_count', 'desc')->get();
        } elseif ($request->value == 'new') {
            $data = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->orderBy('created_at', 'desc')->get();
        } elseif ($request->value == 'old') {
            $data = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->orderBy('created_at', 'asc')->get();
        } elseif ($request->value == 'az') {
            $data = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->orderBy('title', 'asc')->get();
        } else {
            $data = Post::select('posts.*', 'categories.name as catname')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->orderBy('title', 'desc')->get();
        }
        return response()->json($data, 200);
    }
}

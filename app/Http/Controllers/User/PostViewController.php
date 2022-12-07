<?php

namespace App\Http\Controllers\User;

use App\Models\Tag;
use App\Models\Love;
use App\Models\Post;
use App\Models\Save;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostViewController extends Controller
{
    //home page
    public function post()
    {
        $posts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $order_view = Post::orderBy('view_count', 'desc')->take(6)->get();

        $trending = Love::orderBy('total', 'desc')->groupBy('post_id')->select('post_id', DB::raw('count(*) as total'))->take(10)->get();

        $categories = Category::get();
        $tags = Tag::get();

        if (Auth::user() != null) {
            $bookmarks = Save::where('user_id', Auth::user()->id)->get();
        } else {
            $bookmarks = null;
        }

        return view('USR.blog', compact('posts', 'order_view', 'categories', 'tags', 'bookmarks', 'trending'));
    }

    //filter by category
    public function categoryFilter($slug)
    {
        $categories = Category::get();
        $tags = Tag::get();
        $category = Category::where('slug', $slug)->first();

        //show bookmark with auth or not
        if (Auth::user() != null) {
            $bookmarks = Save::where('user_id', Auth::user()->id)->get();
        } else {
            $bookmarks = null;
        }

        if ($category) {
            $posts = Post::where('category_id', $category->id)->paginate(9);
            return view('USR.filter', compact('posts', 'categories', 'tags', 'bookmarks'));
        } else {
            abort(404);
        }
    }

    //filter by tag (many to many relationship)
    public function tagFilter($slug)
    {
        $categories = Category::get();
        $tags = Tag::get();

        //show bookmark with auth or not
        if (Auth::user() != null) {
            $bookmarks = Save::where('user_id', Auth::user()->id)->get();
        } else {
            $bookmarks = null;
        }

        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $posts = Post::whereHas('tag', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->paginate(9);
            return view('USR.filter', compact('posts', 'categories', 'tags', 'bookmarks'));
        } else {
            abort(404);
        }
    }

    //filter by user name
    public function userFilter($name)
    {
        $categories = Category::get();
        $tags = Tag::get();

        //show bookmark with auth or not
        if (Auth::user() != null) {
            $bookmarks = Save::where('user_id', Auth::user()->id)->get();
        } else {
            $bookmarks = null;
        }

        if (User::where('name', $name)->first() != null) {
            $userID = User::select('id')->where('name', $name)->first();
            $posts = Post::where('user_id', $userID->id)->paginate(9);
            return view('USR.filter', compact('posts', 'categories', 'tags', 'bookmarks'));
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

        //related post exact current id with same category
        $relPost = Post::where('slug', $slug)->first();
        $rels = Post::where('slug', '!=', $slug)->where('category_id', $relPost->category_id)->get();

        if (Post::where('slug', $slug)->first()) {
            $post = Post::where('slug', $slug)->first();
        } else {
            abort(404);
        }

        $nextpost = Post::where('id', '>', $post->id)->min('id');
        $prevpost = Post::where('id', '<', $post->id)->max('id');

        $next = Post::where('id', $nextpost)->first();
        $prev = Post::where('id', $prevpost)->first();

        //saved bookmarks
        $bookmarks = Save::where('user_id', Auth::user()->id)->get();
        //only one
        $save = Save::where('user_id', Auth::user()->id)->where('post_id', $post->id)->first();

        //react love
        $loves = Love::where('post_id', $post->id)->get();
        $love = Love::where('post_id', $post->id)->where('user_id', Auth::user()->id)->first();

        return view('USR.detail', compact('post', 'categories', 'tags', 'posts', 'next', 'prev', 'save', 'bookmarks', 'loves', 'love', 'rels'));
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

        $trending = Love::orderBy('total', 'desc')->groupBy('post_id')->select('post_id', DB::raw('count(*) as total'))->take(10)->get();

        //show bookmark with auth or not
        if (Auth::user() != null) {
            $bookmarks = Save::where('user_id', Auth::user()->id)->get();
        } else {
            $bookmarks = null;
        }

        $posts = Post::inRandomOrder()->when(request('s'), function ($q) {
            return $q->where('title', 'like', '%' . request('s') . '%');
        })->paginate(20);
        return view('USR.All', compact('posts', 'categories', 'tags', 'bookmarks', 'trending'));
    }

    //Bookmark Page
    public function bookmarkPage()
    {
        $posts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $categories = Category::get();
        $tags = Tag::get();

        $bookmarks = Save::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->paginate(20);
        return view('USR.bookmark', compact('bookmarks', 'categories', 'tags', 'posts'));
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
            // } elseif ($request->value == 'trending') {
            //     $data = Post::select('posts.*', 'loves.*')
            //         ->leftJoin('loves', 'posts.id', 'loves.post_id')->get();
            //     return $data;
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

    //Bookmark with ajax
    public function Bookmark(Request $request)
    {
        $post = Post::where('slug', $request->slug)->first();

        if ($request->status == 'save') {
            Save::create([
                'user_id' => Auth::user()->id,
                'post_id' => $post->id,
                'status' => $request->status

            ]);
            $save = Save::where('user_id', Auth::user()->id)->get();
        } else {
            Save::where('user_id', Auth::user()->id)->where('post_id', $post->id)->delete();
            $save = Save::where('user_id', Auth::user()->id)->get();
        }

        return response()->json($save, 200);
    }

    //Love post with ajax
    public function LovePost(Request $request)
    {
        $post = Post::where('slug', $request->slug)->first();
        if ($request->status == 'save') {
            Love::create(['user_id' => Auth::user()->id, 'post_id' => $post->id]);
            $love = Love::where('post_id', $post->id)->get();
        } else {
            Love::where('post_id', $post->id)->where('user_id', Auth::user()->id)->delete();
            $love = Love::where('post_id', $post->id)->get();
        }

        return response()->json($love, 200);
    }

    //Bookmark live search with ajax
    public function BookmarkSearch(Request $request)
    {
        if ($request->input != '') {
            $keyon = Save::select('saves.*', 'posts.*', 'categories.name as catname')->leftJoin('posts', 'saves.post_id', 'posts.id')->leftJoin('categories', 'posts.category_id', 'categories.id')->where('saves.user_id', Auth::user()->id)->where('posts.title', 'like', '%' . $request->input . '%')->get();
        } else {
            $keyon = Save::select('saves.*', 'posts.*', 'categories.name as catname')->leftJoin('posts', 'saves.post_id', 'posts.id')->leftJoin('categories', 'posts.category_id', 'categories.id')->where('saves.user_id', Auth::user()->id)->get();
        }
        return response()->json($keyon, 200);
    }

    //bookmark sorting with ajax
    public function BookmarkSorting(Request $request)
    {
        if ($request->value == 'view') {
            $data = Save::select('saves.*', 'posts.*', 'categories.name as catname')
                ->leftJoin('posts', 'saves.post_id', 'posts.id')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->where('saves.user_id', Auth::user()->id)
                ->orderBy('posts.view_count', 'desc')
                ->get();
        } elseif ($request->value == 'new') {
            $data = Save::select('saves.*', 'posts.*', 'categories.name as catname')
                ->leftJoin('posts', 'saves.post_id', 'posts.id')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->where('saves.user_id', Auth::user()->id)
                ->orderBy('saves.created_at', 'desc')
                ->get();
        } elseif ($request->value == 'old') {
            $data = Save::select('saves.*', 'posts.*', 'categories.name as catname')
                ->leftJoin('posts', 'saves.post_id', 'posts.id')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->where('saves.user_id', Auth::user()->id)
                ->orderBy('saves.created_at', 'asc')
                ->get();
        } elseif ($request->value == 'az') {
            $data = Save::select('saves.*', 'posts.*', 'categories.name as catname')
                ->leftJoin('posts', 'saves.post_id', 'posts.id')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->where('saves.user_id', Auth::user()->id)
                ->orderBy('posts.title', 'asc')
                ->get();
        } else {
            $data = Save::select('saves.*', 'posts.*', 'categories.name as catname')
                ->leftJoin('posts', 'saves.post_id', 'posts.id')
                ->leftJoin('categories', 'posts.category_id', 'categories.id')
                ->where('saves.user_id', Auth::user()->id)
                ->orderBy('posts.title', 'desc')
                ->get();
        }
        return response()->json($data, 200);
    }

    //bookmark clear with ajax
    public function clearBookmark(Request $request)
    {
        if ($request->status == 'clear') {
            Save::where('user_id', Auth::user()->id)->delete();
        }
        $bookmark = Save::where('user_id', Auth::user()->id)->get();
        return response()->json($bookmark, 200);
    }

    //bookmark clear with ajax
    public function removeBookmark(Request $request)
    {
        if ($request->id != null) {
            Save::where('id', $request->id)->where('user_id', Auth::user()->id)->delete();
        }
        $bookmark = Save::where('user_id', Auth::user()->id)->get();
        return response()->json($bookmark, 200);
    }
}

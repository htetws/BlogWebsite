<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //post list
    public function postList()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('ADM.post.list', compact('posts'));
    }

    //post create page
    public function postCreatePage()
    {
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::get();
        return view('ADM.post.create', compact(['categories', 'tags']));
    }

    //post create
    public function postCreate(Request $request)
    {

        $this->postValidation($request, "create");
        $query =  $this->postQuery($request);

        if ($request->hasFile('postImage')) {
            $imgName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $imgName);
            $query['image'] = $imgName;
        }

        Post::create($query)->tag()->attach($request->postTag);

        return redirect()->route('admin#post#list')->with('created', 'post created successfully.');
    }

    //post view page
    public function postView($id)
    {
        $post = Post::find($id);
        return view('ADM.post.view', compact('post'));
    }

    //post edit page
    public function postEditPage($id)
    {
        $post = Post::find($id);
        $categories = Category::get();
        $tags = Tag::get();
        return view('ADM.post.edit', compact('post', 'categories', 'tags'));
    }

    //post update
    public function postEdit(Request $request)
    {
        $this->postValidation($request, "update");

        $post = Post::find($request->postId);

        if ($request->hasFile('postImage')) {

            $oldimage = Post::select('image')->find($request->postId);

            //delete image from storage
            if ($oldimage != null) {
                Storage::delete('public/' . $oldimage->image);
            }

            $newimage = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $newimage);
            // $query['image'] = $newimage;
            $post->image = $newimage;
        }

        $post->title = $request->postTitle;
        $post->slug = Str::slug($request->postTitle);
        $post->description = $request->postDesc;
        $post->category_id = $request->categoryId;
        $post->save();

        $post->tag()->sync($request->postTag);

        return redirect()->route('admin#post#view', $request->postId)->with('updated', 'Post Updated Successfully.');
    }

    //private function
    private function postValidation($request, $type)
    {
        Validator::validate($request->all(), [
            'postTitle' => 'required|unique:posts,title,' . $request->postId,
            'postDesc' => 'required',
            'categoryId' => 'required',
            'postImage' => $type == 'create' ? 'required|file|mimes:jpg,jpeg,png,webp' : 'file|mimes:jpg,jpeg,png,webp'
        ]);
    }

    private function postQuery($request)
    {
        return [
            'title' => $request->postTitle,
            'slug' => Str::slug($request->postTitle),
            'description' => $request->postDesc,
            'category_id' => $request->categoryId,
        ];
    }
}

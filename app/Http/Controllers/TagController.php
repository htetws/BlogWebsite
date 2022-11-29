<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function tagList()
    {
        $tags = Tag::orderBy('created_at', 'desc')->paginate(10);
        return view('ADM.tag.list', compact('tags'));
    }

    public function tagCreate(Request $request)
    {
        $this->tagValidation($request);
        Tag::create($this->tagQuery($request));

        return back()->with('success', 'new tag added successfully.');
    }

    public function tagEdit(Request $request)
    {
        $this->tagValidation($request);
        Tag::where('id', $request->id)->update([
            'name' => $request->name
        ]);
        return back()->with('updated', 'new tag updated successfully.');
    }

    public function tagDelete(Request $request)
    {
        Tag::where('id', $request->categoryId)->delete();
        return back()->with('deleted', 'new tag deleted successfully.');
    }


    //private function

    private function tagValidation($request)
    {
        Validator::validate($request->all(), [
            'name' => 'required|unique:tags,name,' . $request->id
        ]);
    }

    private function tagQuery($request)
    {
        return [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ];
    }
}

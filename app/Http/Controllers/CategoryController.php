<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function CategoryList()
    {
        $categories =  Category::orderBy('created_at', 'desc')->paginate(10);
        $categories->appends(request()->query());
        return view('ADM.category.list', compact('categories'));
    }

    public function categoryCreate(Request $request)
    {
        $this->categoryValidation($request);

        $data = $this->categoryQuery($request);
        Category::create($data);

        Session::flash('success', 'your post created.');
        return back();
    }

    public function categoryDelete(Request $request)
    {
        Category::where('id', $request->categoryId)->delete();
        return back()->with('deleted', 'this category removed.');
    }

    public function categoryEdit(Request $request)
    {
        $this->categoryValidation($request);
        Category::where('id', $request->id)->update([
            'name' => $request->name
        ]);
        return back()->with('updated', 'this category updated.');
    }

    //private functions
    private function categoryValidation($request)
    {
        Validator::validate($request->all(), [
            'name' => 'required|unique:categories,name,' . $request->id
        ], [
            'name.required' => 'You must need to fill at least one category !'
        ]);
    }
    private function categoryQuery($request)
    {
        return [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ];
    }
}

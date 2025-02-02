<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('parent')->orderByDesc('id')->paginate(5);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Data
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Upload File
        $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/categories'), $img_name);

        // convert name to json
        $name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ], JSON_UNESCAPED_UNICODE);

        // Insert To Database
        Category::create([
            'name' => $name,
            'image' => $img_name,
            'parent_id' => $request->parent_id
        ]);

        // Redirect
        return redirect()->route('admin.categories.index')->with('msg', 'Category created successfully')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate Data
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);

        // Upload File
        $img_name = $category->image;
        if($request->hasFile('image')) {
            $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/categories'), $img_name);
        }

        // convert name to json
        $name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ], JSON_UNESCAPED_UNICODE);

        // Insert To Database
        $category->update([
            'name' => $name,
            'image' => $img_name,
            'parent_id' => $request->parent_id
        ]);

        // Redirect
        return redirect()->route('admin.categories.index')->with('msg', 'Category updated successfully')->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        File::delete(public_path('uploads/categories/'.$category->image));

        $category->children()->update(['parent_id' => null]);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('msg', 'Category deleted successfully')->with('type', 'danger');
        // return redirect()->route('admin.categories.index')->with('fail', 'Category deleted successfully');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        Category::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.categories.trash')->with('msg', 'Category restored successfully')->with('type', 'warning');
    }

    public function forcedelete($id)
    {
        $category = Category::onlyTrashed()->find($id);
        File::delete(public_path('uploads/categories/'. $category->image));
        $category->forcedelete();

        return redirect()->route('admin.categories.trash')->with('msg', 'Category deleted permanintly successfully')->with('type', 'danger');
    }
}

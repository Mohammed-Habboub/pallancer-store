<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    //


    public function index(Request $request) 
    {
        
        $categories = Category::when($request->name, function($query, $value){
            $query->where(function($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")
                ->orWhere('description', 'LIKE', "%{$value}%");
            });
            
        })
        ->when($request->parent_id, function($query, $value){
            $query->where('parent_id', '=', $value);
        })
        ->leftjoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name',
        ])
        ->get();


        $parents = Category::orderby('name', 'asc')->get();
        return view('admin.categories.index', [
            'categories' => $categories,
            'parents' => $parents,
        ]);

    } 

    public function create()
    {
        $parents = Category::orderby('name', 'asc')->get();

        return view('admin.categories.create', [
                "parents" => $parents,
                "title"   => "Add Categories",
                'category' => new Category(),
        ]);
                
    }

    public function store(Request $request)
    {
        $category = new Category();

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);       
        $category->description = $request->input('description');
        $category->parent_id = $request->post('parent_id');
        $category->status = $request->post('status');
        $category->save();

        session()->put('status', 'Category Added (from status!');

        return redirect( route('admin.categories.index'))
                ->with('success', 'Category Added!');
    }

    public function show($id)
    {
        return view('admin.categories.show', [
                'category' => Category::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        
        $category = Category::findOrFail($id); // $category = Category::where('id', '=', $id)->first();
        /* 
        | // findOrFail($id);
        | if ($category == null) {
        |    abort(404); // stop the code belwo not execute therefore elseif in this the case not important
        | } */

        $parents = Category::where('id', '<>', $id)
                ->orderby('name', 'asc')
                ->get();

        return view('admin.categories.edit', [
            'id' => $id,
            'parents' => $parents,
            'category' =>$category,
        ]);
    }

    public function update(Request $request, $id) 
    {
        
        $category = Category::find($id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);       
        $category->description = $request->input('description');
        $category->parent_id = $request->post('parent_id');
        $category->status = $request->post('status');
        $category->save();

        return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category Updated!');

    } 

    public function destroy($id)
    {
        // Method 1
        // $category = Category::find($id);
        // $category->delete();

        // Method 2
        // Category::where('id', '=', $id)->delete();

        // Method 3
        Category::destroy($id);

        return Redirect::route('admin.categories.index')    
                ->with('success', 'Category Deleted!');
    }
}

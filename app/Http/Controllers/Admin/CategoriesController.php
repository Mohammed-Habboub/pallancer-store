<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Rules\WordsFilter;
use App\Scopes\ActiveStatusScope;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class CategoriesController extends Controller
{
    //


    public function index(Request $request) 
    {
        //$this->authorize('view-any', Category::class);

        
        $categories = Category::when($request->name, function($query, $value) {
            $query->where(function($query) use ($value) {
                $query->where('categories.name', 'LIKE', "%{$value}%")
                    ->orWhere('categories.description', 'LIKE', "%{$value}%");
            });
        })
        ->when($request->parent_id, function($query, $value) {
            $query->where('categories.parent_id', '=', $value);
        })
        // Note  : the join better than relation IN Speed
        // Becuse exist relationships in model therefore stop the leftjoin
        /* ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/

        // Eager loading (with)| (load)التحميل المسبق أحمل العلاقة مسبقا للسرعة في تنفيذ الاستعلام
        ->with('parent') // for only on parent filed no on the all the failds

        //->withoutGlobaleScope(ActiveStatusScope::class)

        ->withoutGlobaleScope(ActiveStatusScope::class)

        ->get();
        //SELECT * FROM categories
        //SELECT * FORM categories WHERE id IN (...)


        $parents = Category::orderby('name', 'asc')->get();
        return view('admin.categories.index', [
            'categories' => $categories,
            'parents' => $parents,
        ]);

    } 

    public function create()
    {

        //$this->authorize('create', Category::class);

        $this->authorize('create', Category::class);

        $parents = Category::orderby('name', 'asc')->get();

        return view('admin.categories.create', [
                "parents" => $parents,
                "title"   => "Add Categories",
                'category' => new Category(),
        ]);
                
    }

    public function store(Request $request)
    {

        //$this->authorize('create', Category::class);

        $this->authorize('create', Category::class);

        /* // Method 1 for Validat
        // 
        $validator = Validator::make($request->all(), [
            'name'           => 'required|alpha|max:255|min:3|unique:categories, name',
            'description'    => 'nullable|min:5',
            'parent_id'      => [
                'nullable',
                'exists:categories,id',
            ],
            'image'          => [
                'nullable',
                'image',
                'max:1048576',
                'dimensions:min_width=200,min_height=200'
            ],
            'status' => 'required|in:active,inactive',
        ]);*/

        $clean = $this->validetoRequest($request);

        

        // $fails  = $validator->fails();// true when validator fail

        // $failed = $validator->failed(); // error in the first problem in rules

        // $errors = $validator->errors(); // error in All problem in rules

        // $clean = $validator->validated();

        // dd($clean);

        $category = new Category();

        $category->name =$request->name;
        $category->slug = Str::slug($clean['name']);       
        $category->description =  $request->post('description');
        $category->parent_id = $request->input('parent_id');
        $category->status = $request->post('status');
        $category->save();

        // session()->put('status', 'Category Added (from status!');

        return redirect( route('admin.categories.index'))
                ->with('success', 'Category Added!');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

       // $this->authorize('view', $category);

        $this->authorize('view', $category);


        return view('admin.categories.show', [
                'category' => $category,
        ]);
    }

    public function edit($id)
    {
        
        
        $category = Category::withTrashed()->findOrFail($id); // $category = Category::where('id', '=', $id)->first();
        //$this->authorize('update', $category);
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

    public function update(CategoryRequest $request, $id) 
    {
        
        // $this->validetoRequest($request, $id);
        $category = Category::find($id);
        if ($category == null) {
            abort(404);
        }
       // $this->authorize('update', $category);
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
        $category = Category::findOrFail($id);
       // $this->authorize('delete', $category);
        $category->delete();

        // Method 2
        // Category::where('id', '=', $id)->delete();

        // Method 3
        //Category::destroy($id);

        return Redirect::route('admin.categories.index')    
                ->with('success', 'Category Deleted!');
    }

    public function trash()
    {
        return view('admin.categories.trash', [
            'categories' => Category::onlyTrashed()->paginate(),
        ]);
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category restored');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category deleted forever.');
    }

    protected function validetoRequest (Request $request, $id = 0) 
    {
        // Method 2 for Validat
        return $request->validate([
                                                                                   
            'name'           => 'required',
            'alpha',
            'max:255',
            'min:3',                   //PK للاستثناء
            // Method:1 'unique:categories,name,$id',
            // Method 2
            //Rule::unique('categories', 'name' )->ignore($id)
            // Method 3
            (new Unique('categories', 'name'))->ignore($id),

            
            
            'description'    => [
                'nullable',
                'min:5', 

            // Custom rule in php //
            // Method 1
            /* function($attribute, $value, $fail) {
                if ( stripos($value, 'laravel') !== false ) {
                    $fail('Youe can not "laravel" !');
                } 
            }*/

            // Method 2
            //new WordsFilter(['php', 'laravel']),

            // Method 3 
            // Validate Extend => App Service => boot => Ex: filter
            'filter:laravel',
            
        ],
            'parent_id'      => [
                'nullable',
                'exists:categories,id',
            ],
            'image'          => [
                'nullable',
                'image',
                'max:1048576',
                'dimensions:min_width=200,min_height=200'
            ],
            'status' => 'required|in:active,inactive',
        ], [
            // To change The Message
            // Method 1 => resources =>lang => validation.php
            // Method 2
            'required' => 'هذا الحقل مطلوب' ,// For To All the Feild is required == Method 1
            'name.required'=> 'مطلوب' // only the faild the name
        ]);

        /* $validator = Validator::make([], [], []);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } */

        // Method 3 for Validat

        /* $this->validate($request,[
            'name'           => 'required|alpha|max:255|min:3|unique:categories, name',
            'description'    => 'nullable|min:5',
            'parent_id'      => [
                'nullable',
                'exists:categories,id',
            ],
            'image'          => [
                'nullable',
                'image',
                'max:1048576',
                'dimensions:min_width=200,min_height=200'
            ],
            'status' => 'required|in:active,inactive',
        ]); */

    }
}

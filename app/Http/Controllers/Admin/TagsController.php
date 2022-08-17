<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function products($id)
    {
        $tag = Tag::findOrFail($id);
        // return Product::whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?', [$id])
        // ->get();


        // return $tag->products; // Display products  only
        // return $tag; // Display Tags only 
        // Eager loading
        return $tag->load('products.category', 'products.store'); // Display Tags  & products 
    }
}

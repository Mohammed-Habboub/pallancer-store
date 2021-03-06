<?php

namespace App\Models;

use App\Scopes\ActiveStatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new ActiveStatusScope);
    }

    public static function rules()
    {
        return [

        ];
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function childern () 
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent () 
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent',
        ]); // Must Be withDefault Because resault index.blade.php =>{ $category->parent->name; } may to be Non hence Error
    }
    

}

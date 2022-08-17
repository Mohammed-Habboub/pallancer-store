<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $perPage = 10; // number of item the display in page
    // كل ما بدي استعلم على منتج بجبلي الفئة تعته اوتماتيك و الستور
    /* protected $with = [ // Eager loading
        'category', 'store'
    ];*/


       //protected $touches = ['category', 'store'];

       protected $fillable = [
        'name', 'category_id', 'description', 'price', 'sale_price', 'quantity',
        'image', 'status', 'slug', 'store_id',
    ];

  

    //protected $guarded = [];

    /*protected $with = [
        'category', 'store'
    ];*/
    /* protected static function booted()
    {
        static::addGlobalScope('in-stock', function(Builder $builder) {
            $builder->where('status', '=', 'in-stock');
        });
    } */ 

     /* public function scopeSoldout(Builder $builder)
    {
        $builder->where('status', '=', 'sold-out');
    }

    public function scopeStatus(Builder $builder, $status = 'in-stock')
    {
        $builder->where('status', '=', $status);
    } */

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }


    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id', //FK the table current
            'tag_id',     //FK the table relationship
            'id', // For product
            'id',// For tag
        );
    }

    public static function validatorRules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image',
            'price' => 'numeric|min:0',
            'sale_price' => [
                'numeric',
                'min:0',
                function($att, $value, $fail) {
                    $price = request()->input('price');
                    if ($value >= $price) {
                            // :attribute
                        $fail($att . ' must be less than regular price');
                    }
                }
            ],

        ];
    }


    // Accessors:
    // get{AttrName}Attribute
    // $product->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if (strpos($this->image, 'http') === 0) {
                return $this->image;
            }
            //return asset('uploads/' . $this->image);
            return Storage::disk('uploads')->url($this->image);
        }

        return asset('images/default-image.jpeg');
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }
}

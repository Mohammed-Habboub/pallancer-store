<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,

            // يمكن الاستغناء عن جميع هذه البيانات لانو الارفيل اتوماتيك بتعملهم اذا كنت مسميهم بنفس الطريقة التالية :

            'product_tag',         
            'tag_id',     //FK the table current
            'product_id', //FK the table relationshipt
            'id', // For tag
            'id',// For product
        );
    }
}

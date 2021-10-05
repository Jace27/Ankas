<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
        'image_id',
        'created_at',
        'updated_at'
    ];

    public function child_categories(){
        return $this->belongsToMany('App\Models\categories', 'subcategories', 'parent_category_id', 'child_category_id');
    }
    public function parent_categories(){
        return $this->belongsToMany('App\Models\categories', 'subcategories', 'child_category_id', 'parent_category_id');
    }
    public function products(){
        return $this->belongsToMany('\App\Models\products_detail', 'products_categories', 'category_id', 'products_detail_id');
    }
    public function image(){
        return $this->belongsTo(\App\Models\images::class, 'image_id', 'id')->first();
    }
}

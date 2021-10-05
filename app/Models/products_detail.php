<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_detail extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'vendor_code',
        'brand_id',
        'cy_id',
        'price',
        'name',
        'model',
        'image_id',
        'description',
        'description_short',
        'length',
        'width',
        'height',
        'weight',
        'created_at',
        'updated_at'
    ];

    public function categories(){
        return $this->belongsToMany('\App\Models\categories', 'products_categories', 'products_detail_id', 'category_id');
    }
    public function price(){
        return $this->price . $this->belongsTo('\App\Models\cys', 'cy_id', 'id')->first()->symbol;
    }
    public function brand(){
        return $this->belongsTo(\App\Models\brands::class, 'brand_id', 'id');//->first();
    }
    public function cy(){
        return $this->belongsTo(\App\Models\cys::class, 'cy_id', 'id');
    }
    public function image(){
        return $this->belongsTo(\App\Models\images::class, 'image_id', 'id')->first();
    }
}

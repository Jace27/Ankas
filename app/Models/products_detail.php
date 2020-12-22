<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_detail extends Model
{
    use HasFactory;
    protected $fillable = [ 'vendor_code', 'brand_id', 'cy_id', 'price', 'name', 'model', 'image', 'description', 'description_short', 'length', 'width', 'height', 'weight', 'created_at', 'updated_at'];

    public function categories(){
        return $this->belongsToMany('\App\Models\categories', 'products_categories', 'products_detail_id', 'category_id');
    }
    public function price(){
        return $this->price.$this->belongsTo('\App\Models\cys', 'cy_id', 'id')->get()[0]->symbol;
    }
}

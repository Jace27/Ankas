<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders_products extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'order_id',
        'count'
    ];

    public function product(){
        return $this->belongsTo(\App\Models\products_detail::class, 'product_id', 'id');
    }
}

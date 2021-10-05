<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'last_name',
        'first_name',
        'third_name',
        'phone',
        'email',
        'status_id',
        'created_at',
        'updated_at'
    ];

    public function status(){
        return $this->belongsTo(\App\Models\order_statuses::class, 'status_id', 'id');
    }
    public function products(){
        return $this->belongsToMany(\App\Models\products_detail::class, 'orders_products', 'order_id', 'product_id');
    }
    public function orders_products(){
        return $this->hasMany(\App\Models\orders_products::class, 'order_id', 'id');
    }

    public function sum(){
        $sum = 0;
        $prods = $this->products()->get();
        foreach ($prods as $prod){
            $sum += $prod->price;
        }
        return $sum;
    }
}

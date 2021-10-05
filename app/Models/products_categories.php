<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_categories extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'products_detail_id',
        'category_id'
    ];
}

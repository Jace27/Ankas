<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategories extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'parent_category_id',
        'child_category_id'
    ];
}

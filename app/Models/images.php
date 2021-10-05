<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class images extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'file_name',
        'created_at',
        'updated_at'
    ];

    public function products(){
        return $this->hasMany(\App\Models\products_detail::class, 'image_id', 'id');
    }
    public function categories(){
        return $this->hasMany(\App\Models\categories::class, 'image_id', 'id');
    }
}

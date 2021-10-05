<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cys extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'code',
        'symbol'
    ];
}

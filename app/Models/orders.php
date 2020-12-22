<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $fillable = ['last_name', 'first_name', 'third_name', 'phone', 'email', 'sum', 'status', 'created_at', 'updated_at'];
}

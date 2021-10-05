<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'email',
        'password',
        'role_id',
        'first_name',
        'last_name',
        'third_name',
        'phone'
    ];

    public function role(){
        return $this->belongsTo('\App\Models\roles', 'role_id', 'id');
    }
}

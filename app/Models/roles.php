<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description'
    ];

    public function users(){
        return $this->hasMany('\App\Models\users');
    }
    public function rights(){
        return $this->belongsToMany('\App\Models\rights', 'role_rights', 'role_id', 'right_id');
    }
}

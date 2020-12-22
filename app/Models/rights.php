<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rights extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function roles(){
        return $this->belongsToMany('\App\Models\roles', 'role_rights', 'right_id', 'role_id');
    }
}

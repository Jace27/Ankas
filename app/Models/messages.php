<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'chat_id',
        'user_id',
        'text',
        'viewed',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(\App\Models\users::class, 'user_id', 'id')->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $keyType = 'string';
    public $timestamps = false;


    protected $fillable = [
        'id',
        'username',
        'password',
        'nama_lengkap',
        'img',
        'role',
    ];
    
}

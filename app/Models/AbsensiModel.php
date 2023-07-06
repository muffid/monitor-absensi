<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiModel extends Model
{
    use HasFactory;
    protected $table = 'absensi';

    protected $fillable = [
        'id',
        'tanggal',
        'id_user',
        'masuk',
        'pulang',
        'rehat',
        'kembali',
    ];
}

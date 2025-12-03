<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iklan extends Model
{
    use SoftDeletes;

    protected $table = 'iklan';

    protected $fillable = [
        'nama',
        'gambar',
        'keterangan',
    ];
}

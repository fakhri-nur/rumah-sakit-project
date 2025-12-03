<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokters';

    protected $fillable = [
        'name',
        'specialty',
        'photo',
        'user_id'
    ];

    // menghubungkan dokter dengan user (fk user_id)
    public function user()
{
    return $this->belongsTo(User::class);
}

}


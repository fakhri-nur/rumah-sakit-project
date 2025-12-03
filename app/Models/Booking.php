<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'patient_name',
        'doctor_id',
        'appointment_date',
        'appointment_time',
    ];

    public function doctor()
    {
        return $this->belongsTo(Dokter::class);
    }
}

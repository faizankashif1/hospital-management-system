<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'available_days' => 'array',
        'consultation_fee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(HospitalBranch::class,'branch_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function availability()
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    public function leaves()
    {
        return $this->hasMany(DoctorLeave::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

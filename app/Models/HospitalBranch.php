<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HospitalBranch extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class,'branch_id');
    }

    public function receptionists()
    {
        return $this->hasMany(Receptionist::class,'branch_id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class,'branch_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'branch_id');
    }
}

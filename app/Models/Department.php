<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(HospitalBranch::class,'branch_id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}


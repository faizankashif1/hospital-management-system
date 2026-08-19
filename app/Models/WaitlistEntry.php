<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WaitlistEntry extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'promoted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(HospitalBranch::class,'branch_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

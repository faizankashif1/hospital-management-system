<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(HospitalBranch::class);
    }

    public function admins()
    {
        return $this->hasMany(HospitalAdmin::class);
    }
}
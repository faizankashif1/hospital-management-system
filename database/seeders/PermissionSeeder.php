<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'HOSPITAL_CREATE'        => ['SUPER_ADMIN'],
            'HOSPITAL_SUSPEND'       => ['SUPER_ADMIN'],
            'BRANCH_CREATE'          => ['SUPER_ADMIN', 'HOSPITAL_ADMIN'],
            'BRANCH_UPDATE'          => ['SUPER_ADMIN', 'HOSPITAL_ADMIN'],
            'DOCTOR_CREATE'          => ['SUPER_ADMIN', 'HOSPITAL_ADMIN'],
            'DOCTOR_UPDATE'          => ['SUPER_ADMIN', 'HOSPITAL_ADMIN'],
            'PATIENT_CREATE'         => ['SUPER_ADMIN', 'HOSPITAL_ADMIN', 'RECEPTIONIST'],
            'APPOINTMENT_CREATE'     => ['SUPER_ADMIN', 'HOSPITAL_ADMIN', 'RECEPTIONIST'],
            'APPOINTMENT_CANCEL'     => ['SUPER_ADMIN', 'HOSPITAL_ADMIN', 'RECEPTIONIST', 'DOCTOR'],
            'APPOINTMENT_NO_SHOW'    => ['SUPER_ADMIN', 'RECEPTIONIST', 'DOCTOR'],
            'WAITLIST_PROMOTE'       => ['SUPER_ADMIN', 'RECEPTIONIST'],
            'PRESCRIPTION_CREATE'    => ['SUPER_ADMIN', 'DOCTOR'],
            'REPORT_UPLOAD'          => ['SUPER_ADMIN', 'DOCTOR'],
            'DASHBOARD_VIEW_GLOBAL'  => ['SUPER_ADMIN'],
        ];

        foreach ($permissions as $code => $roles) {
            $permission = Permission::create(['code' => $code]);

            foreach ($roles as $role) {
                RolePermission::create([
                    'role' => $role,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
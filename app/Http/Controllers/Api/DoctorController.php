<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'branch', 'department'])->get();
        return response()->json(['doctors' => $doctors]);
    }

    public function show($id)
    {
        $doctor = Doctor::with(['user', 'branch', 'department'])->findOrFail($id);
        return response()->json(['doctor' => $doctor]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'branch_id' => 'required|exists:hospital_branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'specialization' => 'nullable|string',
            'qualification' => 'nullable|string',
            'license_no' => 'required|string|unique:doctors,license_no',
            'consultation_fee' => 'nullable|numeric|min:0',
            'experience_years' => 'nullable|integer|min:0',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'DOCTOR',
        ]);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'branch_id' => $data['branch_id'],
            'department_id' => $data['department_id'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'qualification' => $data['qualification'] ?? null,
            'license_no' => $data['license_no'],
            'consultation_fee' => $data['consultation_fee'] ?? 0,
            'experience_years' => $data['experience_years'] ?? null,
        ]);

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor->load(['user', 'branch', 'department']),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $data = $request->validate([
            'specialization' => 'sometimes|string',
            'qualification' => 'sometimes|string',
            'consultation_fee' => 'sometimes|numeric|min:0',
            'experience_years' => 'sometimes|integer|min:0',
            'department_id' => 'sometimes|nullable|exists:departments,id',
        ]);

        $doctor->update($data);

        return response()->json(['doctor' => $doctor->load(['user', 'branch', 'department'])]);
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->user()->delete(); // deletes User, which cascades to delete Doctor too (ON DELETE CASCADE)

        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->get();
        return response()->json(['patients' => $patients]);
    }

    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return response()->json(['patient' => $patient]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // optional login account fields — only needed if patient wants an account
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:8',

            // required patient fields regardless of login account
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'insurance_provider' => 'nullable|string',
            'insurance_policy_no' => 'nullable|string',
            'emergency_name' => 'required|string',
            'emergency_relation' => 'required|string',
            'emergency_contact' => 'required|string',
            'emergency_address' => 'nullable|string',
        ]);

        $userId = null;

        // Only create a User account if email+password were actually provided
        if (!empty($data['email']) && !empty($data['password'])) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'PATIENT',
            ]);
            $userId = $user->id;
        }

        $patient = Patient::create([
            'user_id' => $userId,
            'blood_group' => $data['blood_group'] ?? null,
            'insurance_provider' => $data['insurance_provider'] ?? null,
            'insurance_policy_no' => $data['insurance_policy_no'] ?? null,
            'emergency_name' => $data['emergency_name'],
            'emergency_relation' => $data['emergency_relation'],
            'emergency_contact' => $data['emergency_contact'],
            'emergency_address' => $data['emergency_address'] ?? null,
        ]);

        return response()->json([
            'message' => 'Patient registered successfully',
            'patient' => $patient->load('user'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $data = $request->validate([
            'blood_group' => 'sometimes|nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'insurance_provider' => 'nullable|string',
            'insurance_policy_no' => 'nullable|string',
            'emergency_name' => 'sometimes|required|string',
            'emergency_relation' => 'sometimes|required|string',
            'emergency_contact' => 'sometimes|required|string',
            'emergency_address' => 'nullable|string',
        ]);

        $patient->update($data);

        return response()->json(['patient' => $patient]);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
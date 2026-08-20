<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::with('branches')->get();
        return response()->json(['hospitals' => $hospitals]);
    }

    public function show($id)
    {
        $hospital = Hospital::with('branches')->findOrFail($id);
        return response()->json(['hospital' => $hospital]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:hospitals,email',
            'phone' => 'nullable|string',
            'website' => 'nullable|string',
        ]);

        $hospital = Hospital::create($data);

        return response()->json([
            'message' => 'Hospital created successfully',
            'hospital' => $hospital,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:hospitals,email,' . $hospital->id,
            'phone' => 'nullable|string',
            'website' => 'nullable|string',
            'status' => 'sometimes|in:ACTIVE,SUSPENDED,DELETED',
        ]);

        $hospital->update($data);

        return response()->json(['hospital' => $hospital]);
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->update(['status' => 'DELETED']); // soft-delete pattern, not a real delete

        return response()->json(['message' => 'Hospital marked as deleted']);
    }
}
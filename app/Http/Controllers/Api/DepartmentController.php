<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('branch');

        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        return response()->json(['departments' => $query->get()]);
    }

    public function show($id)
    {
        $department = Department::with('branch')->findOrFail($id);
        return response()->json(['department' => $department]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'required|exists:hospital_branches,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $department = Department::create($data);

        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
        ]);

        $department->update($data);

        return response()->json(['department' => $department]);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete(); // real delete is fine here — departments have no soft-delete "status" field per the SRS

        return response()->json(['message' => 'Department deleted successfully']);
    }
}

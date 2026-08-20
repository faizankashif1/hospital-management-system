<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HospitalBranch;
use Illuminate\Http\Request;

class HospitalBranchController extends Controller
{
    public function index(Request $request)
    {
        $query = HospitalBranch::with('hospital');

        if ($request->has('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        return response()->json(['branches' => $query->get()]);
    }

    public function show($id)
    {
        $branch = HospitalBranch::with(['hospital', 'departments'])->findOrFail($id);
        return response()->json(['branch' => $branch]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'name' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $branch = HospitalBranch::create($data);

        return response()->json([
            'message' => 'Branch created successfully',
            'branch' => $branch,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $branch = HospitalBranch::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'status' => 'sometimes|in:ACTIVE,SUSPENDED,CLOSED',
        ]);

        $branch->update($data);

        return response()->json(['branch' => $branch]);
    }

    public function destroy($id)
    {
        $branch = HospitalBranch::findOrFail($id);
        $branch->update(['status' => 'CLOSED']);

        return response()->json(['message' => 'Branch marked as closed']);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenance = MaintenanceRecord::with('asset')
            ->latest('date_reported')
            ->paginate(20);

        return response()->json($maintenance);
    }

    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'technician_id' => 'required|int',
            'maintenance_type' => 'required|string|max:255',
            'date_reported' => 'nullable|string',
            'date_started' => 'nullable|string',
            'date_completed' => 'nullable|string',
            'problem_description' => 'nullable|string',
            'action_taken' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
            'remarks' => 'nullable|string',
            'asset_status' => 'string',
        ]);

        $maintenance = MaintenanceRecord::create($validated);
        $asset = Asset::findOrFail($validated['asset_id']);
        $asset->update(['status' => 'under_maintenance']);

        $maintenance->load('asset');

        return response()->json([
            'message' => 'Maintenance record created successfully.',
            'data' => $maintenance,
        ], 201);
    }

    public function show(MaintenanceRecord $maintenance)
    {
        $maintenance->load('asset');

        return response()->json([
            'data' => $maintenance,
        ]);
    }

    public function update(Request $request, MaintenanceRecord $maintenance)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'technician_id' => 'nullable|string',
            'maintenance_type' => 'required|string|max:255',
            'date_reported' => 'nullable|string',
            'date_started' => 'nullable|string',
            'date_completed' => 'nullable|string',
            'problem_description' => 'nullable|string',
            'action_taken' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:50',
            'remarks' => 'nullable|string',
        ]);


        $asset = Asset::findOrFail($validated['asset_id']);
        if ($validated['status'] == 'completed') {
            $asset->update(['status' => 'available']);
        } else if ($validated['status'] == 'in_progress') {
            $asset->update(['status' => 'under_maintenance']);
        }
        $maintenance->update($validated);

        $maintenance->load('asset');

        return response()->json([
            'message' => 'Maintenance record updated successfully.',
            'data' => $maintenance,
        ]);
    }

    public function destroy(MaintenanceRecord $maintenance)
    {
        $maintenance->delete();

        return response()->json([
            'message' => 'Maintenance record deleted successfully.',
        ]);
    }
}
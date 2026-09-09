<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with([
            'category',
            'department',
            'location',
            'supplier',
        ])->paginate(20);

        return response()->json($assets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_tag' => 'required|string|max:100|unique:assets,asset_tag',
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',

            'property_number' => 'nullable|string|max:100',
            'ics_number' => 'nullable|string|max:100',
            'par_number' => 'nullable|string|max:100',

            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number',

            'department_id' => 'nullable|exists:departments,id',
            'location_id' => 'nullable|exists:locations,id',
            'supplier_id' => 'nullable|exists:suppliers,id',

            'unit_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',

            'fund_source' => 'nullable|string|max:255',
            'fund_cluster' => 'nullable|string|max:255',

            'acquisition_type' => 'nullable|in:procurement,donation,transfer,grant,other',

            'purchase_order_number' => 'nullable|string|max:255',
            'purchase_request_number' => 'nullable|string|max:255',

            'purchase_date' => 'nullable|date',
            'date_received' => 'nullable|date',

            'warranty_start' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',

            'status' => 'nullable|in:available,assigned,in_storage,under_maintenance,lost,damaged,for_disposal,disposed,retired',

            'condition' => 'nullable|in:new,good,fair,poor,damaged,unserviceable',

            'remarks' => 'nullable|string',
        ]);

        $asset = Asset::create($validated);

        return response()->json([
            'message' => 'Asset created successfully.',
            'data' => $asset,
        ], 201);
    }

    public function show(Asset $asset)
    {
        $asset->load([
            'category',
            'department',
            'location',
            'supplier',
            'assignments',
            'maintenanceRecords',
            'transactions',
        ]);

        return response()->json([
            'data' => $asset,
        ]);
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_tag' => 'required|string|max:100|unique:assets,asset_tag,' . $asset->id,
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',

            'property_number' => 'nullable|string|max:100',
            'ics_number' => 'nullable|string|max:100',
            'par_number' => 'nullable|string|max:100',

            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',

            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number,' . $asset->id,

            'department_id' => 'nullable|exists:departments,id',
            'location_id' => 'nullable|exists:locations,id',
            'supplier_id' => 'nullable|exists:suppliers,id',

            'unit_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',

            'status' => 'nullable|in:available,assigned,in_storage,under_maintenance,lost,damaged,for_disposal,disposed,retired',

            'condition' => 'nullable|in:new,good,fair,poor,damaged,unserviceable',

            'remarks' => 'nullable|string',
        ]);

        $asset->update($validated);

        return response()->json([
            'message' => 'Asset updated successfully.',
            'data' => $asset,
        ]);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json([
            'message' => 'Asset deleted successfully.',
        ]);
    }
}
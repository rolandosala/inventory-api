<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of locations.
     */
    public function index()
    {
        $locations = Location::with('department')
            ->orderBy('building')
            ->orderBy('room')
            ->get();

        return response()->json([
            'data' => $locations,
        ]);
    }

    /**
     * Store a newly created location.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'building' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $location = Location::create($validated);

        $location->load('department');

        return response()->json([
            'message' => 'Location created successfully.',
            'data' => $location,
        ], 201);
    }

    /**
     * Display the specified location.
     */
    public function show(Location $location)
    {
        $location->load('department');

        return response()->json([
            'data' => $location,
        ]);
    }

    /**
     * Update the specified location.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'building' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $location->update($validated);

        $location->load('department');

        return response()->json([
            'message' => 'Location updated successfully.',
            'data' => $location,
        ]);
    }

    /**
     * Remove the specified location.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return response()->json([
            'message' => 'Location deleted successfully.',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Software;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    public function index()
    {
        $software = Software::latest()->paginate(20);

        return response()->json([
            'data' => $software,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:100',
            'licenses' => 'nullable|integer|min:0',
            'installed' => 'nullable|integer|min:0',
            'expiry' => 'nullable|date',
            'status' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $software = Software::create($validated);

        return response()->json([
            'message' => 'Software created successfully.',
            'data' => $software,
        ], 201);
    }

    public function show(Software $software)
    {
        return response()->json([
            'data' => $software,
        ]);
    }

    public function update(Request $request, Software $software)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:100',
            'licenses' => 'nullable|integer|min:0',
            'installed' => 'nullable|integer|min:0',
            'expiry' => 'nullable|date',
            'status' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $software->update($validated);

        return response()->json([
            'message' => 'Software updated successfully.',
            'data' => $software,
        ]);
    }

    public function destroy(Software $software)
    {
        $software->delete();

        return response()->json([
            'message' => 'Software deleted successfully.',
        ]);
    }

    public function assets(Software $software)
    {
        $software->load('assets');

        return response()->json([
            'data' => $software->assets,
        ]);
    }

    public function byCategory()
    {
        $softwares = Software::whereNotIn('category', ['Operating System', 'Security'])
            ->get();

        return response()->json([
            'data' => $softwares,
        ]);
    }
    public function bySecurity()
    {
        $softwares = Software::where('category', ['Security'])
            ->get();

        return response()->json([
            'data' => $softwares,
        ]);
    }
}
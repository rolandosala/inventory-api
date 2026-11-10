<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

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
            'specifications' => 'nullable|string',
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
            'asset_software'
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

    public function propertyLabel(Asset $asset)
    {
        $asset->load([
            'category',
            'department',
            'location',
            'supplier',
        ]);

        $assetUrl = url('/dashboard/assets/' . $asset->id);

        $qrCode = QrCode::format('png')
            ->size(500)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($assetUrl);

        $qrBase64 = base64_encode($qrCode);

        $qrPath = storage_path('app/public/qr-' . $asset->id . '.png');
        file_put_contents($qrPath, $qrCode);
        $logoPath = public_path('/slsu-logo.png');
        $qrCodePath = public_path('/qrCode.png');

        $logo = null;
        $qrCodelogo = null;

        if (File::exists($logoPath)) {
            $logo = base64_encode(
                File::get($logoPath)
            );
        }
        if (File::exists($qrCodePath)) {
            $qrCodelogo = base64_encode(
                File::get($qrCodePath)
            );
        }


        $pdf = Pdf::loadView('pdf.property-label', [
            'asset' => $asset,
            'qrCodelogo' => $qrCodelogo,
            'logo' => $logo,
            'qrCode' => $qrBase64,
            'qrPath' => $qrPath
        ]);


        $pdf->setPaper(
            [0, 0, 283.46, 170.08],
            'landscape'
        );

        return $pdf->stream(
            'property-label-' . $asset->asset_tag . '.pdf'
        );
    }
    /* public function propertyLabel(Asset $asset)
    {
        $assetUrl = url('/assets/' . $asset->id);

        $qrCode = QrCode::format('svg')
            ->size(500)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($assetUrl);

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml');
    } */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json([
            'message' => 'Asset deleted successfully.',
        ]);
    }

    public function nextNumber()
    {
        $year = now()->year;

        $lastAsset = Asset::where('asset_tag', 'like', "ICT-{$year}-%")
            ->orderByDesc('id')
            ->first();

        if (!$lastAsset) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) substr($lastAsset->asset_tag, -4);
            $nextNumber = $lastNumber + 1;
        }

        return response()->json([
            'next_number' => $nextNumber,
            'asset_tag' => sprintf(
                'ICT-%d-%04d',
                $year,
                $nextNumber
            ),
        ]);
    }
}
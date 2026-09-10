<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class DashboardCategoriesController extends Controller
{
    public function categoryCounts()
    {
        $categories = Category::query()
            ->withCount([
                'assets as asset_records_count' => function ($query) {
                    $query->whereNull('deleted_at');
                }
            ])
            ->with([
                'assets' => function ($query) {
                    $query->whereNull('deleted_at')
                        ->select('id', 'category_id', 'quantity');
                }
            ])
            ->orderBy('name')
            ->get();

        $data = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'code' => $category->code,
                'name' => $category->name,
                'icon' => $category->icon,
                'asset_records' => $category->asset_records_count,
                'total_devices' => $category->assets->sum('quantity'),
            ];
        });

        return response()->json([
            'data' => $data,
        ]);
    }
}
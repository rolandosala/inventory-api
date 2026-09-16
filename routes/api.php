<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardCategoriesController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/* Route::apiResource('assets', AssetController::class); */
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/assets/next-number', [AssetController::class, 'nextNumber']);
    Route::apiResource('assets', AssetController::class);

    // View assets
    Route::get('/assets', [AssetController::class, 'index'])
        ->middleware('permission:assets.view');

    // Create asset
    Route::post('/assets', [AssetController::class, 'store'])
        ->middleware('permission:assets.create');

    // View single asset
    Route::get('/assets/{asset}', [AssetController::class, 'show'])
        ->middleware('permission:assets.view');

    // Update asset
    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->middleware('permission:assets.update');

    // Delete asset
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->middleware('permission:assets.delete');

    Route::get('/assets/{asset}/property-label', [AssetController::class, 'propertyLabel'])
        ->middleware('permission:assets.view');

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'roles' => $request->user()->roles->pluck('name'),
        ]);
    });

    // User Management
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:users.view');

    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:users.create');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->middleware('permission:users.view');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('permission:users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:users.delete');

    Route::apiResource('departments', DepartmentController::class);

    Route::apiResource('users', UserController::class);
    Route::apiResource('maintenance', MaintenanceController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::get('category-counts', [DashboardCategoriesController::class, 'categoryCounts']);

    Route::get('/test-qr', function () {
        $qrCode = QrCode::format('svg')
            ->size(500)
            ->margin(1)
            ->errorCorrection('H')
            ->generate('https://example.com');

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml');
    });
    

});

Route::get('/user', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,

        'roles' => $user->roles->pluck('name')->values(),

        'permissions' => $user->roles
            ->load('permissions')
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values(),
    ]);

})->middleware('auth:sanctum');

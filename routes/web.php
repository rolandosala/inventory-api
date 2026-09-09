<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/assets', [AssetController::class, 'index'])
        ->middleware('permission:assets.view')
        ->name('assets.index');

    Route::get('/assets/create', [AssetController::class, 'create'])
        ->middleware('permission:assets.create')
        ->name('assets.create');

    Route::post('/assets', [AssetController::class, 'store'])
        ->middleware('permission:assets.create')
        ->name('assets.store');

    Route::get('/assets/{asset}', [AssetController::class, 'show'])
        ->middleware('permission:assets.view')
        ->name('assets.show');

    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])
        ->middleware('permission:assets.update')
        ->name('assets.edit');

    Route::put('/assets/{asset}', [AssetController::class, 'update'])
        ->middleware('permission:assets.update')
        ->name('assets.update');

    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->middleware('permission:assets.delete')
        ->name('assets.destroy');

});
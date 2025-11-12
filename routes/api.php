<?php

use Illuminate\Support\Facades\Route;
use Modules\Helpcenter\Http\Controllers\API\APITagController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('tags', APITagController::class)->names('tags');
    Route::get('tags/{tag}/items', [APITagController::class, 'items'])->name('tags.items');
});


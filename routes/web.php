<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DashboardController;


Route::get('/', [ImportController::class, 'index']);

Route::post('/upload', [ImportController::class, 'upload'])
    ->name('upload.process');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/batch-progress/{id}', [DashboardController::class, 'progress']);

Route::get(
    '/download/marketing/{batch}',
    [ExportController::class, 'downloadMarketing']
)->name('download.marketing');

Route::get(
    '/download/finance/{batch}',
    [ExportController::class, 'downloadFinance']
)->name('download.finance');

Route::get(
    '/error-report/{batch}',
    [ExportController::class, 'downloadErrorReport']
)->name('error.report');

Route::delete(
    '/batch/{batch}/rollback',
    [DashboardController::class, 'rollback']
)->name('batch.rollback');
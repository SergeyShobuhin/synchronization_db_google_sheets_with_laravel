<?php

use App\Http\Controllers\DataItem\DataItemController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/fetch', [\App\Http\Controllers\Google\UploadTableController::class, 'uploadTable'])->name('upload.table');

Route::resources([
    'dataitem' => DataItemController::class
]);

Route::post('/dataitem/generate', [\App\Http\Controllers\DataItem\GenerateController::class, 'generate'])->name('dataitem.generate');
Route::get('/clear-dataitem', [\App\Http\Controllers\DataItem\ClearController::class, 'clear'])->name('clear-dataitem');

Route::get('/clear-sheet', [\App\Http\Controllers\Google\DataExportController::class, 'clearSheet'])->name('clear.sheet');
Route::post('/export-sheet', [\App\Http\Controllers\Google\DataExportController::class, 'exportSheet'])->name('export.sheet');


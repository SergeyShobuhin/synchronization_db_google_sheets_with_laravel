<?php

use App\Http\Controllers\DataItem\DataItemController;
use Illuminate\Support\Facades\Route;

//
//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/fetch', function () {
//    return 'Hello World';
//});
//
////Route::get('dataitem/{dataitem}', [DataItemController::class, 'show'])->name('dataitem.show');
//
//Route::get('/dataitem', [DataItemController::class, 'index'])->name('dataitem.index');
//Route::get('/dataitem/create', [DataItemController::class, 'create'])->name('dataitem.create');
//Route::post('/dataitem', [DataItemController::class, 'store'])->name('dataitem.store');
//Route::get('/dataitem/{dataItem}', [DataItemController::class, 'show'])->name('dataitem.show');
//Route::get('/dataitem/{dataItem}/edit', [DataItemController::class, 'edit'])->name('dataitem.edit');
//Route::patch('/dataitem/{dataItem}', [DataItemController::class, 'update'])->name('dataitem.update');
//Route::delete('/dataitem/{dataItem}', [DataItemController::class, 'destroy'])->name('dataitem.destroy');
//Route::post('/dataitem/generate', [DataItemController::class, 'generate'])->name('dataitem.generate');
//Route::get('/dataitem/clear', [DataItemController::class, 'clear'])->name('dataitem.clear');
//
//
Route::resources([
    'dataitem' => DataItemController::class
]);

Route::post('/dataitem/generate', [\App\Http\Controllers\DataItem\GenerateController::class, 'generate'])->name('dataitem.generate');
Route::get('/clear-dataitem', [\App\Http\Controllers\DataItem\ClearController::class, 'clear'])->name('clear-dataitem');


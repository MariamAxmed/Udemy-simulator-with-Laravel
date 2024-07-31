<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setting\Category\CommandController as CategoryCommandController;
use App\Http\Controllers\Setting\Category\QueryController as CategoryQueryController;


Route::group(['prefix' => 'category'], function () {
    #QUERY
    Route::get('index', [CategoryQueryController::class, 'index']);
    Route::get('get/{id}', [CategoryQueryController::class, 'get']);
    Route::get('select', [CategoryQueryController::class, 'select']);

    #COMMAND
    Route::post('store', [CategoryCommandController::class, 'store']);
    Route::put('update/{id}', [CategoryCommandController::class, 'update']);
    Route::delete('delete/{id}', [CategoryCommandController::class, 'delete']);
});

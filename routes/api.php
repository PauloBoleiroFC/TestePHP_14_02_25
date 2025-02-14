<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequestImageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customers'], function() {
    Route::get('/', [CustomerController::class, 'list']);
    Route::post('/create', [CustomerController::class, 'create']);

    Route::group(['prefix' => '{id}'], function() {
        Route::get('/show', [CustomerController::class, 'show']);
        Route::put('/update', [CustomerController::class, 'update']);
        Route::delete('/delete', [CustomerController::class, 'delete']);
        Route::post('/attach-request', [CustomerController::class, 'attachRequest']);
    });
});

Route::group(['prefix' => 'products'], function() {
    Route::get('/', [ProductController::class, 'list']);
    Route::post('/create', [ProductController::class, 'create']);

    Route::group(['prefix' => '{id}'], function() {
        Route::get('/show', [ProductController::class, 'show']);
        Route::put('/update', [ProductController::class, 'show']);
        Route::delete('/delete', [ProductController::class, 'delete']);
    });
});

Route::group(['prefix' => 'requests'], function() {
    Route::get('/', [RequestController::class, 'list']);
    Route::post('/create', [RequestController::class, 'create']);

    Route::group(['prefix' => '{id}'], function() {
        Route::get('/show', [RequestController::class, 'show']);
        Route::put('/update', [RequestController::class, 'show']);
        Route::delete('/delete', [RequestController::class, 'delete']);
        Route::post('/attach-products', [RequestController::class, 'attachProducts']);
        Route::post('/upload-image', [RequestImageController::class, 'uploadImage']);
    });
});


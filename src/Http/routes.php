<?php

use Illuminate\Support\Facades\Route;
use KevinBHarris\EbayConnector\Http\Controllers\Admin\ConfigurationController;
use KevinBHarris\EbayConnector\Http\Controllers\Admin\ProductSyncController;
use KevinBHarris\EbayConnector\Http\Controllers\Admin\OrderSyncController;
use KevinBHarris\EbayConnector\Http\Controllers\Admin\LogController;

Route::group(['middleware' => ['admin']], function () {
    // Configuration routes
    Route::get('/configuration', [ConfigurationController::class, 'index'])->name('ebayconnector.admin.configuration.index');
    Route::post('/configuration', [ConfigurationController::class, 'store'])->name('ebayconnector.admin.configuration.store');
    Route::post('/configuration/test-connection', [ConfigurationController::class, 'testConnection'])->name('ebayconnector.admin.configuration.test');

    // Product sync routes
    Route::get('/products', [ProductSyncController::class, 'index'])->name('ebayconnector.admin.products.index');
    Route::post('/products/sync', [ProductSyncController::class, 'sync'])->name('ebayconnector.admin.products.sync');
    Route::post('/products/sync-all', [ProductSyncController::class, 'syncAll'])->name('ebayconnector.admin.products.sync-all');
    Route::get('/products/mappings', [ProductSyncController::class, 'mappings'])->name('ebayconnector.admin.products.mappings');

    // Order sync routes
    Route::get('/orders', [OrderSyncController::class, 'index'])->name('ebayconnector.admin.orders.index');
    Route::post('/orders/sync', [OrderSyncController::class, 'sync'])->name('ebayconnector.admin.orders.sync');
    Route::post('/orders/sync-new', [OrderSyncController::class, 'syncNew'])->name('ebayconnector.admin.orders.sync-new');
    Route::get('/orders/mappings', [OrderSyncController::class, 'mappings'])->name('ebayconnector.admin.orders.mappings');

    // Logs routes
    Route::get('/logs', [LogController::class, 'index'])->name('ebayconnector.admin.logs.index');
    Route::delete('/logs/{id}', [LogController::class, 'destroy'])->name('ebayconnector.admin.logs.destroy');
    Route::post('/logs/clear', [LogController::class, 'clear'])->name('ebayconnector.admin.logs.clear');
});

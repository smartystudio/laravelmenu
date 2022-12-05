<?php

use Illuminate\Support\Facades\Route;
use SmartyStudio\LaravelMenu\Http\Controllers\MenuController;

Route::group([
    'middleware' => config('laravelmenu.middleware'),
    'prefix'     => config('laravelmenu.route_prefix'),
    'namespace'  => 'SmartyStudio\LaravelMenu\Http\Controllers',
    'as'         => 'menu.'
], function () {
    Route::post('delete-item', [MenuController::class, 'destroyItem'])->name('delete-item');
    Route::post('update-item', [MenuController::class, 'updateItem'])->name('update-item');
    Route::post('add-item', [MenuController::class, 'createItem'])->name('add-item');
    Route::post('delete-menu', [MenuController::class, 'destroyMenu'])->name('delete-menu');
    Route::post('update-menu-and-items', [MenuController::class, 'generateMenuControl'])->name('update-menu-and-items');
    Route::post('create-menu', [MenuController::class, 'createNewMenu'])->name('create-menu');
});

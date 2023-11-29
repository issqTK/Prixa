<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Listing;

Route::get('/', 'App\Http\Controllers\frontController@index')->name('welcome');

Route::get('create-new-ads', function() { return Inertia::render('AdGuest/create'); })->name('guest.createAd');

Route::post('store-new-ads', 'App\Http\Controllers\AdController@storeNewAd');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function() {
    
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware('verified')->name('dashboard');   
    
    # Annonce
    Route::get('ads', 'App\Http\Controllers\AdController@index')->name('ads');
    Route::get('ad/create', 'App\Http\Controllers\AdController@create')->name('ads.create');
    Route::get('ad/{ad}/edit', 'App\Http\Controllers\AdController@edit')->name('ads.edit');
    Route::post('ad/create', 'App\Http\Controllers\AdController@store')->name('ads.store');
    Route::put('ad/{id}/edit', 'App\Http\Controllers\AdController@update')->name('ads.update');
    Route::delete('ad/{id}/delete', 'App\Http\Controllers\AdController@delete')->name('ads.delete');
    Route::post('ad/{id}/upload-images', 'App\Http\Controllers\AdController@uploadImages')->name('ad.upload.images');
    Route::get('image/{id}/delete', 'App\Http\Controllers\AdController@deleteImage')->name('ad.delete.image');
    Route::put('image/{id}/make-active', 'App\Http\Controllers\AdController@makeItActive')->name('make.it.active');

    # Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/add-profile-picture', [ProfileController::class, 'addPicture'])->name('profile.add.picture');
    
    # Listing 
    Route::get('listings', 'App\Http\Controllers\ListingController@index')->name('listing');
    Route::get('listing/create', 'App\Http\Controllers\ListingController@create')->name('listing.create');
    Route::get('listing/{listing}/edit', 'App\Http\Controllers\ListingController@edit')->name('listing.edit');
    Route::post('listing/create', 'App\Http\Controllers\ListingController@store')->name('listing.create.store');
    Route::put('listing/{listing}/edit', 'App\Http\Controllers\ListingController@update')->name('listing.edit.update');
    Route::delete('listing/{listing}/delete', 'App\Http\Controllers\ListingController@delete')->name('listing.delete');

    # Setting
    Route::get('settings', 'App\Http\Controllers\SettingController@index')->name('setting');
    Route::delete('product/{product}', 'App\Http\Controllers\SettingController@deleteProduct')->name('product.delete');
    Route::post('product/{category}', 'App\Http\Controllers\SettingController@createProduct')->name('product.create');
    Route::put('category/{id}', 'App\Http\Controllers\SettingController@updateCategory')->name('category.update');
    Route::delete('category/{id}', 'App\Http\Controllers\SettingController@deleteCategory')->name('category.delete');
    Route::post('category/{category}', 'App\Http\Controllers\SettingController@createCategory')->name('category.create');
    
    Route::delete('city/{city}', 'App\Http\Controllers\SettingController@deleteCity')->name('city.delete');    
    Route::post('city/{city}', 'App\Http\Controllers\SettingController@createCity')->name('city.create');
});

Route::get('/search', function(Request $request) { return Inertia::render('Search'); })->name('search');

require __DIR__.'/auth.php';

Route::get('/ads/{slug}', 'App\Http\Controllers\frontController@adViewer')->name('ad.view');

Route::get('/{slug}', 'App\Http\Controllers\frontController@listingViewer')->name('listing.view');

Route::fallback(function () { abort(404); });
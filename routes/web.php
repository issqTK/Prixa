<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Listing;

Route::get('/', function () { 
    $ads = Ad::with(['images' => function($active){
            $active->select('ad_id','source')->where('active', 1);
        }])
        ->select('id','title', 'description', 'price', 'slug')
        ->latest()
        ->take(9)
        ->get();

    $listings = Listing::latest()->get();

    return Inertia::render('Welcome', [
        'ads' => $ads,
        'listings' => $listings,
    ]);
})->name('welcome');

Route::get('create-new-ads', function() { return Inertia::render('AdGuest/create'); })->name('guest.createAd');

Route::post('store-new-ads', 'App\Http\Controllers\AdController@storeNewAd');

/* Annonce */
Route::group(['middleware' => 'auth', 'prefix' => 'annonce'], function() {
    Route::get('list', 'App\Http\Controllers\AdController@index')->name('ads');
    Route::get('create', 'App\Http\Controllers\AdController@create')->name('ads.create');
    Route::get('{ad}/edit', 'App\Http\Controllers\AdController@edit')->name('ads.edit');

    Route::post('create', 'App\Http\Controllers\AdController@store')->name('ads.store');
    Route::put('{id}/edit', 'App\Http\Controllers\AdController@update')->name('ads.update');
    Route::delete('{id}/delete', 'App\Http\Controllers\AdController@delete')->name('ads.delete');

    Route::post('{id}/upload-images', 'App\Http\Controllers\AdController@uploadImages')->name('ad.upload.images');
    Route::get('/image/{id}/delete', 'App\Http\Controllers\AdController@deleteImage')->name('ad.delete.image');
    Route::put('/{id}/make-active', 'App\Http\Controllers\AdController@makeItActive')->name('make.it.active');

});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function() {
    
    Route::get('/dashboard', function () { 
        $totalAds = Ad::query()
            ->when(!Auth::user()->admin, function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->count();

        $activeAds = Ad::query()
            ->when(!Auth::user()->admin, function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->where('confirmed', true)
            ->count();

        $inactiveAds = Ad::query()
            ->when(!Auth::user()->admin, function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->where('confirmed', false)
            ->count();

        return Inertia::render('Dashboard', [
            'totalAds' => $totalAds,
            'activeAds' => $activeAds,
            'inactiveAds' => $inactiveAds,
        ]);
    })->middleware('verified')->name('dashboard');    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/add-profile-picture', [ProfileController::class, 'addPicture']);
    
    /* listings */
    Route::get('listing', 'App\Http\Controllers\ListingController@index')->name('listing');
    Route::get('listing/create', 'App\Http\Controllers\ListingController@create')->name('listing.create');
    Route::get('listing/{listing}/edit', 'App\Http\Controllers\ListingController@edit')->name('listing.edit');


    Route::post('listing/create', 'App\Http\Controllers\ListingController@store')->name('listing.create.store');
    Route::put('listing/{listing}/edit', 'App\Http\Controllers\ListingController@update')->name('listing.edit.update');
    Route::delete('{listing}/delete', 'App\Http\Controllers\ListingController@delete')->name('listing.delete');


});

Route::get('/search', function(Request $request) {
    return Inertia::render('Search');
})->name('search');

require __DIR__.'/auth.php';

Route::get('/listing/{slug}', 'App\Http\Controllers\ListingController@listingViewer')->name('listing.view');

Route::get('/{slug}', 'App\Http\Controllers\AdController@adViewer')->name('ad.view');

Route::fallback(function () {
    echo 'opss you may been lost <a href="/">back to home page</a>';
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\City;
use App\Models\Product;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Ad;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-admin-logo', [ApiController::class, 'adminLogo']);

Route::get('get-cities-all', [ApiController::class, 'citiesAll']);

Route::get('get-categories-all', [ApiController::class, 'categoriesAll']);

Route::get('get-products-all', [ApiController::class, 'productsAll']);

Route::get('get-product-filter/{string?}', [ApiController::class, 'filterProductByStr']);

Route::get('get-products_filtred_by_category/{id}', [ApiController::class, 'filterProductByCat']);

Route::get('phone-already-exist/{phone}', [ApiController::class, 'phoneExist']);

Route::get('email-already-exist/{email}', [ApiController::class, 'emailExist']);

Route::get('listing/{slug}', [ApiController::class, 'listings']);

Route::get('search', [ApiController::class, 'search']);

Route::post('save-listing-image/{listing}', [ApiController::class, 'saveListingImg']);

Route::middleware('auth:sanctum')->get('/list-ads', [ApiController::class, 'listAds']);
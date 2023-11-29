<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Listing;

class frontController extends Controller
{
    public function index() {
        $ads = Ad::with(['images' => function($active){
                $active->select('ad_id','source')->where('active', 1);
            }])
            ->select('id','title', 'description', 'price', 'slug')
            ->latest()
            ->take(9)
            ->get();

        $listings = Listing::latest()->get();

        return inertia()->render('Welcome', [
            'ads' => $ads,
            'listings' => $listings,
        ]);
    }

    public function adViewer($slug) {
        $ad = Ad::where('slug', $slug)->first();

        if(!$ad) return redirect('/');

        $city = $ad->city;
        $product = $ad->product;
        $images = $ad->images;

        $user = $ad->user;


        return inertia()->render('AdView', [
            'ad' => $ad,
        ]);
    }

    public function listingViewer($slug) {
        $listing = Listing::where('slug', $slug)->first();

        if(!$listing) return redirect('/');

        return inertia()->render('Listing', ['listing' => $listing]);
    }
}

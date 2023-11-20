<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Product;

class ListingController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if(!auth()->user()->admin)
                return back();

            return $next($request);
        });
    }

    public function index() {

        $listings = Listing::query()
                    ->with('city')
                    ->latest()
                    ->get()
                    ->map(fn($query) => [
                        'id' => $query->id,
                        'title' => $query->title,
                        'avatar' => $query->avatar,
                        'product_count' => count($query->product_ids),
                        'city' => $query->city->name
                    ]);

        return inertia('Listing/Display', ['listings' => $listings]);
    }

    public function create() {
        return inertia('Listing/Create');
    }
   
    public function edit($id) {
        $listing = Listing::find($id);
        
        $selectedProducts = Product::whereIn('id', $listing->product_ids)->get(['id','name','category_id']);

        return inertia('Listing/Edit', ['listing' => $listing, 'selectedProducts' => $selectedProducts]);
    }
   
    public function store(Request $request) {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description_head' => 'required|string',
            'description_foot' => 'required|string',
            
            'city' => 'required|integer',
            'category' => 'required|integer',
            'product' => 'required',

            'meta_title' =>'required|string|max:255|unique:listings',
            'meta_description' => 'required|string',
            'slug' => 'required|string',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        if($request->hasFile('image')) {
            $file = $request->file('image');

            $name = time() . $file->getClientOriginalName();

            $file->move(public_path().'/storage/images/listings/', $name);
        }

        Listing::create([
            'title' => $request->title,
            'description_header' => $request->description_head,
            'description_footer' => $request->description_foot,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'slug' => $request->slug,
            'product_ids' => $request->product,
            'city_id' => $request->city,
            'avatar' => $name

        ]);

        return redirect()->back()->with(['success' => 'Listing has been created successfuly']);
    }

    public function update(Request $request, $listing) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description_head' => 'required|string',
            'description_foot' => 'required|string',
            'city' => 'required|integer',
            'category' => 'required|integer',
            'product' => 'required',
            'meta_description' => 'required|string',
        ]);

        Listing::find($listing)->update([
            'title' => $request->title,
            'description_header' => $request->description_head,
            'description_footer' => $request->description_foot,
            'meta_description' => $request->meta_description,
            'product_ids' => $request->product,
            'city_id' => $request->city,
        ]);

        return redirect()->route('listing')->with(['success' => 'Listing has been updated successfuly']);
    }

    public function delete($listing) {
        Listing::find($listing)->delete();
        return back()->with(['success' => 'Listing has been deleted successfuly']);
    }

    public function listingViewer($slug) {
        $listing = Listing::where('slug', $slug)
        ->first();

        if(!$listing) return redirect('/');

        return Inertia::render('Listing', ['listing' => $listing]);
    }
}

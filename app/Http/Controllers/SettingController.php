<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\City;
use App\Models\Logo;
use App\Models\Listing;
use App\Models\Ad;

class SettingController extends Controller
{

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if(!auth()->user()->admin)
                return back();

            return $next($request);
        });
    }
    
    public function index() {
        $logos = Logo::first();

        return inertia()->render('Setting/Index', [
            'logos' => $logos
        ]);
    }

    public function deleteProduct($product) {
        $product = Product::find($product);

        $contains = Listing::whereJsonContains('product_ids', $product->id)->first();

        $contains_in_ads = Ad::where('product_id', $product)->first();

        if(!is_null($contains))
            return back()->with(['error' => __("Can't delete product which is attached to listing!")]);

        if(!is_null($contains_in_ads))
            return back()->with(['error' => __("Can't delete product which is attached to ads!")]);

        $product->delete();
        
        return back()->with(['successTwo' => __('Successfully Deleted')]);
    }
   
    public function createProduct(Request $request, $category) {
        if($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $name = time() . $file->getClientOriginalName();

            $file->move(public_path().'/images/phones/', $name);
        }

        $product = Product::create([
            'name' => $request->name,
            'avatar' => $name,
            'category_id' => $category
        ]);

        return back()->with([
            'successTwo' => __('Successfully Added'),
            'data' => $product
        ]);
    }

    public function updateCategory(Request $request, $id) {
        $cat = Category::find($id);
        
        $cat->name = $request->name;

        $cat->save();

        return back()->with(['successTwo' => __('Successfully Updated')]);

    }

    public function deleteCategory($id) {
        $products = Product::where('category_id', $id)->get();

        $contains = null;
        $contains_in_ads = null;

        foreach( $products as $product ) {
            $contains = Listing::where('product_ids', 'like', "%{$product->id}%");

            if($contains)
                break;
        }

        foreach( $products as $product ) {
            $contains_in_ads = Ad::where('product_id', $product->id);

            if($contains_in_ads)
                break;
        }


        if(!is_null($contains))
            return back()->with(['error' => __("Can't delete category which is attached to listing!")]);

        if(!is_null($contains_in_ads))
            return back()->with(['error' => __("Can't delete category which is attached to ads!")]);

        Product::where('category_id', $id)->delete();

        Category::find($id)->delete();

        return back()->with(['success' => __('Successfully Deleted')]);
    }
   
    public function createCategory($category) {
        $cat = Category::create([
            'name' => $category,
            'created_at' => NOW()
        ]);

        return back()->with([
            'successTwo' => __('Successfully Created'),
            'data' => $cat
        ]);
    }
    
    public function createCity($city) {
        $c = City::create([
            'name' => $city,
            'created_at' => NOW()
        ]);

        return back()->with([
            'successThree' => __('Successfully Created'),
            'data' => $c
        ]);
    }

    public function deleteCity($city) {
        $city = City::find($city);

        $contains_in_ads = Ad::where('city_id', $city->id)->first();

        $contains_in_listings = Listing::where('city_id', $city->id)->first();

        if(!is_null($contains_in_ads)) 
            return back()->with(['error_two' => __("Can't delete city which is attached to ads!")]);

        if(!is_null($contains_in_listings)) 
            return back()->with(['error_two' => __("Can't delete city which is attached to listings!")]);

        $city->delete();
        
        return back()->with(['successTwo' => __('Successfully Deleted')]);
    }

    public function updateFrontLogo(Request $request) {
        if($request->hasFile('file')) {
            $file = $request->file('file');

            $name = time() . $file->getClientOriginalName();

            $file->move(public_path().'/images/logos/', $name);

            $logo = Logo::find(1);

            $logo->frontLogo = $name;

            $logo->save();
            }
    }
    public function updateBackLogo(Request $request) {
        if($request->hasFile('file')) {
            $file = $request->file('file');

            $name = time() . $file->getClientOriginalName();

            $file->move(public_path().'/images/logos/', $name);

            $logo = Logo::find(1);

            $logo->backLogo = $name;

            $logo->save();
        }
    }
    public function updateFaviconLogo(Request $request) {
        if($request->hasFile('file')) {
            $file = $request->file('file');

            $name = time() . $file->getClientOriginalName();

            $file->move(public_path().'/images/logos/', $name);

            $logo = Logo::find(1);

            $logo->faviconLogo = $name;

            $logo->save();
        }
    }
}

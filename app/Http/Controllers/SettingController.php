<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\City;
use App\Models\Logo;

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
        Product::find($product)->delete();
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
        City::find($city)->delete();

        return back()->with(['successTwo' => __('Successfully Deleted')]);
    }
}

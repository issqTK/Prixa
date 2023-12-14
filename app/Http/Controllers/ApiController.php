<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Product;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Ad;
use App\Models\Logo;

class ApiController extends Controller
{
    public function adminLogo() {
        return Logo::find(1);

    }

    public function citiesAll() {
        return City::all();
    }
 
    public function categoriesAll() {
        return Category::withCount('products')->get();
    }

    public function productsAll() {
        return Product::all();
    }
    
    public function filterProductByStr(Product $product, $string) {
        $data = $product
                ->whereRaw('REPLACE(name, " ", "") REGEXP REPLACE("' . $string . '", " ", "")')
                ->get();
    
        return response()->json($data);
    }
    
    public function filterProductByCat($id) {
        return Product::where('category_id', $id)->get();
    }

    public function phoneExist(User $user, $phone) {
        $exist = $user->where('phone', $phone)->first();
    
        if($exist) return response()->json(['exist' => true]);
    }

    public function emailExist(User $user, $email) {
        $exist = $user->where('email', $email)->first();
    
        if($exist) return response()->json(['exist' => true]);
    }

    public function listings($slug) {
        $listing = Listing::where('slug', $slug)->first();
    
        $ads = Ad::whereIn('product_id', $listing->product_ids)
        ->where('city_id', $listing->city_id)
        ->with([ 
            'images' => function($active) { 
                $active->select('ad_id','source')->where('active', 1); 
            },
            'city' => function($city) { 
                $city->select('id','name');
            }
        ])
        ->latest()
        ->paginate(6)
        ->through(fn($query) => [
            'title' => $query->title,
            'description' => $query->description,
            'price' => $query->price,
            'out_price' => $query->out_price,
            'slug' => $query->slug,
            'city' => $query->city,
            'images' => $query->images,
            'created_at' => $query->created_at
        ]);
            
    
    
        return $ads;
    }

    public function search(Request $request) {

        $category = $request->category;
        $city = $request->city;
    
        $results = Ad::query()
            ->with( [
                'images' => function($active) { 
                    $active->select('ad_id','source')->where('active', 1); 
                },
                'city' => function($city) { 
                    $city->select('id','name');
                }
            ])    
            ->when($category != null, function($q) use($category) {
                $q->whereIn('product_id', Category::find($category)->products->pluck('id'));
            })
            ->when($city != null, function($q) use($city) {
                $q->where('city_id', '=', $city);
            })
            ->where('title', 'like', '%' . $request->search . '%')
            ->latest()
            ->paginate(6)
            ->through(fn($query) => [
                'title' => $query->title,
                'description' => $query->description,
                'price' => $query->price,
                'out_price' => $query->out_price,
                'slug' => $query->slug,
                'city' => $query->city,
                'images' => $query->images,
                'created_at' => $query->created_at
            ]);
    
        return $results;
    }

    public function saveListingImg($listing, Request $request){
        if($request->hasFile('myFile')) {
            $file = $request->file('myFile');
    
            $name = time() . $file->getClientOriginalName();
    
            $file->move(public_path().'/storage/images/listings/', $name);
    
            Listing::find($listing)->update(['avatar' => $name]);
    
            return redirect()->back()->with(['successTwo' => 'Image has been updated successfuly']);
        }
    }

    public function listAds(Request $request) {
        $user = $request->user();
        
        $ads = Ad::query()
            ->with(['images','city', 'product'])
            ->when(!$user->admin, function($q) use($user){
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(5)
            ->through(fn($query) => [
                'id' => $query->id,
                'title' => $query->title,
                'images' => $query->images->count(),
                'city' => $query->city->name,
                'product' => $query->product->name,
                'state' => $query->state
            ]);
    
        return $ads;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


use App\Models\User;
use App\Models\Ad;
use App\Models\Image;


class AdController extends Controller
{
    public function index() {
        return Inertia::render('Ads/List', [
            'areYouSure' => __('Are you sure you want to delete this ad?'),
        ]);
    }

    public function create() {
        return Inertia::render('Ads/Create', [
            'pictures_allowed' => __('only 8 pictures allowed!')
        ]);
    }

    public function edit($id) {
        $ads = Ad::query()
        ->with(['images', 'product'])
        ->where('id', $id)
        ->when(!Auth::user()->admin, function($q) {
            return $q->where('user_id', Auth::user()->id);
        })
        ->first();
        
        if($ads == null) abort(404);

        return Inertia::render('Ads/Edit', [
            'ad' => $ads,
            'areYouSure' => __('Are you sure you want to delete this ad?'),
            'pictures_allowed' => __('only 8 pictures allowed!')
        ]);
    }

    public function store(Request $request) {
        $admin = Auth::user()->admin;
        
        $valid = $request->validate([
            'title' => 'required|string|max:255|unique:ads',
            'description' => 'required|string',
            'price' => 'required|numeric|digits_between:1,1000000',
            'outPrice' => 'nullable|numeric|digits_between:1,1000000',
            'product' => 'required|integer',
            'city' => 'required|integer',
            
            'meta_title' => $admin ? 'required' : 'nullable' . '|string|max:255',
            'meta_description' => $admin ? 'required' : 'nullable' . '|string',
            'slug' => $admin ? 'required': 'nullable' . '|string|max:255',

            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480'
        ]);

        if(!$admin) $slug = strtolower(str_replace(" ", "-", trim($request->title)));

        $ad = Ad::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'out_price' => $request->outPrice,
            'meta_title' => $admin ? $request->meta_title : $request->title,
            'meta_description' => $admin ? $request->meta_description : $request->description,
            'slug' => $admin ? $request->slug : $slug,
            'user_id' => Auth::user()->id,
            'product_id' => $request->product,
            'city_id' => $request->city,
            'created_at' => NOW()
        ]);

        if($admin) {
            $ad->state = $request->state;
            $ad->save();
        }


        if($request->hasFile('images')) {
            foreach($request->file('images') AS $file) {
                $name = time() . $file->getClientOriginalName();

                $file->move(public_path().'/storage/images/ads/', $name);

                Image::create([
                    'source' => $name,
                    'ad_id' => $ad->id,
                ]);
            }

            Image::where('ad_id', $ad->id)->first()->update([ 'active' => true ]);
   
        }

        return redirect()->back()->with(['success' => __('Ad was created successfully, you may create another')]);
    }

    public function update(Request $request, $id) {
        $admin = Auth::user()->admin;

        $valide = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|digits_between:1,1000000',
            'outPrice' => 'required|numeric|digits_between:1,1000000',
            'product' => 'required|integer',
            'city' => 'required|integer',
            'meta_title' => $admin ? 'required' : 'nullable' . '|string|max:255',
            'meta_description' => $admin ? 'required' : 'nullable' . '|string',
            'slug' => $admin ? 'required': 'nullable' . '|string|max:255',
        ]);

        if(!$admin)
            $slug = strtolower(str_replace(" ", "-", trim($request->title)));

        Ad::find($id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'out_price' => $request->outPrice,                
                'meta_title' => $admin ? $request->meta_title : $request->title,
                'meta_description' => $admin ? $request->meta_description : $request->description,
                'slug' => $admin ? $request->slug : $slug,
                'user_id' => Auth::user()->id,
                'product_id' => $request->product,
                'city_id' => $request->city,
                'updated_at' => NOW()
            ]);

        if($admin) {
            $ad = Ad::find($id);
            $ad->state = $request->state;
            $ad->save();
        }

        return redirect()->back()->with(['success' => __('Ad was Updated successfully')]);
    }

    public function delete($id) {
        $ad = Ad::find($id);
        
        $images = Image::where('ad_id', $ad->id)->get();

        $ad->delete();

        foreach ($images as $img) {
            $path = public_path('images/ads/').$img->source;
            
            if(file_exists($path)) @unlink($path);
            
            $img->delete();
        }

        return redirect()->route('ads')->with(['success' => __('Ad has been deleted successfuly')]);
    }

    public function deleteImage($id) {
        $img = Image::where('id', $id)->first();
        
        $path = public_path('/storage/images/ads/').$img->source;
        
        if(file_exists($path)) {
            @unlink($path);
        }

        $img->delete();

        return redirect()->back()->with(['successTwo' => __('Image was successfully deleted')]);
    }

    public function uploadImages(Request $request, $adID) {

        if($request->hasFile('files')) {
            
            $images = [];

            foreach($request->file('files') AS $index => $file) {
                $name = time() . $file->getClientOriginalName();

                $file->move(public_path().'/storage/images/ads/', $name);

                $images[$index] = Image::create([
                    'source' => $name,
                    'ad_id' => $adID,
                ]);
            }

            Image::where('ad_id', $adID)->first()->update([ 'active' => true ]);
   
        }

        return redirect()->back()->with(['successTwo' => __('Images was successfully created'), 'data' => $images]);
        
    }

    public function makeItActive(Request $request, $image) {
        Image::where('ad_id', $request->adID)->where('active', true)->update(['active' => false]);

        Image::find($image)->update(['active' => true]);
        
        return back()->with(['successTwo' => __('Image Active Updated Successfully')]);
    } 

    /* Create Ad Guest */
    public function storeNewAd(Request $request) {
        
        $user = User::create([
            'name' => $request->fullName,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'store_address' => $request->shop,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $ad = Ad::create([
            'title' => $request->title,
            'description' => $request->description,
            'meta_title' => $request->title,
            'meta_description' => $request->description,
            'price' => $request->price,
            'user_id' => $user->id,
            'product_id' => $request->product['id'],
            'city_id' => $request->city,
            'slug' => $request->slug
        ]);

        if($request->hasFile('images')) {
            foreach($request->file('images') AS $file) {
                $name = time() . $file->getClientOriginalName();

                $file->move(public_path().'/storage/images/ads/', $name);

                Image::create([
                    'source' => $name,
                    'ad_id' => $ad->id,
                ]);
            }

            Image::where('ad_id', $ad->id)->first()->update([
                'active' => true
            ]);
   
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;

class DashboardController extends Controller
{
    public function index() {
        $totalAds = Ad::query()
            ->when(!Auth::user()->admin, function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->count();

        $activeAds = Ad::query()
            ->when(!Auth::user()->admin, function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->where('state', 'Valid')
            ->count();

        $inactiveAds = Ad::query()
            ->when(!Auth::user()->admin, function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->where('state', '!=', 'Valid')
            ->count();

        return inertia()->render('Dashboard', [
            'totalAds' => $totalAds,
            'activeAds' => $activeAds,
            'inactiveAds' => $inactiveAds,
        ]);
    }
}

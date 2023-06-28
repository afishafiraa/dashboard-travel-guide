<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TrxQrcode;
use App\Tourism;
use App\Merchant;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $guide = User::count();
        $merchant = Merchant::count();
        $trans = TrxQrcode::count();
        $tourism = Tourism::count();
        $rank = User::role('guide')->with('detail')->withCount('transactions')
        ->orderBy('points','desc')
        ->take(5)
        ->get();
        return view('admin.home', compact('guide','merchant','trans','tourism','rank'));
    }
}

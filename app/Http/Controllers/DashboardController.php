<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $totalClick = ShortenedUrl::where('user_id', Auth::user()->id)->sum('click_count');

        return view('dashboard', compact('totalClick'));
    }
}

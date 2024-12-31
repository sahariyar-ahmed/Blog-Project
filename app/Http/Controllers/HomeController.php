<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as ModelRequest;
use Illuminate\Support\Facades\Auth;

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
        $request = ModelRequest::where('user_id',Auth::user()->id)->first();
        return view('dashboard.home.index',compact('request'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function index()
    {
        $videos = Video::all();
        return view('welcome', compact('videos'));
    }


    public function GetUserInfo(User $user){
        return $user;
    }
}

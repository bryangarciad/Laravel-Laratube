<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $Video){

        if(request()->wantsJson()){
            return $Video;
        }
        else{
            return view('video', compact('Video'));
        }
        
    }

    public function updateViews(Video $video){
        $video->increment('views');
        return $video;

    }
}

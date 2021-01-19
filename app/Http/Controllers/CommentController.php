<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Video $video){

        return $video->comments()->paginate(5);
          
    }

    public function getUserName(Comment $comment){
        return $comment->user();
    }

    public function store(Video $video){

        return Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $video->id,
            'body' => request()->body
        ]);
    }
}

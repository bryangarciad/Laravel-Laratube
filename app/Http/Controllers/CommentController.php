<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Video $video){

        return $video->comments()->paginate(5);
          
    }

    public function getUserName(Comment $comment){
        return $comment->user();
    }
}

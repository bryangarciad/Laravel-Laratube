<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Video $video){

        return $video->comments()->paginate(5);
          
    }

    public function show(Comment $comment){
        $allComments = Comment::where('comment_id', $comment->id)->get();
        for($i=0; $i < count($allComments); $i++){
            $allComments[$i]->user = User::where('id', $allComments[$i]->user_id)->first();
        }
        return $allComments;
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

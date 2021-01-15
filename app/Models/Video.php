<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    use HasFactory;
    
    public function channel(){
       return $this->belongsTo(Channel::class);
    }

    public function isEditable(Video $video){
       return Auth::check() && $video->channel->user_id == Auth::id();
    }
}

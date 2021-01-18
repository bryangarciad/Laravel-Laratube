<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaTrait;

    public function user(){
        $this->belongsTo(User::class);
    }

    public function image(){
        if($this->media->first()){
            return str_replace('http://localhost/', '', $this->media->first()->getFullUrl(''));
        }
        else{
            return null;
        }
    }

    public function registerMediaConversions(?Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(90)->height(90);
    }

    public function editable(){
        return $this->user_id === Auth::id();
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function videos(){
        return $this->hasMany(Video::class);
    }
}

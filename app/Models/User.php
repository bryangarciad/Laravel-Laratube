<?php

namespace App\Models;

use illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public $incrementing = false;

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = Str::uuid();
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function channel(){
        return $this->hasOne(Channel::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}

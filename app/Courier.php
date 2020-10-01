<?php

namespace App;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\Seller as Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'couriers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard = 'courier';

    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'phone_number_1', 'phone_number_2', 'active', 'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

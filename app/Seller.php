<?php

namespace App;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\Seller as Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard = 'seller';

    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'phone_number_1', 'phone_number_2', 'store_name', 'store_pics', 'address_1', 'address_2', 'city', 'country', 'zip', 'business_reg_no', 'business_reg_doc', 'tin', 'vat', 'vat_info_doc', 'company_name', 'bank_name', 'acct_holder_name', 'bank_acct_number', 'bank_code', 'iban', 'swift', 'bank_info', 'active', 'activation_token'
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

    public function goods(){
        return $this->hasMany('App\Good');
    }

    public function reviews(){
        return $this->hasMany('App\Review');
    }

}

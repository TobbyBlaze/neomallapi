<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //Table name
    protected $table = 'orders';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        // id,

        'user_id',
        // 'name',
        // 'description',
        // 'image',
        // 'price',
        // 'category',

        // 'quantity',

        // 'name',
        'first_name',
        'last_name', 
        'country', 
        'address1', 
        'address2', 
        'city', 
        'state', 
        'zip', 
        'phone', 
        'email'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function orders(){
        return $this->belongsTo('App\User');
    }

    // public function ordergoods(){
    //     return $this->belongsTo('App\Good');
    // }

    // public function carts(){
    //     return $this->hasMany('App\Order');
    // }

}

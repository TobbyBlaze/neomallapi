<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use Notifiable;
    //Table name
    protected $table = 'order_products';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        // 'id',
        'order_id',
        'good_id',
        'quantity',
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

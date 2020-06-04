<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Notifiable;
    //Table name
    protected $table = 'carts';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    // protected $fillable = [
    //     // 'id',
    //     'user_id',
    //     'good_id',
    // ];

    // public function user(){
    //     return $this->belongsTo('App\User');
    // }

    // public function carts(){
    //     return $this->belongsTo('App\User');
    // }

    // public function cartgoods(){
    //     return $this->belongsTo('App\Good');
    // }

    // // public function orders(){
    // //     return $this->hasMany('App\Order');
    // // }

    protected $fillable = [
        // 'id',
        'user_id',
        'name',
        'description',
        'image',
        'price',
        'category',
        'quantity',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function goods(){
        return $this->belongsTo('App\User');
    }

    public function cartgoods(){
        return $this->hasMany('App\Cart');
    }

    // public function ordergoods(){
    //     return $this->hasMany('App\Order');
    // }

    public function goodsreview(){
        return $this->hasMany('App\Review');
    }

}

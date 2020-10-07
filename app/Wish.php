<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    //Table name
    protected $table = 'wishes';
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
        'good_id',
        'name',
        'description',
        'image',
        'price',
        'category',
        'quantity',
        'color',
        'color_image'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function goods(){
        return $this->belongsTo('App\User');
    }

    public function wishgoods(){
        return $this->hasMany('App\Wish');
    }

    // public function ordergoods(){
    //     return $this->hasMany('App\Order');
    // }

    public function goodsreview(){
        return $this->hasMany('App\Review');
    }
}

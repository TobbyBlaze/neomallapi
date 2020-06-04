<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use Notifiable;
    //Table name
    protected $table = 'goods';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        // 'id',
        'user_id',
        'name',
        'description',
        'image',
        'price',
        'category',
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

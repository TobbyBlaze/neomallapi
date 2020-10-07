<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //Table name
    protected $table = 'ads';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        // 'id',
        'seller_id',
        'seller_name',
        'name',
        'description',
        'image',
        'price',
        'category',
        'countryName',
        'cityName'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function ads(){
        return $this->belongsTo('App\User');
    }

}

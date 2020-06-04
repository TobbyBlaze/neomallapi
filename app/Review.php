<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use Notifiable;
    //Table name
    protected $table = 'reviews';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        // 'id',
        'user_id',
        'good_id',
        'rating',
        'body',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function goodsreview(){
        return $this->belongsTo('App\Good');
    }

}

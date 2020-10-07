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
        'user_name',
        'good_id',
        'rating',
        'body',
        'summary'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function goodsreview(){
        return $this->belongsTo('App\Good');
    }

}

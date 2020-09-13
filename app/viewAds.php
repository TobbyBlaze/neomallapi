<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class viewAds extends Model
{
    //Table name
    protected $table = 'view_ads';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
}

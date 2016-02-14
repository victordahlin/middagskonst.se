<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DinnerBags extends Model {

    protected $table = 'dinner_bags';
    protected $fillable = ['id', 'title', 'text'];
    public $timestamps = false;

}

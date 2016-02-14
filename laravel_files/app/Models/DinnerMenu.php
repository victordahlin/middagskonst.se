<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DinnerMenu extends Model {

    protected $table = 'dinner_menus';
    protected $fillable = ['title', 'starter', 'main', 'dessert', 'text', 'week'];
    public $timestamps = false;

}

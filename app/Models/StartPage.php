<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class StartPage extends Model
{
    protected $table = 'startpage';
    protected $fillable = ['id', 'title', 'text'];
    public $timestamps = false;
}

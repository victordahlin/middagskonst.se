<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HowItWorks extends Model
{
    protected $table = 'how_it_works';
    protected $fillable = ['id', 'title', 'text'];
    public $timestamps = false;
}

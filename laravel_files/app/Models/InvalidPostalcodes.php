<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class InvalidPostalcodes extends Model
{
    protected $table = 'invalid_postalcodes';
    protected $fillable = array('postalcode');
}

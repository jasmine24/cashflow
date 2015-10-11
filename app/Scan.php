<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model {
    public $timestamps = false;
    //database used by the model
    protected $table = 'scans';

    //items mass assignable
    protected $fillable = ['userEmail', 'sku', 'type'];

}

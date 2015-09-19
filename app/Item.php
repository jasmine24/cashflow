<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	//database used by the model
    protected $table = 'items';

    //items mass assignable
    protected $fillable = ['item_name','sku','price','quantity', 'user'];

}

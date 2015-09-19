<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    //database used by the model
    protected $table = 'transactions';

    //items mass assignable
    protected $fillable = ['transaction_id', 'user_id','item_name', 'price', 'quantity', 'sku', 'status'];

}

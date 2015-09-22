<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {

    //database used by the model
    protected $table = 'receipts';

    //items mass assignable
    protected $fillable = ['transaction_id', 'user_id','total', 'cash_received', 'change', 'notes', 'status'];

}

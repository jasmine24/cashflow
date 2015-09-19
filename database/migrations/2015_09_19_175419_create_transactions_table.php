<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('transactions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('user_id');
            $table->string('item_name');
            $table->bigInteger('sku');
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('transactions');
	}

}

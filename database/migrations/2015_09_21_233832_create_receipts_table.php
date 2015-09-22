<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('receipts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('user_id');
            $table->decimal('total');
            $table->decimal('cash_received');
            $table->decimal('change');
            $table->string('notes');
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
        Schema::drop('receipts');
	}

}

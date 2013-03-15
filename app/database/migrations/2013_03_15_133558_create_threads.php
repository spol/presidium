<?php

use Illuminate\Database\Migrations\Migration;

class CreateThreads extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('threads', function($table)
		{
			$table->increments('id');
			$table->string('topic');
			$table->integer('created_by');
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
		Schema::drop('threads');
	}

}
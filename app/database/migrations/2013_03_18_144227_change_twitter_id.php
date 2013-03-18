<?php

use Illuminate\Database\Migrations\Migration;

class ChangeTwitterId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->string('temp');
		});

		DB::table('users')->update(array('temp' => DB::Raw('twitter_id')));

		Schema::table('users', function($table)
		{
			$table->dropColumn('twitter_id');
		});

		Schema::table('users', function($table)
		{
			$table->string('twitter_id');
		});

		DB::table('users')->update(array('twitter_id' => DB::Raw('temp')));

		Schema::table('users', function($table)
		{
			$table->dropColumn('temp');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
			//
		});
	}

}
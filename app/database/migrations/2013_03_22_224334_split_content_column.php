<?php

use Illuminate\Database\Migrations\Migration;

class SplitContentColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('posts', function($table)
		{
			$table->text('markdown');
			$table->text('html');
		});

		DB::update("UPDATE posts SET markdown = content");

		Schema::table('posts', function($table)
		{
			$table->dropColumn('content');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('posts', function($table)
		{
			Schema::table('posts', function($table)
			{
				$table->text('content');
			});

			DB::update("UPDATE posts SET content = markdown");

			Schema::table('posts', function($table)
			{
				$table->dropColumn('markdown');
				$table->dropColumn('html');
			});
		});
	}

}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStreamerIdToEditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('edits', function(Blueprint $table)
		{
			$table->dropColumn('element');
		});

		Schema::table('edits', function(Blueprint $table)
		{
			$table->integer('streamer_id')->nullable();
			$table->integer('team_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('edits', function(Blueprint $table)
		{
			$table->dropColumn('streamer_id');
			$table->dropColumn('team_id');
		});
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTagsAndCustomtagsToTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teams', function(Blueprint $table)
		{
			$table->string('tags')->nullable();
			$table->string('customtags')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('teams', function(Blueprint $table)
		{
			
		});
	}

}

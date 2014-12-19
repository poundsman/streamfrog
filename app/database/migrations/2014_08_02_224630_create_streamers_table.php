<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStreamersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('streamers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('apikey')->unique()->nullable();
			$table->string('name')->nullable();
			$table->integer('team')->nullable();
			$table->string('type')->nullable();
			$table->string('twitch')->nullable();
			$table->integer('mlg')->nullable();
			$table->string('url')->nullable();
			$table->string('twitter')->nullable();
			$table->integer('status')->nullable();
			$table->integer('viewers')->nullable();
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
		Schema::drop('streamers');
	}

}

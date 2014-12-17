<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStreamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('streams', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('streamer_id')->nullable();
			$table->string('status')->nullable();
			$table->timestamp('ended_at');
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
		Schema::drop('streams');
	}

}

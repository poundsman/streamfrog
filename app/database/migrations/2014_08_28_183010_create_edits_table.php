<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('edits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type')->nullable();
			$table->string('element')->nullable();
			$table->integer('by')->nullable();
			$table->string('attribute')->nullable();
			$table->string('old')->nullable();
			$table->string('new')->nullable();
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
		Schema::drop('edits');
	}

}

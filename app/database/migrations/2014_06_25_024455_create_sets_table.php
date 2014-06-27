<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('sets')) {
			Schema::create('sets', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 255);
				$table->string('short', 5)->unique();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sets', function(Blueprint $table)
		{
			Schema::dropIfExists('sets');
		});
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('decks')) {
			Schema::create('decks', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('slug');
				$table->timestamps();
				$table->timestamp('deletes_on');
				$table->string('forked')->nullable();
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
		Schema::drop('decks');
	}

}

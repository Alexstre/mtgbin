<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardDeckTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('card_deck')) {
			Schema::create('card_deck', function(Blueprint $table)
			{
				$table->increments('id');

				$table->integer('deck_id');
				$table->integer('card_id');
				$table->integer('amount');
				$table->boolean('maindeck');
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
		Schema::drop('card_deck');
	}

}

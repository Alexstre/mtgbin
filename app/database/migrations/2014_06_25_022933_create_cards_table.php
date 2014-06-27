<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('cards')) {
			Schema::create('cards', function(Blueprint $table)
			{
				// Creating the schema for the cards table, based on mtgjson's format
				$table->increments('id');

				$table->string('name', 255);
				$table->string('types', 255)->nullable();
				$table->string('supertypes', 255)->nullable();
				$table->string('mana', 50)->nullable();
				$table->double('cmc')->nullable();
				$table->string('rarity', 100)->nullable();
				$table->string('power', 10)->nullable();
				$table->string('toughness')->nullable();
				$table->integer('set_id');			
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
		Schema::table('cards', function(Blueprint $table)
		{
			Schema::dropIfExists('cards');
		});
	}

}

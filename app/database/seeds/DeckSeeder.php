<?php

class DeckSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/* We'll create a new deck */
		$deck = new Deck;
		$deck->slug = 'A9h2jJ';
		$deck->save();

		/* Let's find a bunch of cards randomly and add them to the deck */
		$count = Card::count();
		$nc = 0;
		while ($nc < 75) {
			$card = Card::find(rand(1,$count));
			$c = rand(1,4);
			$deck->cards()->attach($card->id, array('amount'=>$c, 'maindeck'=>($nc<60 ? true : false)));
			$nc += $c;
		}
	}
}
<?php

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		print 'Running the MTG Seeder\n';
		Eloquent::unguard();
		$jsonFile = public_path().'\AllSetsArray.json';
		// Let's go through the json file and create sets/cards 
		$json = file_get_contents($jsonFile);
		$jsonIterator = new RecursiveIteratorIterator(
			new RecursiveArrayIterator(json_decode($json, true)),
			RecursiveIteratorIterator::SELF_FIRST);

		foreach ($jsonIterator as $key) {
			if (is_array($key)) {
				if (isset($key['name'])) { // If there's a sub-array 'cards', we're in a set 
					if (isset($key['cards'])) { // We have a set 
						$set = Set::create(array(
							'name' => $key['name'],
							'short' => $key['code']
						));
						echo "Inserting: " . $key['name'] . "\n";
						
						// Handle the cards 
						foreach($key['cards'] as $card) {
							if (isset($card['names'])) { // Double-sided or dual cards 
								$name = implode(' // ', $card['names']);
							} else { $name = $card['name']; }

							$colors = (isset($card['colors']) ? implode('|',$card['colors']) : null);
							$mana = (isset($card['manaCost']) ? $card['manaCost'] : null);
							$cmc = (isset($card['cmc']) ? $card['cmc'] : null);
							$supertypes = (isset($card['supertypes']) ? implode('|', $card['supertypes']) : null);
							$types = (isset($card['types']) ? implode('|', $card['types']) : null);
							$power = (isset($card['power']) ? $card['power'] : null);
							$toughness = (isset($card['toughness']) ? $card['toughness'] : null);
							$rarity = (isset($card['rarity']) ? $card['rarity'] : null);
							$card = Card::create(array(
								'name' => $name,
								'types' => $types,
								'supertypes' => $supertypes,
								'mana' => $mana,
								'cmc' => $cmc,
								'power' => $power,
								'toughness' => $toughness,
								'rarity' => $rarity,
								'set_id' => $set->id
							));
						}
					}
				}
			}
		}
		
		DB::table('users')->insert(array(
				'username' => 'alex',
				'password' => Hash::make('#REMOVED#')
			));
	}
}

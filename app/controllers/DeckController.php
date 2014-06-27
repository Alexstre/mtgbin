<?php

class DeckController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /decks
	 *
	 * @return Response
	 */
	public function index()
	{
		/* Let's grab some recent decks */
		$decks = Deck::take(5)->get();
		return View::make('index')->with(array(
			'decks' => $decks
		));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /decks
	 *
	 * @return Response
	 */
	public function store()
	{
		// Validation
		$rules = array(
			'slug' => 'unique:decks|alpha_dash|max:15',
			'decklist' => 'required',
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails()) {
			return Redirect::to('/')->withInput()->withErrors($validation);
		}

		/* Let's work some magic */
		$deck = new Deck;

		if (Input::get('slug') != null) $slug = Input::get('slug');
		else $slug = $deck->generateSlug();

		/* If we forked another deck to create this one, let's fill that field */
		if (Input::get('forked')) $deck->forked = Input::get('forked');

		/* By default, decks expire after 3 days so let's add that */
		$expires = new DateTime();
		$expires->add(new DateInterval('P3D'));
		$deck->deletes_on = $expires;

		$deck->slug = $slug;
		$deck->save();

		/* Time to go through the deck list and add the cards */
		$maindeck = true; /* We'll add 60 cards to the maindeck */
		$cardsSoFar = 0;
		$cards = array();

		foreach(explode("\n", Input::get('decklist')) as $line) {
			// Skip some common lines from copy/pasting
			if (substr($line, 0, 1) == '//') continue;
    		if (preg_match('/\b(sideboard|creatures|enchantment|sorcery|lands|planeswalker|spells|maybeboard)\b/', $line)) continue;

    		// Split the line in card = [int, string]
    		$card = preg_split('/(?<=\dx|\d) (?=[a-z])|(?<=[a-z])(?=\d)/i', $line);
    		if (isset($card[1])) { // This line isn't properly set

				// Clean the name up a bit, support for utf is weird
				$cardName = trim($card[1], "\r");
				$cardName = str_replace('AE', 'Æ', $cardName);

	            // If the line is <int> <some card> we'll use the amount if not we'll consider it a singleton
	            $cardCount = ($card[0] ? $card[0] : 1);
	           	$cardCount = (int)str_replace('x', '', $cardCount); // removes 'x' if it's in there
	            $cardsSoFar += $cardCount;

	            // Let's see if the card exists
				$cardObj = Card::where('name', 'LIKE', "$cardName%")->take(1)->remember(5)->get();
				if ($cardObj->count() == 0) { // Couldn't find the card abandon ship!
					$deck->delete();
					return Redirect::back()->withInput()->withErrors(["Can't find " . $cardName]);
				}
				// Add the card and its count to the array for later
				array_push($cards, ['name'=>$cardName, 'count'=>$cardCount]);
			}
        }

        if (!count($cards)) return Redirect::back()->withInput()->withErrors(["Something bad happened near " . $line]);

        // Figuring out if the deck is a standard 60 main + 15 sideboard deck.
        if ($cardsSoFar == 75) { // Ok, first 60 is main, last 15 is sideboard
        	$cardsSoFar = 0;
        	foreach($cards as $card) {
        		if ($cardsSoFar >= 60) $maindeck = false;
        		$cardname = $card['name'];
        		$cardObj = Card::where('name', 'LIKE', "$cardname%")->take(1)->get();
        		array_flatten($cardObj)[0]->decks()->attach($deck->id, array('amount' => $card['count'], 'maindeck' => $maindeck));
        		$cardsSoFar += $card['count'];
        	}
        }

        // Otherwise, we have an incomplete deck or EDH, Commander...
        else {
        	foreach($cards as $card) {
        		$cardname = $card['name'];
        		$cardObj = Card::where('name', 'LIKE', "$cardname%")->take(1)->get();
        		array_flatten($cardObj)[0]->decks()->attach($deck->id, array('amount' => $card['count'], 'maindeck' => true));
        	}
        }

        /* Ok, should be good now. Redirect to the new deck */
        return Redirect::to('/' . $deck->slug);
	}

	/**
	 * Display the specified resource.
	 * GET /decks/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$deck = Deck::where('slug', '=', $slug)->firstOrFail();
		/* Is it a 75 cards deck or just a list? or EDH deck? */
		$regular = ($deck->cardCount() == 75 ? true : false);

		/* Find some forks of this deck */
		$allforked = Deck::where('forked', '=', $slug)->get();
		if (!$allforked->count()) $allforked = null;
		return View::make('decks.show')->with(array(
			'deck' => $deck,
			'regular' => $regular,
			'allforked' => $allforked
		));

	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /{id}/fork
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function fork($slug)
	{
		$deck = Deck::where('slug', '=', $slug)->firstOrFail();
		/* we'll want to return a decklist as a string to add it to the textarea */
		$decklist = "";
		foreach ($deck->cards as $card) {
			$decklist .= $card->pivot->amount . ' ' . $card->name . '&#13;&#10;';
		}
		$decklist = substr($decklist, 0, strlen($decklist)-10);
		return View::make('index')->with(array(
			'forked' => $slug,
			'deck' => $decklist
		));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /decks/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($slug)
	{
		// Find the deck and add a few hours to its deletion date
		$deck = Deck::where('slug', '=', $slug)->firstOrFail();

		// Ok let's 
		$expires = new DateTime($deck->deletes_on);
		$expires->add(new DateInterval('PT12H'));
		$deck->deletes_on = $expires;
		$deck->save();
		return $expires->format('l, F d');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /decks/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
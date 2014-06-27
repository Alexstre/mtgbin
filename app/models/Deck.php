<?php

class Deck extends \Eloquent {
	protected $fillable = [];

    public function cards() {
        return $this->belongsToMany('Card', 'card_deck', 'deck_id', 'card_id')
            ->withPivot('amount', 'maindeck')->orderBy('pivot_maindeck', 'desc');
    }

    public function generateSlug() {
    	$alphabet = array_merge(range('a','z'), range('A','Z'), range(0,9));
    	$len = count($alphabet) - 1;
    	$sl = '';
    	for ($i=0; $i<4; $i++) {
    		$sl .= $alphabet[mt_rand(0,$len)];
    	}
    	/* Check to make sure it's unique */
    	if (Deck::where('slug', '=', $sl)->count() > 0) {
    		return generateSlug();
    	}
    	return $sl;
    }

    public function cardcount() {
		$count = 0;
		foreach($this->cards->toArray() as $card) {
			$count += $card['pivot']['amount'];
		}
		return $count;
    }
}
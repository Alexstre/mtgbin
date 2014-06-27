<?php

class Card extends \Eloquent {
	protected $fillable = [];
	public $timestamps = false;

	public function sets() {
		return $this->belongsTo('Set');
	}

    public function decks() {
        return $this->belongsToMany('Deck', 'card_deck', 'card_id', 'deck_id')
            ->withPivot('amount', 'maindeck')
                ->orderBy('pivot_maindeck', 'desc');
    }

    public function grabImage() {

        $encoded = "http://mtgimage.com/card/" . rawurlencode(str_replace(" // ", "_", $this->name)) . ".jpg";
        // a bit of a hack, we'll check on mtgimage if the image exists
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$encoded);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(curl_exec($ch)==FALSE)
            return "http://mtgimage.com/card/" . rawurlencode(explode(" // ", $this->name)[0]) . ".jpg";
        return $encoded;
    }
}
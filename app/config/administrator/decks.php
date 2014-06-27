<?php

return array(
	'title' => 'Decks',
	'single' => 'deck',

	'model' => 'Deck',

	'columns' => array(
		'id',
		'slug' => array(
			'output' => '<a href="/(:value)" target="_blank">(:value)</a>',
		),
		'deletes_on',
		'created_at'
	),

	'edit_fields' => array(
		'slug' => array('title' => 'Slug', 'type' => 'text'),
		'deletes_on' => array('title' => 'Deletes On', 'type' => 'datetime'),
	),

	'sort' => array(
		'field' => 'created_at',
		'direction' => 'desc'),

);
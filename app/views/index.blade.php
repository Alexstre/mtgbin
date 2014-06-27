@extends('layouts.default')
@section('title')
Welcome
@stop

@section('content')
<?php if (!isset($deck)) $deck = ''; ?>
<div class="jumbotron">
{{ Form::open(array('action' => 'DeckController@store', 'class'=>'form-horizontal')) }}
    <fieldset>
	    <div class="form-group">
	        <div class="col-lg-6">
    	    	{{ Form::text('slug', Input::old('slug'), array('id'=>'slug','class'=>'form-control input-md', 'placeholder'=>'name (optional)')) }}
        	</div>
        	<div class="col-lg-6">
        		<p>http://mtgb.in/<code id="preview">name</code></p>
        	</div>        	
    	</div>
    	<p class="alert-danger">{{ $errors->first() }}</p>
		<div class="form-group">
			<div class="col-lg-12">
				{{ Form::textarea('decklist', $deck, array('class'=>'form-control', 'rows'=>15, 'id'=>'decklist', 'placeholder'=>'Deck goes here')) }}
                <small>One card per line. Sideboard starts automatically after 60 cards if 75 cards total are entered. More information
                    on format available on the <a href="{{ URL::to('about') }}">about page</a>.</small>
            </div>
        </div>
    
        <div class="form-group">
        	<label class="col-lg-12 control-label" for="submit"></label>
            <div class="col-lg-12">
            	{{ Form::submit('Submit Deck', array('id'=>'submit', 'class'=>'btn btn-primary')) }}
            </div>
        </div>
        @if (isset($forked))
        	{{ Form::text('forked', $forked, array('class'=>'hidden')) }}
        @endif
    </fieldset>
{{ Form::token() . Form::close() }}
</div>
@stop

@section('bottom')
<script type="text/javascript">
$(document).ready(function() {
	$("input#slug").on('keyup change', function () {
		$(this).val($(this).val().split(' ').join('-'));
		if ($(this).val().length > 15) { $(this).val($(this).val().substr(0,15)); }
		else $("code#preview").text($(this).val());
		if ($(this).val().length === 0) $("code#preview").text("name");
	});	
});
</script>
@stop
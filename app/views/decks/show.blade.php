@extends('layouts.default')
@section('title')
{{ $deck->slug }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-6">
		<a href="{{ url('/'.$deck->slug.'/fork') }}"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-wrench"></span> Fork</button></a>
		<button type="button" class="btn btn-info" id="bump"><span class="glyphicon glyphicon-chevron-up"></span> Bump</button>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<h3>Main</h3>
		<div class="response-table">
			<table class="table table-condensed" id="main">
				<thead>
					<tr>
						<th>#</th>
						<th>Card</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($deck->cards as $card)
						@if ($card->pivot->maindeck)
						<tr>
							<td>{{ $card->pivot->amount }}</td>
							<td><a href="#" data-thumbnail="{{ $card->grabImage() }}">{{ $card->name }}</a></td>
						</tr>
						@endif
					@endforeach				
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-lg-6">
		@if ($regular)
			<h3>Sideboard</h3>
			<div class="response-table">
				<table class="table table-condensed" id="side">
					<thead>
						<tr>
							<th>#</th>
							<th>Card</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($deck->cards as $card)
						@if (!$card->pivot->maindeck)
						<tr>
							<td>{{ $card->pivot->amount }}</td>
							<td><a href="#" data-thumbnail="{{ $card->grabImage() }}">{{ $card->name }}</a></td>
						</tr>
						@endif
						@endforeach				
					</tbody>
				</table>
			</div>
		@endif
		<img src="" id="preview" class="img-responsive" alt="" />
		<h4>Information about this list</h4>
		<ul>
		@if ($deck->forked)
			<li>This was forked from <a href="{{ URL::to($deck->forked)}} ">{{ $deck->forked }}</a></li>
		@endif
		<li>It will expire around <em><span id="expires">{{ date('l, F d', strtotime($deck->deletes_on)) }}</span></em></li>
		@if ($allforked)
			<li>Forks of this list: 
				@foreach ($allforked as $df)
					<a href="{{ URL::to($df->slug)}} ">{{ $df->slug }}</a>
				@endforeach</li>
		@endif
		</ul>
	</div>
</div>
@stop

@section('bottom')
<script type="text/javascript">
$(document).ready(function () {
	var $preview = $("#preview");

	/* load the first image to fix the layout */
	$preview.attr("src", $("#main td a").first().attr("data-thumbnail"));

	/* handle the clicks for new images */
	$("td a").click(function () {
		$preview.attr("src", $(this).attr("data-thumbnail"));
	});

	/* Bump button */
	$('button#bump').click(function(e) {
		$.ajax({
			type: "PUT",
		}).done(function(data) {
			$('#expires').text(data);
			$('button#bump').attr('disabled', true);
		});
	});
});
</script>
@stop
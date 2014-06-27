<!doctype html>
<html>
<head>
	@include('includes.header')
</head>

<body>
<div class="container">
	@include('includes.navigation')

	@yield('content')


	@include('includes.footer')

</div> <!-- end of container -->
<!-- Latest compiled and minified JavaScript -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
@yield('bottom') <!-- for custom javascript on each page -->
</body>
</html>
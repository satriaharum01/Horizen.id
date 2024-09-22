<!DOCTYPE html>
<html>
<head>
	<title>Login | {{env('APP_NAME')}}</title>
 	<link rel="shortcut icon" href="{{ asset('assets/img/logo.png')}}" type="image/gif" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/logins/css/style.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<style>
		body{
			background-size:cover;
			background-image: url('<?= asset('assets/logins/img/landing.jpeg') ?>');
		}
	</style>
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<div class="container">
        @yield('content')
		<h2><center><br>{{env('APP_DETAIL')}}</center></h2>
    </div>

    <script type="text/javascript" src="assets/logins/s/main.js"></script>
</body>
</html>

    
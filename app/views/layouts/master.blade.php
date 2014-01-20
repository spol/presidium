<!DOCTYPE html>
<html lang="en">
    <head>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Presidium</title>

	<!-- Bootstrap core CSS -->
	<link href="/assets/css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	    <script src="/assets/js/html5shiv.js"></script>
	    <script src="/assets/js/respond/respond.min.js"></script>
	<![endif]-->

	<!-- Favicons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72"   href="/assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed"                 href="/assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon"                                href="/assets/ico/favicon.png">

	<script type="text/javascript">
	    var _gaq = _gaq || [];
	    _gaq.push(['_setAccount', 'UA-XXXXXX-XX']);
	    _gaq.push(['_trackPageview']);
	    (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	    })();
	</script>

    <!-- Place anything custom after this. -->
    </head>
    <body>

    <!-- Page content of course! -->


<!-- Static navbar -->
	<div class="navbar navbar-static-top">
	    <div class="container">
		<a class="navbar-brand" href="{{ URL::route('home') }}">Presidium</a>
		<div class="nav-collapse collapse">
		    <ul class="nav pull-right">
			<li><a href="{{ URL::route('logout') }}">logout</a></li>
			<li><a href="{{ URL::route('settings') }}"><span class="glyphicon glyphicon-user"></span> @spol</a></li>
		    </ul>
		</div><!--/.nav-collapse -->
	    </div>
	</div>

	<div class="container">
	    @yield('main')
	</div> <!-- /container -->

    </body>
</html>
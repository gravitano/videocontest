<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	@yield('meta')
	<title>{{ Config::get('Videocontest::app.title') }}</title>
	
	{{ HTML::style('packages/pingpong/videocontest/assets/css/bootstrap.css') }}
	{{ HTML::style('packages/pingpong/videocontest/assets/css/bootstrap-responsive.css') }}
	{{ HTML::style('packages/pingpong/videocontest/assets/css/app.css') }}

	{{ HTML::script('packages/pingpong/videocontest/assets/js/jquery.js') }}
	{{ HTML::script('packages/pingpong/videocontest/assets/js/jquery.oembed.js') }}
	{{ HTML::script('packages/pingpong/videocontest/assets/js/bootstrap.js') }}
	{{ HTML::script('packages/pingpong/videocontest/assets/js/app.js') }}

</head>
<body>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '169275909948315',                        // App ID from the app dashboard
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(){
     // If we've already installed the SDK, we're done
     if (document.getElementById('facebook-jssdk')) {return;}

     // Get the first script element, which we'll use to find the parent node
     var firstScriptElement = document.getElementsByTagName('script')[0];

     // Create a new script element and set its id
     var facebookJS = document.createElement('script'); 
     facebookJS.id = 'facebook-jssdk';

     // Set the new script's source to the source of the Facebook JS SDK
     facebookJS.src = '//connect.facebook.net/en_US/all.js';

     // Insert the Facebook JS SDK into the DOM
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());
</script>

<div class="container">

@if(Videocontest::isEventActive())
	<ul class="nav nav-pills">
		<li><a href="{{ url() }}">Home</a></li>
		<li><a href="{{ url('gallery') }}">Gallery</a></li>
		<li><a href="{{ url('leaderboard') }}">Leaderboard</a></li>
		<li><a href="{{ url('terms-and-condition') }}">Terms And Condition</a></li>
		<li><a href="{{ url('prize') }}">Prize</a></li>

		@if(Videocontest::hasUser())
		<li><a href="{{ url('upload') }}">Submit Video</a></li>
		<li><a href="{{ url('logout') }}">Logout</a></li>
		@else
		<li><a href="{{ url('twitter/redirect') }}">Login</a></li>
		@endif
	</ul>
@endif

@if(Session::has('message-notice'))
	<div class="alert alert-warning">
		<i class="icon-info-sign"></i>
		{{ Session::get('message-notice') }}
	</div>
@elseif(Session::has('message-error'))
	<div class="alert alert-error">
		<i class="icon-info-sign"></i>
		{{ Session::get('message-error') }}
	</div>
@elseif(Session::has('message-warning'))
	<div class="alert alert-warning">
		<i class="icon-info-sign"></i>
		{{ Session::get('message-warning') }}
	</div>
@elseif(Session::has('message-info'))
	<div class="alert alert-info">
		<i class="icon-info-sign"></i>
		{{ Session::get('message-info') }}
	</div>
@elseif(Session::has('message-success'))
	<div class="alert alert-success">
		<i class="icon-info-sign"></i>
		{{ Session::get('message-success') }}
	</div>
@endif

@yield('main')

</div>

</body>
</html>
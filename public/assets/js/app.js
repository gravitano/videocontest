$(document).ready(function(){

	 $('input[type=submit]').on('click', function(){
		var form = $('body').find('form').submit();
    	$(this).attr('disabled','disabled');
    });
    
    function popupwindow(url, title, w, h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    } 
	
  //   $('.btn-facebook-share').on('click', function(){	
		// var url = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href);
		// popupwindow(url,'Share to Facebook', 400, 200);
		// return false;
  //   });
    
    /* App */
    // $('.form-vote').on('submit', function(){
    // 	var form = $(this);
    // 	var id = form.attr('data-id');
    // 	$.ajax({
    // 		url: form.attr('action'),
    // 		type: form.attr('method'),
    // 		data: form.serialize(),
    // 		success:function(result){
    // 			console.log(result);
    // 		},
    // 		error: function(){
    // 			alert('ajax error!');
    // 		}
    // 	});
    // 	return false;
    // });

    function fbLogin(callback){
        FB.login(function(response) {
            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', function(response) {
                    console.log('You are connected, ' + response.name + '.');
                });
                if (callback && typeof(callback) === "function") {  
                    callback();  
                }  
            } else {
                // alert('Action cancelled!');
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: 'email,user_likes,publish_stream'});
    }

    $('.btn-facebook-share').on('click',function(){
        var url = $(this).attr('data-video-url');
        var caption = $(this).attr('data-video-caption');
        var desc = $(this).attr('data-video-desc');
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;

                /* Share to Facebook */
                FB.ui({
                    method: 'feed',
                    link: url,
                    caption: caption,
                }, function(response){
                    console.log(response);
                });
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app
                fbLogin();
            } else {
             // the user isn't logged in to Facebook.
             fbLogin();
            }
        });
        return false;
    });

});
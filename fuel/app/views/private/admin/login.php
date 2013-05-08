<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Login</title>
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/assets/css/style.default.css" type="text/css" />
	<link rel="stylesheet" href="/assets/css/style.beheer.css" type="text/css" />
	<script type="text/javascript" src="/assets/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery-ui-1.9.2.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.flot.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/assets/js/custom.js"></script>
	<script type="text/javascript" src="/assets/js/beheer.js"></script>
	<script type="text/javascript" src="/assets/js/cropUploader.js"></script>
	<script type='text/javascript' src="/assets/jwplayer/jwplayer.js"></script>
	<script type='text/javascript' src="/assets/js/jquery.columnview.js"></script>

	<script type="text/javascript" src="/assets/js/jquery.Jcrop.js"></script>
	<link rel="stylesheet" href="/assets/css/jquery.Jcrop.css" type="text/css" />
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
</head>

<body class="loginbody">

<div class="loginwrapper">
	<div class="loginwrap zindex100 animate2 bounceInDown">
		<h1 class="logintitle">Log in</h1>
		<div class="loginwrapperinner">
			<form id="loginform" action="/beheer/login" method="post">
				<p class="animate4 bounceIn"><input type="text" id="username" name="username" placeholder="Username" /></p>
				<p class="animate5 bounceIn"><input type="password" id="password" name="password" placeholder="Password" /></p>
				<p class="animate6 bounceIn"><button class="btn btn-default btn-block" style="width:100%;">Submit</button></p>
				<p class="animate7 fadeIn"><a href="#"><span class="icon-question-sign icon-white"></span> Forgot Password?</a></p>
			</form>
		</div><!--loginwrapperinner-->
	</div>
	<div class="loginshadow animate3 fadeInUp"></div>
</div><!--loginwrapper-->

<script type="text/javascript">
	jQuery.noConflict();

	jQuery(document).ready(function(){

		var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
		jQuery('.loginwrap').bind(anievent,function(){
			jQuery(this).removeClass('animate2 bounceInDown');
		});

		jQuery('#username,#password').focus(function(){
			if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
		});

		jQuery('#loginform button').click(function(){
			if(!jQuery.browser.msie) {
				if(jQuery('#username').val() == '' || jQuery('#password').val() == '') {
					if(jQuery('#username').val() == '') jQuery('#username').addClass('error'); else jQuery('#username').removeClass('error');
					if(jQuery('#password').val() == '') jQuery('#password').addClass('error'); else jQuery('#password').removeClass('error');
					jQuery('.loginwrap').addClass('animate0 wobble').bind(anievent,function(){
						jQuery(this).removeClass('animate0 wobble');
					});
				} else {
					jQuery('.loginwrapper').addClass('animate0 fadeOutUp').bind(anievent,function(){
						jQuery('#loginform').submit();
					});
				}
				return false;
			}
		});
	});
</script>
</body>
</html>
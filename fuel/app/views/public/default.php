<!doctype html>
<html lang="nl">
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title; ?></title>
	<meta name="author" content="maximumawesome.nl" />
	<meta name="viewport" content="user-scalable=0, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/style_temp.css" />
</head>
<body class="front">
<div class="colorbackground">
	<header>
		<div class="masthead">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="home"><a href="#"></a></li>
							<?php
							foreach( $menu as $item )
							{
								echo '<li><a href="'.$item->slug.'">'.$item->title.'</a></li>';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
<?php echo $content; ?>

	</div>
	<div class="footer">
		<div class="container">
			<div class="logo">
				<h4></h4>
			</div>
			<nav class="">
				<ul>
				<?php
				foreach( $submenu as $item )
				{
					echo '<li><a href="'.$item->slug.'">'.$item->title.'</a></li>';
				}
				?>

				</ul>
			</nav>
		</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>
		if( typeof $ == 'undefined' ) // Google CDN pleite?
		{
			document.write('<scr'+'ipt src="/assets/js/jquery-1.8.3.min.js"></scr'+'ipt>');
		}
	</script>
	<script type="text/javascript" src="/assets/js/app.js"></script>
	<script type='text/javascript' src="/assets/jwplayer/jwplayer.js"></script>
</body>
</html>
<!doctype html>
<html lang="nl">
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title; ?></title>
	<meta name="author" content="maximumawesome.nl" />
	<meta name="viewport" content="user-scalable=0, initial-scale=1.0">
    <?php echo Asset::css('style_temp.css'); ?>
</head>
<body class="front colorbackground">
<div class="content" data-url="<?php echo Uri::base(); ?>">
	<header>
		<div class="masthead">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="home"><a href="<?php echo Uri::base(); ?>"></a></li>
							<?php
							$current = Uri::segment(count(Uri::segments())); // last segment
							foreach( $menu as $item )
							{
								$active = '';
								if($current === $item->slug)
								{
									$active = ' id="active"';
								}
								echo '<li'.$active.'>';
								echo '<a href="'.$item->slug.'">';
								echo $item->title;
								echo '</a>';
								'</li>';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<section class="main">
		<?php echo $content; ?>

	</section>
</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>
		if( typeof $ == 'undefined' ) // Google CDN pleite?
		{
			document.write('<scr'+'ipt src="/assets/js/jquery-1.8.3.min.js"></scr'+'ipt>');
		}
	</script>

    <?php
    echo Asset::js('app.js');
    echo Asset::js('jwplayer/jwplayer.js');
    ?>
        <?php

            if(isset($script))
            {
                echo '<script>';
                echo $script;
                echo '</script>';
            }

        ?>
</body>
</html>
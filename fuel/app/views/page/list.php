<!doctype html>
<html lang="nl">
<head>
	<meta charset="utf-8" />
	<title>Steiner Maastricht</title>
	<meta name="author" content="maximumawesome.nl" />
	<meta name="viewport" content="user-scalable=0, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/style.css" />

</head>
<body>

	<div class="submenu">
		<ul>
			<li>faq</li>
			<li>events</li>
			<li>news</li>
			<li>algemene voorwaarden</li>
			<li>reparaties</li>
		</ul>
	</div>

	<nav>
		<img src="/assets/img/logo.png" alt="" />
		<ul>
			<?php
			foreach($items as $item)
			{
				echo '<li>';
				echo '<a href="/page/render/'.$item['id'].'">'.$item['title'].'</a>&nbsp;';
				echo '<a href="#" onclick="pageLoader.loadPage('.$item['id'].')">(javascript)</a>';
				echo '</li>';
			}
			?>
		</ul>
	</nav>

	<div class="content">
	</div>

	<div class="footer">
		<h4>Steiner limited</h4>
		<p>dit is de footer</p>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/app.js"></script>
</body>
</html>
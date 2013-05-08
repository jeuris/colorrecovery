<div class="contentpage container">
	<div class="row-fluid">
		<div class="span12">
			<h1>Our location</h1>
			<p>
				Fusce quis sapien quam. Proin blandit purus a turpis sagittis dapibus. Proin metus lorem, facilisis ullamcorper faucibus nec, semper non odio. Sed congue, magna vel eleifend cursus, massa libero laoreet urna, nec hendrerit tortor nisi sit amet dui. Duis semper lectus id nunc mollis blandit. Nunc scelerisque cursus velit, a congue est ornare vitae. Fusce non adipiscing turpis. Aliquam venenatis, neque et rutrum accumsan, nulla nisl iaculis nunc, in adipiscing mauris erat a elit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse eget lectus tortor, in tincidunt tellus. Aliquam faucibus nisl ut dui feugiat et feugiat eros sodales. Fusce bibendum, tellus in dictum vestibulum, lorem ipsum dictum eros, a pellentesque justo erat volutpat tellus.
			</p>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<h2>Address</h2>
			<p>
				Stokstraat 47, 6211 BQ<br/>
				Maastricht, The Netherlands.
			</p>
		</div>
		<div class="span6">
			<h2>Contact details</h2>
			<p>
				t. 043 325 59 29<br/>
				e. info@steinermaastricht.nl
			</p>
		</div>
	</div>
	<img class="map" src="/assets/img/map.jpg" alt="" />
	<div class="form">
		<script>
			$.get('templates/form.html', function(data)
			{
				$('.contentpage .form').append(data);
			});
		</script>
	</div>
</div>
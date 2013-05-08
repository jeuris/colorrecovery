<?php
	// todo : share-knoppen
	$image_src = $filelocations['thumb'] . 'placeholder.jpg';
	if( isset($item['image_id']) )
	{
		if ($item['image_id'] != -1)
		{
			$image_src = $filelocations['thumb'] . $item['image_url'];
		}
	}
?>
<div class="list-detail">
	<div class="content-holder">
		<img src="<?php echo $image_src; ?>" />
		<p data-editable="true" data-key="body"><?php echo @$json['body']; ?></p>
		<div class="line"></div>
	</div>
</div>
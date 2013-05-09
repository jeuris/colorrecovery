<div class="video container" style="height:400px;">
	<div id="mediaplayer-<?php echo $page_template->id; ?>" data-url="<?php echo @$json['url']; ?>" class="player">

	</div>

	<div class="hidden" data-editable="true" data-key="url" data-description="Video URL" style="display:none;"><?php echo $json['url']; ?>
	</div>
</div>
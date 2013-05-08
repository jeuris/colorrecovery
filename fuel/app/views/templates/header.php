<?php
	$filelocations = Config::get('app.app_config.filepath');
	
	if($json['image_id'] == -1)	{
		$image = $filelocations['full'] . 'placeholder.png';
	} else {
		$image = $filelocations['full'] . $json['image_url'];
	}
?>
<div class="" data-editable="true" data-key="image_id" style="display:none;" id="templateimage-<?php echo $page_template->id; ?>"><?php echo $json['image_id']; ?></div>
<div class="" data-editable="true" data-key="image_url" style="display:none;" id="templateimageurl-<?php echo $page_template->id; ?>"><?php echo $json['image_url']; ?></div>
<div class="header item-image" style="height:600px; background-image:url('<?php echo $image . "?t=" . time()?>')">
	<div class="container">
		<div class="title-holder">
<h1 data-editable="true" data-key="headerText"><?php echo $json['headerText']; ?></h1>
<h3 data-editable="true" data-key="subText"><?php echo $json['subText']; ?></h3>
		</div>
	</div>
</div>
<?php // SPAN5 + SPAN7, OF SPAN 12 ?>
<div class="gallery container template-itemholder">
	<?php
	$items			= (array)$json['items'];
	$filelocations	= Config::get('app.app_config.filepath');
	foreach($items as $item)
	{
		$image_src = $filelocations['thumb'] . 'placeholder.jpg';
		if( isset($item['image_id']) )
		{
			if ($item['image_id'] != -1)
			{
				$image_src = $filelocations['thumb'] . $item['image_url'];
			}
		}
		?>
		<div class="grid-item template-item" style="background-image: url(<?php echo $image_src; ?>);">
			<div data-editable="true" data-key="slug" style="display:none"><?php echo @$item['slug']; ?></div>
			<div data-editable="true" data-key="typeSlug" style="display:none"><?php echo @$item['typeSlug']; ?></div>
			<div class="" style="display:none;" data-editable="true" data-key="image_id" id="templateimage-<?php echo $page_template->id; ?>">
				<?php echo @$item['image_id']; ?>
			</div>
			<div class="" style="display:none;" data-editable="true" data-key="image_url">';
				<?php echo @$item['image_url']; ?>
			</div>
			<div class="gridcaption">
				<h3 data-editable="true" data-key="title"><?php echo @$item['title']; ?></h3>
				<?php if($item['slug']): ?>
					<div class="rect-btn">
						<div class="arrow">

						</div>
						<h4>lees meer</h4>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php } // end foreach ?>
</div>
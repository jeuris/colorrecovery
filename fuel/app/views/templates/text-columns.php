<div class="text-columns-view container">
	<?php
	if( isset($json['header-label']) )
	{
		if( strlen($json['header-label']) > 0 )
		{
			echo '<div class="header-label">';
			echo '<h1>'.str_replace(' ', '<br/>', @$json['header-label']).'<br/></h1>';
			echo '</div>';
		}
	}
	?>
	<div class="template-itemholder">
		<?php
		foreach( $json['items'] as $item )
		{
		?>
			<div class="span3 template-item">
				<div class="text" data-editable="true" data-key="text"><?php echo @$item['text']; ?></div>
				<div data-editable="true" data-key="slug" style="display:none"><?php echo @$item['slug']; ?></div>
				<div data-editable="true" data-key="typeSlug" style="display:none"><?php echo @$item['typeSlug']; ?></div>
			</div>
		<?php
		}
		?>
	</div>
</div>
<div class="text-columns-view container">
	<ul class="template-itemholder">
		<?php
		foreach( $json['items'] as $item )
		{
		?>
			<li class="span6 template-item">
				<div data-editable="true" data-key="slug" style="display:none"><?php echo @$item['slug']; ?></div>
				<div data-editable="true" data-key="typeSlug" style="display:none"><?php echo @$item['typeSlug']; ?></div>
				<h3 data-editable="true" data-key="header"><?php echo @$item['header']; ?></h3>
				<p data-editable="true" data-key="text"><?php echo @$item['text']; ?></p>
				<div class="rect-btn">
					<div class="arrow"> </div>
				</div>
				<div class="line"> </div>
			</li>
		<?php
		}
		?>
	</ul>
</div>
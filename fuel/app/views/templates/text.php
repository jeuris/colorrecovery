<div data-editable="true" data-key="slug" style="display:none;"><?php echo @$json['slug']; ?></div>
<div data-editable="true" data-key="typeSlug" style="display:none;"><?php echo @$json['typeSlug']; ?></div>
<div class="text-view container">
  	<h3 data-editable="true" data-key="header"><?php echo $json['header']; ?></h3>
  	<p data-editable="true" data-key="text"><?php echo $json['text']; ?></p>
	<?php if($json['slug']) : ?>
    <div class="rect-btn">
    	<div class="arrow">

    	</div>
    	<h4>lees meer</h4>
	</div>
	<?php endif; ?>
</div>
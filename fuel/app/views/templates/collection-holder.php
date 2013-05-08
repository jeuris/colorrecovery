<?php
	$filelocations = Config::get('app.app_config.filepath');
?>

<div class="product-holder container">
	<ul class="template-itemholder">
		<?php
		foreach($json['items'] as $k=>$item)
		{
			if($item['image_id'] == -1)
			{
				$image = $filelocations['full'] . 'placeholder.png';
			} else {
				$image = $filelocations['full'] . $item['image_url'];
			}
			
			echo '<li class="template-item">';
			echo '<div class="caption item-image" style="background-image:url('.$image.')">';

echo '<div data-editable="true" data-key="image_id" style="display:none;" id="templateimage-'.$page_template->id.'">'.$item['image_id'].'</div>';
echo '<div data-editable="true" data-key="image_url" style="display:none;" id="templateimage-'.$page_template->id.'">'.$item['image_url'].'</div>';
echo '<div data-editable="true" data-key="id" style="display:none">'.$item['id'].'</div>';
echo '<div data-editable="true" data-key="slug" style="display:none">'.$item['slug'].'</div>';

echo '<h4 data-editable="true" data-key="title">'.$item['title'].'</h4>';
echo '<p data-editable="true" data-key="text">'.$item['text'].'</p>';
			echo '<div class="rect-btn">';
			echo '<h4>lees meer</h4>';
			echo '</div>';
			echo '</div>';
			echo '</li>';
		}
		?>
	</ul>
</div>
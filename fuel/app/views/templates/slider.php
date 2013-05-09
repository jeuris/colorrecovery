<div class="hidden" data-editable="select" data-select="all|1" data-value="<?php echo @$json['pagination']; ?>" data-key="pagination" data-description="Items per pagina" style="display:none;"></div>
<div class="slider container template-itemholder paginate" data-pagesize="<?php echo @$json['pagination']; ?>">
	<?php
	$items			= (array)$json['items'];
	$filelocations	= Config::get('app.app_config.filepath');

	foreach($items as $n=>$item)
	{
		echo '<div class="row-fluid list-row template-item">';
		
		if( isset($item['image_id']) )
		{
			if($item['image_id'] == -1)
			{
				$image_src = $filelocations['thumb'] . 'placeholder.jpg';
			} 
			else 
			{
				$image_src = $filelocations['thumb'] . @$item['image_url'];
			}

			echo '<div class="span4">';
			echo '<img class="item-image" src="'.$image_src.'" alt="" />';
			echo '<div class="" style="display:none;" data-editable="true" data-key="image_id" id="templateimage-'.$page_template->id.'">'.@$item['image_id'].'</div>';
			echo '<div class="" style="display:none;" data-editable="true" data-key="image_url">'.@$item['image_url'].'</div>';
			echo '</div>';
			
			echo '<div class="span8">';
		}
		else
		{
			echo '<div class="span12">';
		}
		
		echo '<div data-editable="true" data-key="slug" style="display:none">' . @$item["slug"] . '</div>';
  		echo '<div data-editable="true" data-key="typeSlug" style="display:none">' . @$item["typeSlug"] . '</div>';

		echo '<h1 class="slider" data-editable="true" data-key="title">'.@$item['title'].'</h1>';
		echo '<h3 class="slider" data-editable="true" data-key="body">'. @$item['body'] .'</h3>';

		$link = '';
		if(strlen(@$item['slug'])>0)
		{
			switch( @$item['typeSlug'] )
			{
				case 'external' :
					$link = $item['slug'];
				break;

				default :
					$link = '/page/view/'.$item['slug'];
			}
			echo '<i class="icon icon-eye-open"> </i> <a class="readmore internal" href="'.$link.'">Read more</a>';
		}
		echo '</div>'; // span8/span12

		if(strlen($link) > 0)
		{
			echo '<a class="list-button" href="'.$link.'">';
			echo '<i class="arrow"> </i>';
			echo '</a>';
		}
		echo '</div>'; // list-row
	}
	?>
</div>
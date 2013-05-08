<div class="hidden" data-editable="select" data-select="statisch|facebook|twitter" data-value="<?php echo @$json['source']; ?>" data-key="source" data-description="Nieuwsbron" style="display:none;"></div>
<div class="hidden" data-editable="select" data-select="all|3|6|9" data-value="<?php echo @$json['pagination']; ?>" data-key="pagination" data-description="Items per pagina" style="display:none;"></div>
<div class="listview container template-itemholder paginate" data-pagesize="<?php echo @$json['pagination']; ?>">
	<?php
	$filelocations	= Config::get('app.app_config.filepath');
	switch( $json['source'] )
	{
		case 'facebook' :
			$items = json_decode( Request::forge('public/news/facebook')->execute(), true );
		break;

		case 'twitter' :
			// todo: twitter integration
			$items = array();
			break;

		default :
			$items = (array)@$json['items'];
	}

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
			if($item['image_id'] == 'fb')
			{
				$image_src = $item['image_url'];
			}

			echo '<div class="span3">';
			echo '<img class="item-image" src="'.$image_src.'" alt="" />';
			echo '</div>';

			echo '<div class="span9">';
		}
		else
		{
			echo '<div class="span12">';
		}
		echo '<div data-editable="true" data-key="slug" style="display:none">' . @$item["slug"] . '</div>';
		echo '<div data-editable="true" data-key="typeSlug" style="display:none">' . @$item["typeSlug"] . '</div>';
		echo '<div class="" style="display:none;" data-editable="true" data-key="image_id" id="templateimage-'.$page_template->id.'">';
		echo @$item['image_id'];
		echo '</div>';
		echo '<div class="" style="display:none;" data-editable="true" data-key="image_url">';
		echo @$item['image_url'];
		echo '</div>';

		echo '<h3 data-editable="true" data-key="title">'.@$item['title'].'</h3>';
		echo '<p data-editable="true" data-key="body">'. @$item['body'] .'</p>';
		$link = '';
		if(strlen(@$item['slug'])>0 && strlen(@$item['typeSlug'])>0) // todo: naar een helper class (Helper::generate_link($type,$link);
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

		if(strlen($link)>0)
		{
			echo '<a class="list-button" href="'.$link.'">';
			echo '<i class="arrow"> </i>';
			echo '</a>';
		}

		echo '</div>'; // list-row
	}
	?>
</div>
<div class="listview container template-itemholder">
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

	echo '<hr />';

	$items			= (array)$json['items'];
	$filelocations	= Config::get('app.app_config.filepath');

	foreach($items as $n=>$item)
	{
		echo '<div class="row-fluid list-row template-item">';
		echo '<div class="absoluteCenterWrapper">';

		echo '<div data-editable="true" data-key="slug" style="display:none">' . @$item["slug"] . '</div>';
  		echo '<div data-editable="true" data-key="typeSlug" style="display:none">' . @$item["typeSlug"] . '</div>';
		echo '<img src="/assets/images/CR_iconholder.svg" />';
		echo '<p data-editable="true" data-key="body">'. @$item['body'] .'</p>';

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
		echo '</div>'; // span12
		echo '<hr />';

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
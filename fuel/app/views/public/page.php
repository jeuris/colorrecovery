<?php
	$i = 0;
	$template_cfg = Config::get('app.app_config.templates');

	foreach($page_templates as $part)
	{
		$template_id = array_keys($part);
		$template_id = array_shift($template_id);

		if( $template_cfg[$template_id]['has_header'] == true )
		{
			$part_number = $i + 1;
			$part_number < 10 ? $part_number = '0'.$part_number : $part_number;

			$updated = strtotime($part['updated']);
			$date = date('F', $updated).' ';
			$date.= Inflector::ordinalize( (int)date('j', $updated) ).' ';
			$date.= date('Y', $updated);

			echo "\n\t\t";
			echo '<div class="header-text">';
			echo "\n\t\t\t";
			echo '<div class="title-holder container">';
			echo '<div class="content-holder">';
			echo '<h1>'.@$part['data']['header-head'].'</h1>';

			if( isset($part['data']['header-label']) )
			{
				if( strlen($part['data']['header-label']) > 0 )
				{
					echo '<div class="header-label">';
					echo '<h5>'.@$part['data']['header-label'].'</h5>';
					echo '</div>';
				}
			}

			echo '<p class="details">last update <strong>'.$date.'</strong></p>';
			echo '</div>';
			echo '</div>';

			echo '<div class="indicator"><h1>'.$part_number.'</h1></div>';
			echo "\n\t\t";
			echo '</div>';
			echo "\n";
			$i++;
		}
		echo "\t\t";
		echo '<div class="'.$template_id.' striped">';
		echo "\n\t\t\t";
		echo $part[$template_id];
		echo "\n\t\t";
		echo '</div>';
	}
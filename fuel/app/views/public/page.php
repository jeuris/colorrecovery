<?php
	$i = 0;
	$template_cfg = Config::get('app.app_config.templates');

	foreach($page_templates as $part)
	{
		$template_id = array_keys($part);
		$template_id = array_shift($template_id);

		if( $template_cfg[$template_id]['has_header'] == true )
		{
			$updated = strtotime($part['updated']);
			$date = date('F', $updated).' ';
			$date.= Inflector::ordinalize( (int)date('j', $updated) ).' ';
			$date.= date('Y', $updated);

			echo "\n\t\t";
			echo '<div class="text-side">';
			echo "\n\t\t\t";
			echo '<h1>'.@$part['data']['header-head'].'</h1>';
			echo "\n\t\t";
			echo '</div>';
			echo "\n";
			$i++;
		}
		echo "\t\t";
		echo '<div class="'.$template_id.'">';
		echo "\n\t\t\t";
		echo $part[$template_id];
		echo "\n\t\t";
		echo '</div>';
	}


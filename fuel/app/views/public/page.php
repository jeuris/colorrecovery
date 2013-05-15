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

            $headerhead = \Arr::get($part, 'data.header-head');

			if(!empty($headerhead))
			{
                echo '
                <div class="text-side">
                    <h1>WE<br />WANT<br /><span class="red">CLEAN</span><br />COLORS!</h1>
                    <img style="width:150px" src="'.Uri::base().'assets/images/CR_fp_logo.png" />
                </div>';
			}
			$i++;
		}

        echo '
            <div class="'.$template_id.'">
            ' . $part[$template_id] . '
            </div>';
	}


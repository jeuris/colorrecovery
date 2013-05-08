<div class="btn-group" data-templateid="<?php echo $t->id; ?>">
	<?php
	$state_icon = ($t->published ? 'icon-eye-open' : 'icon-eye-close');

	if( $all_templates[$t->template_id]['has_header'] )
	{
		echo '<div class="textheader-edit">';
		echo '<input type="text" name="header-head" value="'.@$json['header-head'].'" />';
		echo '<input type="text" name="header-label" value="'.@$json['header-label'].'" />';
		echo '</div>';
	}
	?>
	<a class="btn savebtn">
		<i class="icon-ok"></i>
	</a>
	<a class="btn publishbtn">
		<i class="<?php echo $state_icon; ?>"></i>
	</a>
	<a class="btn deletebtn">
		<i class="icon-trash"></i>
	</a>
</div>
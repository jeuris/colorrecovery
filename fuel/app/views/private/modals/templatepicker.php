<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h2>Kies een template</h2>
</div>
<div class="modal-body">
<?php
foreach( $all_templates as $key=>$t )
{
	echo '<li>';
	echo '<a data-page="'.$page_id.'" data-template="'.$key.'" href="javascript:void(0)" onclick="PageEditor.addTemplate(this)">'.$t['title'].'</a>';
	echo '</li>';
}
?>
</div>
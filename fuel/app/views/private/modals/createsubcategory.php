<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h2>Nieuwe subcategorie aanmaken</h2>
</div>
<div class="modal-body">
	<form name="create_category" action="<?php echo Uri::base() . 'private/subcategory/add/' . $item_id; ?>"  method="post">
		<p><input type="text" name="title" placeholder="Titel" /></p>
		<p><input type="submit" value="toevoegen" /></p>
	</form>
</div>

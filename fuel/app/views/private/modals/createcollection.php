<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h2>Nieuwe collectie aanmaken</h2>
</div>
<div class="modal-body">
<form name="create_category" action="<?php echo Uri::base() . 'private/collection/add/' . $item_id; ?>"  method="post">
	<input type="text" name="title" placeholder="Titel" />
	<br/>
	<input type="submit" value="toevoegen" />
</form>
</div>

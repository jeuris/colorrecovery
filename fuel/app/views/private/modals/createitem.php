<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h2>Nieuw item aanmaken</h2>
</div>
<div class="modal-body">
	<form name="create_category" action="<?php echo Uri::base() . 'private/item/add/' . $maincollection_id . '/' . $subcollection_id; ?>"  method="post">
		<input type="text" name="title" placeholder="Titel" />
		<br/>
		<input type="submit" value="toevoegen" />
	</form>
</div>
<div class="edit row-fluid">
	<div class="span6">
		<form class="editcollection">
			<input type="hidden" id="page_id" name="page_id" value="<?php echo $pagesubject->page->id ?>" />
			<input class="input-xxlarge" type="text" name="title" placeholder="Titel" value="<?php echo $pagesubject->title;?>" />
		</form>
		<p class="stdformbutton">
			<a class="btn btn-primary" onclick="PageManager.editCollection(<?php echo $pagesubject->id;?>)">Opslaan</a>
			<?php
			$pagetype = $pagesubject->page->get_pagetype();
			if( $pagetype['type'] != 'category' )
			{
				echo '<a class="btn btn-danger" data-collection="'.$pagesubject->id.'" onclick="PageManager.deletePage('.$pagesubject->page->id .'">Verwijderen</a>';

			}
			?>
		</p>
	</div>
	<div class="span6">
		<?php
			$state_icon = ($pagesubject->page->published ? 'icon-eye-open' : 'icon-eye-close');
		?>
		<a target="_blank" href="/beheer/page/preview/<?php echo $pagesubject->slug;?>" class="btn pull-right" style="padding:20px 28px;" title="Preview"><i class="icon-search"></i></a>
		<a href="javascript:void(0)" onclick="PageEditor.publishPage(<?php echo $pagesubject->page->id; ?>)" class="btn pull-right publishpage" style="padding:20px 28px;"><i class="<?php echo $state_icon; ?>"></i></a>
	</div>
</div>
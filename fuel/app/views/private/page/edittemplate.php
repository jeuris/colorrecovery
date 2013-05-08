<h1>Template wijzigen</h1>
<form id="edittemplate" data-pagetemplate="<?php echo $pagetemplate->id; ?>">
	<input type="hidden" name="template_id" value="<?php echo $pagetemplate->id; ?>" />
	<input type="hidden" name="itemcount" class="itemcount" value="<?php echo count($json['items']); ?>" />
	
	<div class="template_items">
	<?php
	foreach($json['items'] as $n=>$item)
	{
		echo '<br/>Item '.($n+1).'<br/>';
		echo '<input type="text" name="title-'.$n.'" value="'.$item['title'].'" /> Titel<br/>';
		echo '<input type="text" name="image-'.$n.'" value="'.$item['image'].'" /> Afbeelding<br/>';
		echo '<input type="text" name="link-'. $n.'" value="'.$item['link'].'" /> Link<br/>';
	}
	?>
	</div>
	<a href="javascript:void(0)" onclick="PageManager.addItem()">Nieuw item toevoegen</a>
	<br/>
	<a href="javascript:void(0)" onclick="PageManager.saveTemplate(this)">Opslaan</a>
</form>
<br/>

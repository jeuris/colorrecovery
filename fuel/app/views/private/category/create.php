<h4 class="widgettitle nomargin shadowed">Nieuwe categorie aanmaken</h4>
<div class="widgetcontent bordered shadowed nopadding">
	<?php
	echo \Form::open(array('name' => 'create_category', 'class' => 'stdform stdform2'));
	?>
	<p>
		<label>Titel van categorie</label>
		<span class="field"><?php echo Form::input('title', '', array('name' => 'title', 'id' => 'title', 'class' => 'input-xxlarge'));?></span>
	</p>

	<p class="stdformbutton">		
		<?php echo Form::button('submit', 'save', array('class' => 'btn btn-primary')); ?>	
	</p>

	<?php
	echo \Form::close();
	?>
</div>
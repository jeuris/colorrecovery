<div class="formholder listview container">
	<?php
	if( isset($json['header-label']) )
	{
		if( strlen($json['header-label']) > 0 )
		{
			echo '<div class="header-label">';
			echo '<h1>'.@$json['header-label'].'</h1>';
			echo '</div>';
		}
	}

	echo '<hr />';
	?>
	<div class="row-fluid contact-details">
		<div class="span1">

		</div>
		<div class="span3">
			<cite data-editable="true" data-key="email">
				<?php echo @$json['email'];?>
			</cite>
		</div>
		<div class="span3">
			<cite data-editable="true" data-key="tel">
				<?php echo @$json['tel'];?>
			</cite>
		</div>
		<div class="span3">
			<cite data-editable="true" data-key="misc">
				<?php echo @$json['misc'];?>
			</cite>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="template-itemholder">
				<?php
				@$items = (array)$json['items'];
				foreach($items as $n=>$item)
				{
					echo '<div class="template-item absoluteCenterContact">';
					echo '<img src="/assets/images/CR_iconholder.svg" class="absoluteCenter"/>';
					echo '<p>';
					echo '<strong data-editable="true" data-key="title">'.@$item['title'].'</strong>';
					echo '<span data-editable="true" data-key="body">'.@$item['body'].'</span>';
					echo '</p>';
					echo '</div>';
				}
				?>
			</div>
		</div>
		<div class="span6">
			<div class="BorderContactform">
				<h2 data-editable="true" data-key="formhead">
					<?php echo @$json['formhead'];?>
				</h2>
				<form class="form-horizontal mailform">
					<div class="span12">
						<div class="control-group">
							<div style="" data-editable="true" data-key="label1" class="control-label"><?php echo @$json['label1']; ?></div>
							<div class="controls">
								<input name="input1" type="text" id="inputLabel1" placeholder="<?php echo @$json['label1']; ?>" />
							</div>
						</div>
						<div class="control-group">
							<div style="" data-editable="true" data-key="label2" class="control-label"><?php echo @$json['label2']; ?></div>
							<div class="controls">
								<input name="input2" type="text" id="inputLabel2" placeholder="<?php echo @$json['label2']; ?>" />
							</div>
						</div>
						<div class="control-group">
							<div style="" data-editable="true" data-key="label3" class="control-label"><?php echo @$json['label3']; ?></div>
							<div class="controls">
								<textarea rows="3" placeholder="<?php echo @$json['label3']; ?>">
								</textarea>
							</div>
						</div>
					</div>
					<input type="hidden" name="target" value="<?php echo strrev(str_replace('@', '---', @$json['email_to'])); ?>" />
					<small>We won&#8217;t save or share you email address and won&#8217;t send you anything you didn&#8217;t ask for. That&#8217;s a promise.</small>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="hidden" data-editable="true" data-key="email_to" data-description="Mails worden verstuurd naar: " style="display:none;"><?php echo @$json['email_to']; ?></div>
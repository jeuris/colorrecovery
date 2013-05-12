<div class="formholder container">
	<div class="row-fluid">
		<form class="form-horizontal mailform">
			<div class="span12">
				<div class="control-group">
					<div style="display:none;" data-editable="true" data-key="label1" class="control-label"><?php echo @$json['label1']; ?></div>
					<div class="controls">
						<input name="input1" type="text" id="inputLabel1" placeholder="<?php echo @$json['label1']; ?>" />
					</div>
				</div>
				<div class="control-group">
					<div style="display:none;" data-editable="true" data-key="label2" class="control-label"><?php echo @$json['label2']; ?></div>
					<div class="controls">
						<input name="input2" type="text" id="inputLabel2" placeholder="<?php echo @$json['label2']; ?>" />
					</div>
				</div>
				<div class="control-group">
					<div style="display:none;" data-editable="true" data-key="label3" class="control-label"><?php echo @$json['label3']; ?></div>
					<div class="controls">
						<textarea rows="3" placeholder="<?php echo @$json['label3']; ?>">
						</textarea>
					</div>
				</div>
			</div>
			<input type="hidden" name="target" value="<?php echo strrev(str_replace('@', '---', @$json['email_to'])); ?>" />
		</form>
	</div>
</div>
<div class="hidden" data-editable="true" data-key="email_to" data-description="Mails worden verstuurd naar: " style="display:none;"><?php echo @$json['email_to']; ?></div>
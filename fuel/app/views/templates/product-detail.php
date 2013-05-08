<?php
	$filelocations = Config::get('app.app_config.filepath');
?>
<div class="product-detail container">
	<div class="row-fluid">
		<div class="thumbnails span1">
			<p>variations</p>
			<div class="template-itemholder">
			<?php
			foreach($json['items'] as $k=>$item)
			{
				if($item['image_id'] == -1) {
					$image = $filelocations['full'] . 'product-placeholder.png';
					$thumb = $filelocations['thumb']. 'product-placeholder.png';
				} else {
					$image = $filelocations['full'] . $item['image_url'];
					$thumb = $filelocations['thumb']. $item['image_url'];
				}
				
				echo '<div style="background-image:url('.$thumb.')" class="template-item item-image product-thumb">';
				echo '<div data-editable="true" data-key="image_url" style="display:none;" id="templateimage-'.$page_template->id.'">'.$item['image_url'].'</div>';
				echo '<div data-editable="true" data-key="image_id" style="display:none;" id="templateimage-'.$page_template->id.'">'.$item['image_id'].'</div>';
				
				echo '</div>';
			}
			?>
			</div>
		</div>
		
		<div class="main-image span5">
<div data-editable="true" data-key="main_image" style="display:none;"><?php echo @$json['main_image'];?></div>
<img class="main_image" src="<?php echo $filelocations['full'].@$json['main_image']; ?>" alt="" />
		</div>
		
		<div class="detail-table span6">
			<div class="share"></div>
			
<div class="description" data-editable="true" data-key="description"><?php echo @$json['description']; ?></div>
			
			<div class="specifications">
				<h4>DETAILS</h4>
				
				<div class="row-fluid">
					<div class="span4">Case material</div>
<div class="span8" data-editable="true" data-key="case"><?php echo @$json['case']; ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4">Bracelet / strap</div>
<div class="span8" data-editable="true" data-key="strap"><?php echo @$json['strap']; ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4">Dial color</div>
<div class="span8" data-editable="true" data-key="dial"><?php echo @$json['dial']; ?></div>
				</div>
				<div class="row-fluid">
					<div class="span4">Jewels</div>
<div class="span8" data-editable="true" data-key="jewels"><?php echo @$json['jewels']; ?></div>
				</div>
				<div class="row-fluid">
<div class="span4" data-editable="true" data-key="extra"><?php echo @$json['extra']; ?></div>
<div class="span8" data-editable="true" data-key="extra_text"><?php echo @$json['extra_text']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
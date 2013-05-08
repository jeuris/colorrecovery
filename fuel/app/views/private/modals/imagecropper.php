<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h2>Bewerk afbeelding</h2>
</div>
<form enctype="multipart/form-data">
<?php
$json = array();
$json['fullWidth']        = $config['images']['full']['width'];
$json['fullHeight']       = $config['images']['full']['height'];
$json['thumbWidth']       = $config['images']['thumb']['width'];
$json['thumbHeight']      = $config['images']['thumb']['height'];
$json['selectCropWidth']  = $config['images']['full']['width'];
$json['selectCropHeight'] = $config['images']['full']['height'];

if(isset($image))
{	
	if(!isset($item_id) || $item_id == -1)
	{
		$filepath = $filelocations['temp'];
	}
	else
	{
		$filepath = $filelocations['thumb'];
	}

	$json['filepath']         = $filepath;
	$json['url'] 	          = $image->url;
	$json['template_id']      = $template_id;
	$json['item_id']	      = $item_id;
	$json['image_id']	      = $image_id;
	$action = 'CropUploader.init(json);';
}
else
{
	$json['url'] 	          = '';
	$json['template_id']      = $template_id;
	$json['item_id']	      = $item_id;
	$json['image_id']	      = $image_id;
	$action = 'CropUploader.setupUpload(json);';

	echo '<p>';
	echo '<label>File Upload</label>';
	echo '<span class="field">';
	echo '<input type="file" name="filename" class="fileuploader" />';
	echo '</span>';
	echo '</p>';
}
echo '</form>';

echo '<script type="text/javascript">';
// echo 'var json = {filepath : "' . $filepath . '", url : "' . $image->url . '", fullWidth : "' . $config['images']['full']['width'] . '", fullHeight : "' . $config['images']['full']['height'] . '", thumbWidth : "' . $config['images']['thumb']['width'] . '", thumbHeight : "' . $config['images']['thumb']['height'] . '", selectCropWidth : "' . $config['images']['full']['width'] . '", selectCropHeight : "' . $config['images']['full']['height'] . '", template_id : "' . $template_id . '", item_id : "' . $item_id . '", image_id : "' . $image_id . '"};';
echo 'var json = '.json_encode($json).';';
echo $action;
echo '</script>';
?>


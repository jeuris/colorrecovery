var CropUploader = 
{
	jcrop_api 			: null,
	x1 					: 0,
	x2					: 0,
	y1 					: 0,
	y2 					: 0,
	w 					: 0, 
	h 					: 0,
	boxWidth    		: 560,
	boxHeight   		: 500,
	url 				: '',
	imagePath			: '',
	fullWidth   		: 0,
	fullHeight  		: 0,
	thumbWidth  		: 0,
	thumbHeight 		: 0,
	selectCropWidth 	: 0,
	selectCropHeight 	: 0,
	template_id 		: 0,
	item_id 			: 0,
	image_id 			: 0,
	realImageWidth		: 0,
	realImageHeight		: 0,
	jsonConfig			: '{}',
	newImage			: false,

	init:function(obj)
	{
		var _this = this;
		this.url = obj.url;
		this.fullWidth = obj.fullWidth;
		this.fullHeight = obj.fullHeight;
		this.thumbWidth = obj.thumbWidth;
		this.thumbHeight = obj.thumbHeight;
		this.selectCropWidth = obj.selectCropWidth;
		this.selectCropHeight = obj.selectCropHeight;
		this.template_id = obj.template_id;
		this.item_id = obj.item_id;
		this.image_id = obj.image_id;
		this.imagePath = obj.filepath + obj.url;
		
		$('#modalWindow .modal-body').empty();

		var img = $("<img src='" + _this.imagePath + "' id='target'/>").on('load', function(){
			_this.realImageWidth = this.width;
			_this.realImageHeight = this.height;
		    $('#modalWindow .modal-body').append(img);
		    $('#modalWindow .modal-body').append('<div class="modal-footer"><button data-dismiss="modal" class="btn">Close</button><button class="btn btn-primary" onClick="CropUploader.editExistingImage();">Save changes</button></div>');

			var w = Math.max($('#target').width(), _this.realImageWidth);
			var h = Math.max($('#target').height(), _this.realImageHeight);
			
			var targetHeight = Math.max(_this.boxHeight, h);
			var xpos = 0;
			var ypos = 0;

			if(_this.newImage == true)
			{
				_this.selectCropWidth = (_this.boxWidth / w) * _this.fullWidth;
				_this.selectCropHeight = (_this.selectCropWidth * _this.fullHeight) / _this.fullWidth;
			}
			else
			{
				_this.selectCropWidth = _this.fullWidth;
				_this.selectCropHeight = _this.fullHeight;
			}

			jQuery(function($)
			{
				$('#target').Jcrop({
					setSelect:   [ 0, 0, _this.selectCropWidth, _this.selectCropHeight ],
					boxWidth : _this.boxWidth,
					boxHeight: _this.boxHeight,
					aspectRatio: _this.selectCropWidth / _this.selectCropHeight,
					onChange: showCoords,
					allowResize: true
				}, function()
				{
					jcrop_api = this;
				});
			});
			
			function showCoords (c)
			{
                console.log("new image issue with cropper");
				//if(_this.newImage == true)
                if(_this.newImage == false)
				{
					_this.x1 = c.x * (w / _this.boxWidth);
					_this.y1 = c.y * (w / _this.boxWidth);
					_this.x2 = c.x2 * (w / _this.boxWidth);
					_this.y2 = c.y2 * (w / _this.boxWidth);
					_this.w = c.w;
					_this.h = c.h;
				}
				else
				{
					_this.x1 = c.x;
					_this.y1 = c.y;
					_this.x2 = c.x2;
					_this.y2 = c.y2;
					_this.w = c.w;
					_this.h = c.h;	
				}
			}
			
		});
	},
	
	editExistingImage : function ()
	{
		var that = this;
		
		var data = {"x1" : this.x1, "y1" : this.y1, "x2" : this.x2, "y2" : this.y2, "fullWidth" : this.fullWidth, "fullHeight" : this.fullHeight, "thumbWidth" : this.thumbWidth, "thumbHeight" : this.thumbHeight, "url" : this.url, 'image_id' : this.image_id, 'template_id' : this.template_id, 'item_id' : this.item_id};

        console.log(data);

		$.ajax({
			type: 		'POST',
			url: 		PageManager.apiUrl+'editExistingImage',
			data: 		data,
			dataType:	'json',
			complete: function(e) 
			{

			},
			success: function(e) {
				var img_url = that.imagePath;
				var temp_id	= parseInt( that.template_id, 10);
				var item_id = parseFloat( that.item_id );
				
				if( item_id >= 0 )
				{
					// zoek het item op
					$('#template-'+temp_id+' .preview .item-image').each(function(){
						var idx = $('#template-'+temp_id+' .preview .item-image').index(this);

						if(idx == item_id)
						{
							if( this.hasAttribute('src') )
							{
								$(this).attr('src', '/files/full/'+that.url);
								$(this.parentNode).find('[data-key="image_id"]').html(that.image_id);
								$(this.parentNode).find('[data-key="image_url"]').html(that.url);
							}
							else
							{
								$(this).css('background-image', 'url('+ img_url +')');
								$(this).find('[data-key="image_id"]').html(that.image_id);
								$(this).find('[data-key="image_url"]').html(that.url);
								$(this).find('[data-key="main_image"]').html(that.url);

							}

							if( item_id == 0 && $('#template-'+temp_id).find('.main_image').length > 0 )
							{
								$('#template-'+temp_id+' .main_image').attr('src', '/files/full/'+that.url);
							}
						}
					});
				}
				else
				{
					$('#template-'+temp_id+' .preview .item-image').css('background-image', 'url('+ img_url +')');
					$('#template-'+temp_id+' .preview').find('[data-key="image_id"]').html(that.image_id);
					$('#template-'+temp_id+' .preview').find('[data-key="image_url"]').html(that.url);
					$('#template-'+temp_id+' .preview').find('[data-key="main_image"]').html(that.url);
					console.log($('#template-'+temp_id+' .preview').find('[data-key="image_id"]'));
					console.log('^--- image_id');
				}
				$('#modalWindow').modal('hide');
			},
			error: function(e) {
				
				console.log(e);
			}
		});
	},

	setupUpload : function(obj)
	{
		this.jsonConfig = obj;
		var _this = this;

		$('.fileuploader').change(function()
		{
            var image = $(this).get(0).files[0];
			_this.uploadFile(image);
		});
	},

	uploadFile : function(file)
	{
		var formdata = new FormData();
		var _this = this;
		
		if (formdata) 
		{  
		    formdata.append("image", file);  
		    formdata.append("image_id", this.jsonConfig.image_id);
		    formdata.append("template_id", this.jsonConfig.template_id);
			formdata.append("item_id", this.jsonConfig.item_id);
			formdata.append("fullWidth", this.jsonConfig.fullWidth);
			formdata.append("fullHeight", this.jsonConfig.fullHeight);
			formdata.append("thumbWidth", this.jsonConfig.thumbWidth);
			formdata.append("thumbHeight", this.jsonConfig.thumbHeight);

			$.ajax({
			url: PageManager.apiUrl+"addnewimage",
			dataType: 'json',
		  	type: 'POST',
		  	data: formdata,
		  	processData: false,
			contentType: false,
		  	success: function(data)
		  	{
		  		var img = data.images[0];
		  		var savedImage = img.saved_as;
		  		var imagePath = folderpath + 'files/temp/';
		  		var json = {filepath : imagePath ,'url' : savedImage, 'fullWidth' : _this.jsonConfig.fullWidth, 'fullHeight' : _this.jsonConfig.fullHeight, 'thumbWidth' : _this.jsonConfig.thumbWidth , 'thumbHeight' : _this.jsonConfig.thumbHeight, 'selectCropWidth' : _this.jsonConfig.fullWidth, 'selectCropHeight' : _this.jsonConfig.fullHeight, 'template_id' : _this.jsonConfig.template_id , 'item_id' : _this.jsonConfig.item_id, 'image_id' : data.image_id};
		  		var jsonString = JSON.stringify(json);
		  		
		  		_this.newImage = true;
		  		CropUploader.init(json);

		  	},
		  	error: function(error){console.log(error)}
			});  

		}
		else
		{
			alert("afbeelding kan niet worden geupload, neem contact op met MXA.");
		}
	}
}
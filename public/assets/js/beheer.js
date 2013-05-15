$('document').ready(function() {

	$('a[data-rel]').each(function() {
		$(this).attr('rel', $(this).data('rel'));
	});

	folderpath = $('.maincontent').data('folderpath');

	PageManager.init();
	PageEditor.init();

});

var PageManager = {

	apiUrl: 'http://colorrecovery.dev/beheer/api/',
	currentSlug: "",
	currentSlugType: "",

	init : function() {

        this.apiUrl = $('.main').data('url') + 'beheer/api/';

		$('#modalWindow').on('hidden', function(){
			$(this).removeData('modal');
		});		
	},
	
	loadPage : function(id) {
		$.ajax({
			type:		'GET',
			url: 		PageManager.apiUrl+'page/'+id,
			dataType:	'json',
			data: 		'',
			success: function(e) {
				$('.content').empty();
				for(var i=0; i<e.parts.length; i++)
				{
					$('.content').append(e.parts[i]);
				}
			},
			
			complete: function(e) {}
		});
	},
	
	editCollection : function(id) {
		var formdata = $('.editcollection').serialize();
		
		$.ajax({
			type: 		'POST',
			url: 		PageManager.apiUrl+'editmaincollection/'+id,
			data: 		formdata,
			dataType:	'json',
			complete: function(e) {},
			success: function(e) {
				window.location = window.location;
			},
			error: function(e) {}
		});
	},
	
	deletePage : function(id) {
		var c = confirm('Deze pagina verwijderen? ');
		if( c )
		{
			window.location = '/beheer/page/delete/'+id;
		}
		else
		{
			return false;
		}
	},

	populateModal : function()
	{

	},

	linkcreatorSetup: function(presetLink, presetType) {
		var _this = this;

		$('#linkerList').columnview({
	        onchange: function(element) 
	        {
	        	_this.currentSlugType = $(element).data('linktype');
				_this.currentSlug = $(element).data('slug');
	        }
	    });

		if(presetLink != undefined && presetType != undefined)
		{
			$('#linkerList').columnview("setOpen", presetLink, presetType);
		}
	},

	linkToExistingPage:function(page_template_id, item_id) {
		var obj 	= this.getLinkAndTypeDivs(page_template_id, item_id);
		obj.slugDiv.html(this.currentSlug);
		obj.typeDiv.html(this.currentSlugType);

		PageEditor.saveTemplate(page_template_id);
		$('#modalWindow').modal('hide');
	},

	linkToNewPage:function(page_template_id, page_name, typeslug, item_id) {
		var _this = this;

		$.ajax({
			type: 		'POST',
			url: 		PageManager.apiUrl+'createnewpage',
			data: 		{ name: page_name, pagetemplateid: page_template_id },
			dataType:	'json',
			complete: function(e) {},
			success: function(e) 
			{
				var slug 	= e.slug;
				var obj 	= _this.getLinkAndTypeDivs(page_template_id, item_id);

				obj.slugDiv.html(slug);
				obj.typeDiv.html(typeslug);
				_this.currentSlugType = typeslug;
				_this.currentSlug = slug;
				
				PageEditor.saveTemplate(page_template_id, PageManager.navigateToCreatedPage);
				$('#modalWindow').modal('hide');

				PageEditor.init();
			},
			error: function(e) {}
		});
	},

	linkToExternalPage:function(page_template_id, item_id, url) {
		if(url.indexOf('http://') < 0)
		{
			url = 'http://'+url;
		}
		var obj 	= this.getLinkAndTypeDivs(page_template_id, item_id);
		obj.slugDiv.html(url);
		obj.typeDiv.html('external');

		PageEditor.saveTemplate(page_template_id, null);
		$('#modalWindow').modal('hide');
		PageEditor.init();
	},

	getLinkAndTypeDivs: function(page_template_id, item_id) {
		var obj = {};
		$itemholder = $('#template-' + page_template_id + ' .template-itemholder [data-key="slug"]' );

		//has sub items
		if($itemholder.length > 0)
		{
			$itemholder.each(function()
			{
				if($itemholder.index(this) == item_id)
				{
					$slugDiv = $(this);
					$typeDiv = $(this).parents(".template-item").find('[data-key="typeSlug"]');
					obj.slugDiv = $slugDiv;
					obj.typeDiv = $typeDiv;
				}
			});
		}
		else
		{
			//no sub items
			obj.slugDiv =  $('#template-' + page_template_id + ' [data-key="slug"]');
			obj.typeDiv =  $('#template-' + page_template_id + ' [data-key="typeSlug"]');
		}

		return obj;
	},

	linkToPage: function() {
		
	},

	navigateToCreatedPage: function() {
		$.ajax({
			type: 		'POST',
			url: 		PageManager.apiUrl+'pagebyslugandtype',
			data: 		{ slug: PageManager.currentSlug, type: PageManager.currentSlugType},
			dataType:	'json',
			complete: function(e) {},
			success: function(e) 
			{
				window.location = '/beheer/page/edit/'+e.page
			},
			error: function(e) {}
		});
	}
};

var PageEditor = {

	ready:		false,
	page_id:	'',

	init : function(newItem) {
		var that = this;

		this.page_id = $('.page_editor').data('pageid');

		// external news, remove buttons
		$('.news.facebook, .news.twitter').each(function(){
			$(this).find('.btn').remove();
			$(this).find('.template-item').removeClass('template-item');
			$(this).children().find('[data-editable]').removeAttr('data-editable').removeAttr('contenteditable');
		});
		
		// text header fields
		$('.textheader-edit input').unbind('click').click(function(e){
			e.stopPropagation();
		}).unbind('change').bind('change', function(e){
			$(this).parents().find('.savebtn').filter(':first').addClass('btn-warning', {duration:500});
		});

		// sortable list
		if( $('#sortable').length > 0 )
		{
			$("#sortable").sortable({handle:'.label'});
		}

		// sortable list with content-->
		if( $('#sortable2').length > 0 )
		{
			$("#sortable2").sortable({handle:'.label'});
			$('#sortable2 .label').unbind('click').click(function(e){
				e.stopPropagation();

				var t = $(this);
				var s = t.find('.showcnt');
				var n = t.find('.navbar');
				var det = t.parents('li').find('.details');

				if( !det.is(':visible') )
				{
					det.slideDown();
					s.removeClass('icon-arrow-down').addClass('icon-arrow-up');
					// show editor controls
					n.css('display','block');
					n.animate({opacity:1}, 500);

				}
				else
				{
					det.slideUp();
					s.removeClass('icon-arrow-up').addClass('icon-arrow-down');

					// hide editor controls when nothing has been edited
					if( ! n.find('.savebtn').hasClass('btn-warning'))
					{
						n.animate({opacity:0}, 500, function(){
							$(this).css('display','none');
						});
					}
				}
			});
		}

		// save sort order
		$('#sortable2').unbind('sortstop').bind('sortstop', function(e){
			var items_sorted = [];
			$('.page_editor .sortitem').each(function(e){
				var template_id = $(this).attr('id').split('-')[1];
				var position	= $('.page_editor .sortitem').index(this);
				items_sorted[position] = template_id;

				var pt = position;
				if( pt < 10 ){ pt = '0'+pt; }
				$(this).find('.part_number').filter(':first').html(pt);
			});


			$.ajax({
				type: 		'POST',
				url: 		PageManager.apiUrl+'updatetemplatesorting',
				data: 		{ positions: items_sorted },
				dataType:	'json',
				complete: function(e) {},
				success: function(e) {},
				error: function(e) {}
			});
		});

		// enable text fields
		$('[data-editable="true"]').unbind().click(function(e){
			e.stopPropagation();

			$(this).attr('contentEditable','true');

			$('#sortable2').sortable('disable');

			$('.template-itemholder').sortable().sortable('disable');

			this.removeEventListener('input');
			this.addEventListener('input', function(e){
				$(this).attr('data-changed', 'true');
				$(this).parents().find('.savebtn').filter(':first').addClass('btn-warning', {duration:500});
			}, false );

			this.removeEventListener('paste');
			this.addEventListener('paste', function(e){
				var div = e.target;
				setTimeout(function(){
					$(div).html( $(div).text() );
				}, 1);
			});

			$(this).blur(function(e){
				$('#sortable2').sortable('enable');
				$('.template-itemholder').sortable('enable');
			});

			// <br/>'s for enters
			$(this).unbind('keydown').keydown(function(e) {
				if (e.keyCode === 13)
				{
					e.preventDefault();
					if( window.getSelection )
					{
						var sel = window.getSelection();
						if (sel.getRangeAt && sel.rangeCount) {
							var ret = document.createElement('br');
							var range = sel.getRangeAt(0);

							range.insertNode(ret);
							range.setStartAfter(ret);
							range.collapse(true);
							sel.removeAllRanges();
							sel.addRange(range);
						}
					} else if ( document.selection && document.selection.createRange ) {
						document.selection.createRange().pasteHTML('<br/>');
					}
				}
			});

			$(this).focus();
		});

		// enable hidden fields
		$('[data-key].hidden').each(function(){
			$(this).attr('style', '');
			$(this).removeClass('hidden');

			if( $(this).data('description') )
			{
				$(this).before( '<div class="field-description">'+$(this).data('description')+'</div>' );
			}
		});

		// enable selects
		$('[data-editable="select"]').each(function(){
			var select, options, value;

			value   = $(this).data('value');
			options = $(this).data('select').split('|');
			select  = '<select>';
			for( var i=0 ; i<options.length ; i++ )
			{
				select += '<option value="'+options[i]+'"';
				if(options[i] == value)
				{
					select+=' selected';
				}
				select += '>'+options[i]+'</option>';
			}
			select += '</select>';

			$(this).html(select);
		});

		// enable video players
		$('div[id^="mediaplayer-"]').each(function(){
			var tid = $(this).attr('id');
			if( tid.indexOf('_wrapper') < 0 )
			{
				jwplayer(tid).setup({
					'flashplayer': '/assets/jwplayer/jwplayer.flash.swf',
					'width': '100%',
					'height': 400,
					'file': $(this).data('url'),
					'controlbar': 'bottom'
				});
			}
		});

		// handle multiple items (list etc)
		$('.template-itemholder .template-item').each(function(){

			var image_id	= $(this).find('[data-key="image"]').html();
			var part_num	= $('.template-itemholder .template-item').index(this);
			var templ_id	= $(this).parents().find('.btn-group').data('templateid');

			// delete button
			if( $(this).find('.remove-item').length < 1 )
			{
				$(this).append('<a class="btn remove-item"><i class="icon icon-remove"></i></a>');
			}

			// add item button
			$(this).parents('.details').find('.footerbar').removeClass('hidden');
			$('.addtemplateitem').unbind().click(function(e){
				e.stopPropagation();

				var template_id = $(e.target.parentNode).data('templateid');
				that.addTemplateItem(template_id);
			});

			// remove item button
			$('.remove-item').unbind('click').click(function(e){
				e.stopPropagation();

				var item_count	= $(e.target).parents('.template-itemholder').find('.template-item').length;
				if( item_count > 1 )
				{
					var c = confirm("Dit gedeelte verwijderen?");
					if( c )
					{
						var item  = $(e.target).parents('.template-item').filter(':first');
						var slug  = $(item).find('[data-key="slug"]').html();
						var wrap  = $(item).parents('.template-itemholder').filter(':first');
						var pagetemplate = $(item).parents('.sortitem').attr('id').substr(9);

						var i =0;
						$(wrap).find('.template-item').each(function(e){
							if(this === item[0])
							{
								$.ajax({
									type: 		'POST',
									url: 		PageManager.apiUrl+'removetemplateitem/'+pagetemplate+'/'+i,
									data: 		'',
									dataType:	'json',
									complete: function(e) {},
									success: function(e) {
										$(item).animate({opacity:0, height:0}, 500, function(){ $(this).remove()});
									},
									error: function(e) {}
								});
							}
							i++;
						});
					}
				}
			});

			// sorting template sub items
			$(this).unbind().mouseover(function(e){
				$('#sortable2').sortable('disable');
				$('.template-itemholder')
				.sortable({items:'.template-item'})
				.sortable('enable')
				.unbind('sortstop').bind('sortstop', function(){
					if( $(this).find('.main_image').length > 1 )
					{
						var ur = $(this).find('[data-key="slug"]').html();
					}
					$(this).parents().find('.savebtn').filter(':first').addClass('btn-warning', {duration:500});
				});

				$(this).mouseout(function(e){
					$('#sortable2').sortable('enable');
					// $('.template-itemholder').sortable('disable');
				});
			});
		});

		//enable link modal
		$(".sortitem").each(function(){

			itemIndex = 0;
			$(this).find('[data-key="slug"]').each(function()
			{
				var pages_template_id = $(this).parents('.sortitem').attr('id').substr(9);

				if( ! $(this.parentNode).find('.sluglink').length )
				{
					$(this).after('<a class="sluglink btn" href="/beheer/modal/linkcreator/' + pages_template_id + '/' + itemIndex + '"' + ' role="button" data-toggle="modal" data-target="#modalWindow"><i class="icon-arrow-right"></i></a>');
				}

				// enable follow when slug is defined
				if( $(this).html() != "")
				{
					if( $(this).parent().find('.follow-item').length < 1 )
					{
						$(this).parent().append('<a class="btn follow-item"><i class="icon icon-chevron-right"></i></a>');
					}
				}

				itemIndex ++;
			});
		});


		// sub item page link
		$('.follow-item').unbind().click(function(e){
			e.stopPropagation();
			var item  = $(e.target).parents('.template-item').filter(':first');

			if(item.length == 0)
			{
				var pagetemplate = $(e.target).parents('.sortitem').attr('id').substr(9);
				var i = -1;

				$.ajax({
					type: 		'GET',
					url: 		PageManager.apiUrl+'pagebyitem/'+pagetemplate+'/'+i,
					data: 		'',
					dataType:	'json',
					cache: 		false,     
					complete: function(e) {},
					success: function(e) {

						window.location = '/beheer/page/edit/'+e.page
					},
					error: function(e) {}
				});
			}
			else
			{
				var wrap  = $(item).parents('.template-itemholder').filter(':first');
				var pagetemplate = $(item).parents('.sortitem').attr('id').substr(9);
				var i = 0;
				
				$(wrap).find('.template-item').each(function(){
					if(this === item[0])
					{
						$.ajax({
							type: 		'GET',
							url: 		PageManager.apiUrl+'pagebyitem/'+pagetemplate+'/'+i,
							data: 		'',
							dataType:	'json',
							cache: 		false,     
							complete: function(e) {},
							success: function(e) {

								window.location = '/beheer/page/edit/'+e.page
							},
							error: function(e) {}
						});
					}
					i++;
				});
			}
		});
		
		// enable image modal links, croptool
		$('[data-key="image_id"]').each(function(){
			$(this).attr('style', 'display:none');
			if( $(this).attr('id') )
			{
				var part = -1;
				var template_id	= $(this).attr('id').substr(14);
				var image_id	= $(this).html();
				
				if( $(this).parents('.template-itemholder').length > 0 )
				{
					part = $('#template-'+template_id+' .preview [data-key="image_id"]').index(this);
				}

				if( ! $(this.parentNode).find('.removeimg').length )
				{
					$(this).after('<a title="Afbeelding verwijderen" class="removeimg btn"><i class="icon icon-ban-circle"></i></a>');
				}

				if( ! $(this.parentNode).find('.croplink').length )
				{
					$(this).after('<a title="Afbeelding aanpassen" class="croplink btn" href="/beheer/modal/imagecropper/'+ image_id +'/'+template_id+'/'+ part +'" role="button" data-toggle="modal" data-target="#modalWindow"><i class="icon icon-picture"></i></a>');
				}
				else
				{
					$(this.parentNode).find('.croplink').attr('href', '/beheer/modal/imagecropper/'+ image_id +'/'+template_id+'/'+part);
				}
			}
		});
		
		// save template button
		$('.navbar .savebtn').unbind('click').click(function(e){
			e.stopPropagation();
			var template_id = $(e.target).parents('li.sortitem');
			template_id = $(template_id).attr('id').substr(9);

			that.saveTemplate(template_id, null);
		});

		// delete template button
		$('.navbar .deletebtn').unbind('click').click(function(e){
			e.stopPropagation();
			var template_id = $(e.target).parents('li.sortitem');
			template_id = $(template_id).attr('id').substr(9);

			that.deleteTemplate(template_id);
		});

		// publish template button
		$('.navbar .publishbtn').unbind('click').click(function(e){
			e.stopPropagation();
			var template_id = $(e.target).parents('li.sortitem');
			template_id = $(template_id).attr('id').substr(9);

			that.publishTemplate(template_id);
		});

		// remove image button
		$('.removeimg').unbind('click').click(function(e){
			var $item = $(e.target).parents('.template-item');
			$item.find('.item-image').parents().filter(':first').remove();
		});

        $('.new-item .label').click();
        $('.new-item').removeClass('new-item');

        if(this.ready === false)
        {
            $('.sortlist .sortitem:first-child .label').click();
        }

		this.ready = true;
	},

	addTemplate : function(ref) {
		var that	 = this;
		var page_id	 = $(ref).data('page');
		var template = $(ref).data('template');

		$.ajax({
			type: 'POST',
            cache:false,
			url: PageManager.apiUrl+'addtemplate',
			data: 'page_id='+ page_id +'&template_id='+ template,
			dataType: 'json',
			success: function(e) {
				var new_row = $(e.admin_template);
				var part_num= parseInt( $('.sortitem').length, 10 );
				if( part_num < 10 ){ part_num = '0'+part_num; }

				$(new_row).addClass('new-item');
				$(new_row).find('.preview').html(e.html);
				$(new_row).find('.part_number').html(part_num);
				$('#sortable2').append(new_row).sortable('refresh');

				$('#modalWindow').modal('hide');
                that.init();
			},
			error: function(e) {

                console.log(e);

            },
			complete: function(e) {



            }
		});
	},

	addTemplateItem : function(id) {
		var $copy = $('#template-'+id+' .template-item:first').clone();

		//$copy.addClass('new-template');
		$copy.find('[data-key="image_id"]').html('-1');
		$copy.find('[data-key="slug"]').html('-');
		$copy.find('.item-image').prop('src','');
		$copy.find('.croplink, .sluglink').remove();

		$.ajax({
			type: 		'GET' ,
			url: 		PageManager.apiUrl+'templatemetadata/list/items' ,
			data: 		{} ,
			dataType:	'json' ,
			success : function(e) {
				for( var k in e.cfg )
				{
					$copy.find('[data-key="'+k+'"]').html(e.cfg[k]);
				}
				$('#template-'+id+' .template-itemholder').append($copy);
				PageEditor.init();
			} ,
		});
	},

	saveTemplate : function(id, callback) {
		var i 	  = 0;
		var j 	  = 0;
		var _that = this;
		var data  = '';
		var items = $('#template-'+id+' .template-item');
        var hold  = $('#template-'+id).find('.facebook,.twitter');

		$('[data-editable="select"]').each(function(){
			var val;
			val = $(this).find('select').attr('value');
			$(this).data('value',val);
			$(this).html(val);
		});

		if(items.length > 0 && hold.length < 1)
		{
			data += '&itemcount='+items.length;

			$('li#template-'+id+' .preview [data-editable]').each(function(){
				if( ! $(this).parents('.template-itemholder').length )
				{
					var k = $(this).data('key');
					var v = $(this).text();
					data += '&'+k+'='+v;
				}
			});

			$(items).each(function(){
				i++;
				var elements = $(this).find('[data-editable]');
				elements.each(function(){
					var k = $(this).data('key');
					var v = $(this).text();

					data += '&item'+i+'-'+k+'='+v;
				});
			});
		}
		else
		{
			$('li#template-'+id+' [data-editable]').each(function(){
				var k = $(this).data('key');
				var v = $(this).text();
				data += '&'+k+'='+v;
			});
		}

		// save header fields
		$('li#template-'+id+' .textheader-edit input').each(function(){
			var k = $(this).attr('name');
			var v = $(this).attr('value');
			data += '&'+k+'='+v;
		});

		var pagetemplate_id = $('li#template-'+id).parents('.sortitem');
		$.ajax({
			type: 		'POST',
			url: 		PageManager.apiUrl+'savetemplate/'+ id +'/'+ _that.page_id,
			data: 		data,
			dataType:	'json',
			complete: function(e) {},
			success: function(e) {
				$('li#template-'+id+' [data-key="slug"]').each(function(){
					var index = $('li#template-'+id+' [data-key="slug"]').index(this);
					if( e && e.slugs )
					{
						$(this).html(e.slugs[index]);
					}
				});

				if( e && e.data )
				{
					var data = e.data;
					if( data.items )
					{
						var fields = $('li#template-'+id).find('.template-item');
						for( i = 0 ; i < fields.length ; i++ )
						{
							var idf  = $(fields[i]).find('[data-key="id"]');
							var slug = $(fields[i]).find('[data-key="slug"]');

							var item = data.items[i];
							/*
							if( item.old_slug == $(slug).text() )
							{
								$(slug).html( item.slug );
								$(idf).html( item.id );
							}*/
						}
					}
				}

				$('li#template-'+id+' .savebtn').addClass('btn-success', {duration:500});
				setTimeout(function(){$('li#template-'+id+' .savebtn').removeClass('btn-success').removeClass('btn-warning')}, 3000);

				//HOOK AFTER SAVE
				if(callback != undefined)
				{
					callback();
				}
			},
			error: function(e) {
				$('li#template-'+id+' .savebtn').addClass('btn-danger', {duration:500});
				setTimeout(function(){$('li#template-'+id+' .savebtn').removeClass('btn-danger').removeClass('btn-warning')}, 3000);
			}
		});
		this.init();
	},

	deleteTemplate : function(id) {
		if( $('.sortitem').length > 1 )
		{
			var c = confirm('Dit gedeelte verwijderen?');
			if( c )
			{
				$.ajax({
					type: 		'POST',
					url: 		PageManager.apiUrl+'deletetemplate/'+id,
					data: 		'',
					dataType:	'json',
					complete: function(e) {},
					success: function(e) {
						$('li#template-'+id).animate({opacity:0, height:0}, 400, function(){
							$(this).remove();
							$('#sortable2').trigger('sortstop');
						});
					},
					error: function(e) {}
				});
			}
		}
	},

	addNewImage: function(data) {
		//console.log(data);
	},

	editExistingImage: function(data) {
		$.ajax({
			type: 		'POST',
			url: 		PageManager.apiUrl+'editExistingImage',
			data: 		data,
			dataType:	'json',
			complete: function(e) {},
			success: function(e)
			{
				$('#modalWindow').modal('hide');

			},
			error: function(e) {}
		});
	},

	saveAll : function() {
		$('#sortable2 .sortitem').each(function(){
			var id = $(this).attr('id').substr(9);
			PageEditor.saveTemplate(id, null);
		});
	},
	publishPage : function(id) {
		$.ajax({
			type: 		'POST' ,
			url: 		PageManager.apiUrl+'publishpage/'+id+'?t='+new Date().getTime()+'&r='+Math.random(),
			data: 		{} ,
			dataType:	'jsonp' ,
			cache: 		false ,
			complete: 	function(e) {
			} ,
			success: 	function(e) {
				var state = '';
				if(e.newstate === 1)
				{
					state = 'open';
				}
				else
				{
					state = 'close';
				}
				$('.btn.publishpage i').attr('class','icon-eye-'+state);
			} ,
			error: 	function(e) {}
		});
	},

	publishTemplate : function(id) {
		$.ajax({
			type: 		'POST' ,
			url: 		PageManager.apiUrl+'publishtemplate/'+id+'?t='+new Date().getTime()+'&r='+Math.random(),
			data: 		{} ,
			dataType:	'jsonp' ,
			cache: 		false ,
			complete: 	function(e) {
			} ,
			success: 	function(e) {
				var state = '';
				if(e.newstate === 1)
				{
					state = 'open';
				}
				else
				{
					state = 'close';
				}
				$('#template-'+id+' .publishbtn i').attr('class','icon-eye-'+state)
			} ,
			error: 	function(e) {}
		})
	},

};
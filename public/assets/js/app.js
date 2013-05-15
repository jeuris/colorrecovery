var Interface = {
	apiUrl : 'http://colorrecovery.mxa-dev.com/public/public/api/',
	slider : {
		index : 1 ,
		speed : 500,
		duration: 3000,
		paused: false,
	}
};

var Page = {

	init : function() {
		this.enablePagination();
		this.enableContactforms();
		this.enableVideoPlayers();
	},
	
	load : function(id) {
		$.ajax({
			type:		'GET',
			url: 		Interface.apiUrl+'page/'+id,
			dataType:	'json',
			data: 		'',
			success: function(e) {
				$('.content').empty();
				for(var i=0; i<e.parts.length; i++)
				{
					$('.content').append(e.parts[i]);
				}
			},
		});
	},

	render : function() {
		$('');
	},

	enablePagination : function() {
		 $('.paginate').each(function(){
			 if( $(this).data('pagesize') != 'all' )
			 {
				 var _page, $container, height, i, index, new_items, per_page;
				 _page = this;
				 height = [];
				 i = 0;
				 index = 1;
				 per_page  = parseInt( $(this).data('pagesize'), 10 );

				 if(! $(this).hasClass('pag-'+per_page) )
				 {
					 $(this).addClass('pag-'+per_page);
				 }

				 new_items = '<div class="page pag-'+per_page+'">';

				 $container = $(this).parent().find('.template-itemholder');
				 $container.find('.template-item').each(function(){
					 if( i === per_page )
					 {
						 index++;
						 i = 1;
						 new_items += '</div><div class="page pag-'+per_page+'">';
					 }
					 else
					 {
						 i++;
					 }
					 height += parseInt($(this).height(), 10);
					 new_items += $(this)[0].outerHTML;
				 });
				 new_items += '</div>';

				 $container.html('<div class="pages">'+new_items+'</div>');

				 // pagination bar
				 $container.parent().find('.pagination-bar').empty();
				 var page_bar = '<div class="pagination-bar"><div class="pagination"><ul class="slidertab">';
				 for( var i=0 ; i<index ; i++ )
				 {
					 var pg = i+1;
					 page_bar+= '<li class="p'+pg+'"><a href="javascript:void(0);">'+pg+'</a></li>';
				 }
				 page_bar+= '</ul></div></div>';

				 $container.append(page_bar);
				 $container.find('.pagination-bar li a').unbind('click').click(function(e){
					 var num = parseInt( $(this).text(), 10 );
					 Page.paginate(_page, num);
				 });

				 $container.find('.pagination-bar li:first-child').addClass('active');

				 setTimeout( function(){
					 Page.moveSlider(_page, 1);
				 }, Interface.slider.duration );
			 }
		});
	},

	paginate : function(el, num) {
		$(el).parents().find('.pagination-bar li').removeClass('active');
		$(el).parents().find('.pagination-bar li.p'+num+'').filter(':first').addClass('active');

		var container	= $(el).parents().find('.pages').filter(':first');
		var scroll_to	= $(el).find('.page:first-child').width() * ( num - 1 );

		container.animate({left:-scroll_to}, 500);

		// todo: scroll pagination bar to last item?
	},

	moveSlider : function(slider, dir)
	{
		var moveTo = Interface.slider.index + dir;
		var total  = $(slider).find('.page').length;

		if( moveTo > total )
		{
			moveTo = 1;
			Interface.slider.index = 1;
		}

		if( Interface.slider.paused !== true )
		{
			Interface.slider.index = moveTo;
			Page.paginate(slider, moveTo);
			setTimeout( function(){
				Page.moveSlider(slider, 1);
			}, Interface.slider.duration );
		}
	},

	enableContactforms : function() {
		$('form.mailform').each( function(){
			// todo: validate (api!)
			// todo:

			var _this = this;

			$(this).find('textarea').after('<br/><br/><button class="sendbutton">send</button>');
			$(this).find('button.sendbutton').unbind('click').click(function(ev){
				ev.preventDefault();

				var i    = 0;
				var data = 'r='+Math.random();

				$(_this).find('input').each(function(){
					var k = $(this).attr('name');
					var v = $(this).val();
					data += '&'+k+'='+v;
				});

				$(_this).find('textarea').each(function(){
					i++;
					data += '&text'+i+'='+$(this).val();
				});

				$.ajax({
					type: 		'POST' ,
					url: 		Interface.apiUrl+'sendmail' ,
					data: 		data   ,
					dataType:	'json' ,
					complete: 	function(e) {} ,
					success: 	function(e) {
						console.log(e);
						if( e.error )
						{
							alert(e.message);
						}
						else
						{
							$(_this).find('.sendbutton')
							.unbind('click')
							.animate({opacity:0}, 500, function(){
								$(this).html('message sent!')
								.animate({opacity:1})
								.css('pointer-events','none');
							});
						}
					} ,
					error: 		function(e) {}
				});
			});
		});
	},

	enableVideoPlayers : function() {
		$('.content .video .player').each(function(){
			jwplayer(this).setup({
				'flashplayer': '/assets/jwplayer/jwplayer.flash.swf',
				'width': '100%',
				'height': 400,
				'file': $(this).data('url'),
				'controlbar': 'bottom'
			});
		});
	}
};

var List = {

    root                    : '',
    clean_colors            : [
        'assets/images/CR_icon_leaf.svg',
        'assets/images/CR_icon_prize.svg',
        'assets/images/CR_icon_bottle.svg',
        'assets/images/CR_icon_flag.svg'],
    certifying_programme    : [
        'assets/images/CR_icon_prize.svg'],
    collection_recovery     : [
        'assets/images/CR_icon_hands.svg',
        'assets/images/CR_icon_sync.svg'],
    default_image           : 'assets/images/CR_iconholder.svg',

    init:function(slug)
    {
        var module = slug.replace("-", "_");

        this.root = $('.content').data('url');

        if(module === 'clean_colors')
        {
            this.replace(this.clean_colors);
        }

        if(module === 'certifying_programme')
        {
            this.replace(this.certifying_programme);
        }

        if(module === 'collection_recovery')
        {
            this.replace(this.collection_recovery);
        }
    },

    replace:function(datasource)
    {
        var _this = this;
        $('.template-item').each(function(index, item)
        {
           var img = datasource[index];

           if(img == undefined)
           {
               img = _this.default_image;
           }

           $(this).css('background-image', 'url(' + _this.root + img + ')');
        });
    }

}

$(document).ready(function(e){
	Page.init();
});
<div class="page_editor row-fluid" data-pageid="<?php echo $page->id; ?>">
	<div class="widgetcontent">
		<ul id="sortable2" class="sortlist">
		<?php
		$i = 0;
		if(isset($page->templates))
		{
			foreach( $page->templates as $t )
			{
				$part_number = '';
				$i < 10 ? $part_number = '0'.$i : $i;

				$json 		= json_decode($t->metadata, true);
			?>
			<li class="sortitem" id="template-<?php echo $t->id; ?>">
				<div class="label">
					<span class="icon-align-justify"></span>
					<span class="icon-arrow-down showcnt"></span>
					<span class="part_number"><?php echo $part_number; ?></span>
					<?php
					if( $all_templates[$t->template_id]['has_header'] )
					{
						echo @$json['header-head'].' / '.@$json['header-label'];
					}
					else
					{
						echo $all_templates[$t->template_id]['title'];
					}
					?>
					<div class="navbar">
						<?php echo View::forge('private/admin/templates/templatetoolbar', array('t'=>$t, 'json'=>$json, 'all_templates'=>$all_templates) )->render(); ?>
					</div>
				</div>
				<div class="details">
					<div class="preview front content" style="">
						<?php echo View::forge($all_templates[$t->template_id]['view'], array('page_template'=>$t, 'json'=>$json) )->render(); ?>
					</div>
					<div class="footerbar hidden">
						<?php echo View::forge('private/page/templatetoolbarfooter', array('id'=>$t->id) )->render(); ?>
					</div>
				</div>
			</li>
			<?php
				$i++;
			}
		}
		?>
	   	</ul>
	</div>
</div>
<a class="btn btn-primary pull-right" href="<?php echo Uri::base() . 'beheer/modal/templatepicker/' . $page->id; ?>" role="button" data-toggle="modal" data-target="#modalWindow"><i class="icon-plus-sign icon-white"></i> template toevoegen</a>
<a class="btn btn-success pull-right" href="javascript:PageEditor.saveAll();"><i class="icon-check icon-white"></i> alles opslaan</a>
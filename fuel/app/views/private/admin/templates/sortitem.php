<li class="sortitem" id="template-<?php echo $id; ?>">
    <div class="label">
        <span class="icon-align-justify"></span>
        <span class="icon-arrow-down showcnt"></span>
		<span class="part_number">0</span>
        <?php echo $title; ?>
		<div class="navbar pull-right">
			<?php echo View::forge('private/admin/templates/templatetoolbar', array('id'=>$id, 't'=>$t, 'json'=>$json, 'all_templates'=>$all_templates) )->render(); ?>
		</div>
    </div>
    <div class="details">

        <div class="clearfix"></div>

        <div class="preview front content" style="">

        </div>
        <div class="footerbar hidden">
            <?php echo View::forge('private/page/templatetoolbarfooter', array('id'=>$id) )->render(); ?>
        </div>
    </div>
</li>

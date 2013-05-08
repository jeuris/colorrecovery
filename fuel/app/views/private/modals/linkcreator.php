<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h2>Link dit item</h2>
</div>
<div class="modal-body">
	<div class="tabbable tabs-below">
		<div class="tab-content">
			<div id="A" class="tab-pane <?php echo (!isset($presetSlugType) || $presetSlugType != 'external') ? ' active' : ''; ?>">
				<ul class="menu toplevel" id="linkerList">

				<?php
					foreach ($categories as $category) 
					{
						$subcategories = $category->subcategories;

						if($subcategories)
						{
							echo '<li class="expanded"><a href="#" data-slug="'. $category->page->slug . '" data-linkType="category">' . $category->title . '</a><br />';
							echo '<ul class="menu">';

							foreach ($subcategories as $subcategory)
							{
								$collections = $subcategory->collections;

								if($collections)
								{
									echo '<li class="expanded"><a href="#" data-slug="'. $subcategory->page->slug . '" data-linkType="subcategory">' . $subcategory->title . '</a><br />';
									echo '<ul class="menu">';

									foreach ($collections as $collection)
									{
										$items = $collection->items;

										if($items)
										{
											echo '<li class="expanded"><a href="#" data-slug="'. $collection->page->slug . '" data-linkType="collection">' . $collection->title . '</a><br />';
											echo '<ul class="menu">';

											foreach ($items as $item)
											{
												echo '<li class="leaf"><a href="#" data-slug="'. $item->page->slug . '" data-linkType="item">' . $item->title . '</a></li>';
											}

											echo '</ul>';
											echo '</li>';
										}
										else
										{
											echo '<li class="leaf"><a href="#" data-slug="'. $collection->page->slug . '" data-linkType="collection">' . $collection->title . '</a></li>';
										}
									}

									echo '</ul>';
									echo '</li>';
								}
								else
								{
									echo '<li class="leaf"><a href="#" data-slug="'. $subcategory->page->slug . '" data-linkType="subcategory">' . $subcategory->title . '</a></li>';
								}
							}

							echo '</ul>';
							echo '</li>';
						}
						else
						{
							echo '<li class="leaf"><a href="#" data-slug="'. $category->page->slug . '" data-linkType="category">' . $category->title . '</a></li>';
						}	
					}

					if($pages)
					{
						echo '<li class="expanded"><a href="#" data-slug="">overige</a><br />';
						echo '<ul class="menu">';
						foreach ($pages as $page)
						{
							echo '<li class="leaf"><a href="#" data-slug="'. $page->slug . '" data-linkType="item">' . $page->slug . '</a></li>';
						}
						echo '</ul>';
						echo '</li>';
					}
				?>
				</ul>

				<a class="btn btn-primary" href="#" role="button" onClick="PageManager.linkToExistingPage(<?php echo $pages_template_id ?>, <?php echo $item_id ?>);"><i class="icon-plus-sign icon-white"></i>link item</a>
			</div>
			<div id="B" class="tab-pane">
					<p>naam van de pagina</p>
					<input type="text" id="pagename"/>
					<a class="btn btn-primary" href="#" role="button" onClick="PageManager.linkToNewPage(<?php echo $pages_template_id ?>, $('#pagename').val(), 'item', <?php echo $item_id ?>)"><i class="icon-plus-sign icon-white"></i>link item</a>
			</div>
			<div id="C" class="tab-pane <?php echo (isset($presetSlugType) && $presetSlugType == 'external') ? ' active' : ''; ?>">
					<p>externe link</p>
					<input type="text" id="externallink" value="<?php echo (isset($presetSlug) || $presetSlugType == 'external') ? $presetSlug : ''; ?>"/>
					<a class="btn btn-primary" href="#" role="button" onClick="PageManager.linkToExternalPage(<?php echo $pages_template_id ?>, <?php echo $item_id ?>, $('#externallink').val())"><i class="icon-plus-sign icon-white"></i>link item</a>
			</div>
		</div>
		<ul class="nav nav-tabs">
			<li class="<?php echo (!isset($presetSlugType) || $presetSlugType != 'external') ? 'active' : ''; ?>"><a data-toggle="tab" href="#A">Kies pagina</a></li>
			<li class=""><a data-toggle="tab" href="#B">Nieuwe pagina</a></li>
			<li class="<?php echo (isset($presetSlugType) && $presetSlugType == 'external') ? 'active' : ''; ?>"><a data-toggle="tab" href="#C">Externe link</a></li>
		</ul>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function()
	{
		PageManager.linkcreatorSetup('<?php echo $presetSlug; ?>', '<?php echo $presetSlugType; ?>');
	});
</script>
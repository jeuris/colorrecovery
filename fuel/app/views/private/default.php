<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/assets/css/style.default.css" type="text/css" />
	<link rel="stylesheet" href="/assets/css/style.beheer.css" type="text/css" />
	<script type="text/javascript" src="/assets/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery-ui-1.9.2.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.flot.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/assets/js/custom.js"></script>
	<script type="text/javascript" src="/assets/js/beheer.js"></script>
	<script type="text/javascript" src="/assets/js/cropUploader.js"></script>
	<script type='text/javascript' src="/assets/jwplayer/jwplayer.js"></script>
	<script type='text/javascript' src="/assets/js/jquery.columnview.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.Jcrop.js"></script>
	<link rel="stylesheet" href="/assets/css/jquery.Jcrop.css" type="text/css" />
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
</head>

<body>
<div class="mainwrapper fullwrapper">
	<div class="leftpanel">
        <div class="logopanel">
        	<h1><a href="/beheer/"><?php echo $config['name']; ?></a></h1>
        </div>
		
		<div class="leftmenu">
			<ul class="nav nav-tabs nav-stacked">
			<?php
			// hier checkt hij of er menu items zijn. Zo niet kun je deze aanmaken. Admin only ( site admin niet gebruiker )
			$teller = 1;
			if(isset($menu))
			{
				foreach($menu as $item)
				{
					echo '<li class="nav-header" style="padding:0"><a href="/beheer/page/edit/'.$item->page->id.'">' . $item->title . '</li>';

					if( isset( $item->subcategories ) )
					{
						foreach($item->subcategories as $subcategory)
						{
							$subcollections = $subcategory->collections;

							if(isset($subcollections) && count($subcollections) > 0)
							{
								echo '<li class="">';
								echo '<a href="'. Uri::base().'beheer/page/edit/'.$subcategory->page->id .'">' . $subcategory->title . '</a>';
								echo '<ul style="display: block; ">';

								foreach($subcollections as $subcollection)
								{
									echo '<li><a style="padding-left:12px;" href="' . Uri::base().'beheer/page/edit/'.$subcollection->page->id . '">' . $subcollection->title . '</a></li>';
								}

								echo '</ul></li>';
							}
							else
							{
								echo '<li><a style="padding-left:32px;" href="'. Uri::base().'beheer/page/edit/'.$subcategory->page->id .'">' . $subcategory->title . '</a></li>';
							}
						}
					}

					echo '<div class="plainwidget animate'. $teller .' fadeInUp"><a href="' . Uri::base() . 'beheer/modal/subcategory/' .$item->id .'" role="button" data-toggle="modal" data-target="#modalWindow"><span class="icon-plus-sign"></span>nieuwe subcategorie</a></div>';
					$teller++;
				}
			}

			//echo '<li class="nav-header">images</li>';
			//echo '<li><a href="' . Uri::base() . 'beheer/modal/imagecropper/' . 1 .'" role="button" data-toggle="modal" data-target="#modalWindow"><span class="icon-plus-sign"></span>nieuwe subcategorie</a></li>';
			?>
			</ul>
		</div>
	</div>
	
	<div class="rightpanel">
		<div class="headerpanel">
			<a href="#" class="showmenu"></a>
			<div class="headerright">
			
    			<div class="dropdown userinfo">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="">Welkom, <?php echo $current_user->username;?>! <b class="caret"></b></a>
                    <ul class="dropdown-menu">
						<?php
						if($user_group === 100)
						{
							echo '<li><a href="/beheer/reset"><span class="icon-warning-sign"></span> Reset alles</a></li>';
						}
						?>
						<li><a href="/beheer/logout"><span class="icon-off"></span> Uitloggen</a></li>
                    </ul>
                </div><!--dropdown-->
			</div>
		</div>
        <div class="breadcrumbwidget">
        	<ul class="breadcrumb">

                <?php

                    $totalpath = Uri::Base() . 'beheer/page/edit/';

                    if(isset($breadcrumb))
                    {
                        foreach($breadcrumb as $key => $crumb)
                        {
                            $totalpath = $crumb['id'] .'/';
                            echo '<li><a href="'.$totalpath.'">'.$crumb['title'].'</a><span class="divider">/</span></li>';
                        }
                    }
                ?>
            </ul>
        </div>
        
        <div class="pagetitle">
        	<?php
        	if(isset($header))
        	{
        		echo $header;
        	}
        	else
        	{
        		echo View::forge('private/defaults/header');
        	}
        	?>
        </div>
        
		<div class="maincontent" data-folderpath="<?php echo \Uri::base(); ?>">
			<div class="contentinner">
				<?php
				if( isset($content) )
				{
					echo $content;
				}
				?>
			</div>
		</div>
	</div>
	<div class="footer" style="background:none">
		<?php
		if($user_group === 100)
		{
    		echo '<div class="footerleft">';
			echo '<div class="plainwidget animate'.$teller.' fadeInUp">';
			echo '<a href="'.Uri::base().'/beheer/category/add">';
			echo '<span class="icon-plus-sign"></span>';
			echo 'Nieuwe hoofdcategorie toevoegen';
			echo '</a></div>';
    		echo '</div>';
		}
		?>
    	<div class="footerright" style="display:none"></div>
</div><!--footer-->
</div>
<div id="modalWindow" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body" style="padding:0; max-height:900px;">
		<!-- content ajax -->
	</div>
</div>
</body>
</html>
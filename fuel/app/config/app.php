<?php
return array(

	'app_config' => array(

		'name'	=>	'color recovery' ,
		'default_page' => 1 ,
		
		'feeds' =>	array(
			'facebook'	=> array(
				'user'			=> '',
				'user_id'		=> '',
				'app_id'		=> '',
				'app_secret'	=> '',
			),
			'twitter'	=> array(
				'user'	=> '',
			),
		),

		//--------------------------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------------------------------------------
		// Page manager
		'page_manager'	=> array(

			// hier bepaal je welke templates de views van je category mogen bevatten
			'service'	=> array(

				'allowed_templates' => array(

					// als leeg of undefined - show all templates
					// anders luister naar allowed_templates

				),

				// hier bepaal je welke templates de kinderen van je category mogen bevantten
				'subcategories' => array(

					'faq'	=> array(

						'allowed_templates' => array(

							'header',
							'list-detail'
						),
					),
					'tac'	=> array(

						'allowed_templates' => array(

							'header',
							'list-detail',
							'video',
						),
					),
				),
			),

			'aanbod'	=> array(

				'allowed_templates' => array(
					'header'			,
					'video'				,
					'list'				,
					'grid'				,
					'gallery'           ,
					'form'              ,
					'header-text'       ,
					'news'              ,
					'product-detail'    ,
					'text'              ,
					'text-columns'      ,
					'collection-holder' ,
					'product-holder'    ,
				),

				'subcategories' => array(

					'watches'	=> array(

						'allowed_templates' => array(
							'header'			,
							'video'				,
							'list'				,
							'grid'				,
							'gallery'           ,
							'form'              ,
							'header-text'       ,
							'news'              ,
							'product-detail'    ,
							'text'              ,
							'text-columns'      ,
							'collection-holder' ,
							'product-holder'    ,

						),

					),

				),

			),
		),

		//--------------------------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------------------------------------------
		// Templates
		'filepath' => array(
			'full'  => Uri::base() . 'files/full/',
			'temp'  => Uri::base() . 'files/temp/',
			'thumb' => Uri::base() . 'files/thumb/'
		),

		'itemtypes' => array(
			'product' 				=> 0,
			'newsitem' 				=> 1,
		),

		'pagetypes' => array(
			'category' 				=> 0,
			'subcategory' 			=> 1,
			'collection' 			=> 2,
			'item' 					=> 3,
		),

		'allowed_html_tags'			=> array('<h1>','<h2>','<h3>','<h4>','<h5>','<h6>','<p>','<a>','<strong>','<em>','<b>','<i>','<img>','<ul>','<ol>','<li>','<div>','<section>','<form>','<input>','<textarea>','<br>','<hr>','<cite>', '<script>'),
		'allowed_html_attributes'	=> array('href','src','alt', 'style', 'class','type','for','placeholder','value','name','data-pagesize','data-url','id'),

		'templates'	=> array(

			/*
			'header' => array(
				'title'				=> 'Header',
				'view'				=> 'templates/header',
				'has_header'		=> false,
				'default_metadata'	=> array(
					'image_id'		=> '-1',
					'image_url'		=> 'placeholder.png',
					'headerText'	=> 'Hoofd',
					'subText'		=> 'Sub',
					'items'			=> array(),
				),
				'images' => array(
					'full'	=> array(
						'width'  => '600',
						'height' => '350',
					),
					'thumb' => array(
						'width'  => '100',
						'height' => '100',
					),
				),
			),
			*/
			'video' => array(
				'title'				=> 'Video',
				'view'				=> 'templates/video',
				'has_header'		=> false,
				'default_metadata'	=> array(
					'image_id'		=> '-1',
					'image_url'		=> 'http://',
					'url'			=> 'http://',
				),
				'images' => array(
					'full'	=> array(
						'width'  => '100%',
						'height' => '960px',
					),
					'thumb' => array(
						'width'  => '100%',
						'height' => '960px',
					),
				),
			),
			'list' => array(
				'title'				=> 'Lijst',
				'view'				=> 'templates/list',
				'has_header'		=> true,
				'default_metadata'	=> array(
					'pagination' => 1,
					'items' => array(
						array(
							'slug'		=> '',
							'typeSlug'  => '',
							'image_id'	=> '-1',
							'image_url'	=> 'http://',
							// 'title'		=> 'Titel',
							'body'		=> 'Tekst',
							'url'		=> 'http://',
						)
					),
				),
				'images' => array(
					'full'	=> array(
						'width'  => '1280',
						'height' => '1024',
					),
					'thumb' => array(
						'width'  => '800',
						'height' => '600',
					),
				),
			),
			'slider' => array(
				'title'				=> 'Slider',
				'view'				=> 'templates/slider' ,
				'has_header'		=> false,
				'default_metadata'	=> array(
					'pagination' => 1,
					'items' => array(
						array(
							'slug'		=> '',
							'typeSlug'  => '',
							'image_id'	=> '-1',
							'image_url'	=> 'http://',
							'title'		=> 'Titel',
							'body'		=> 'Tekst',
							'url'		=> 'http://',
						)
					),
				),
				'images' => array(
					'full'	=> array(
						'width'  => '1280',
						'height' => '1024',
					),
					'thumb' => array(
						'width'  => '800',
						'height' => '600',
					),
				),
			),
			/*
            'grid' => array(
                'title'				=> 'Grid',
                'view'				=> 'templates/grid',
				'has_header'		=> false,
                'pagination'        => 5,
                'default_metadata'	=> array(
                    'items' => array(
                        array(
                            'image_id'	=> '-1',
							'image_url'	=> 'http://',
                            'title'		=> 'Titel',
                            'slug'		=> '',
                            'typeSlug'	=> '',
                        ),
                        array(
							'image_id'	=> '-1',
							'image_url'	=> 'http://',
							'title'	=> 'Titel',
                            'slug'		=> '',
                            'typeSlug'	=> '',
                        ),
                        array(
							'image_id'	=> '-1',
							'image_url'	=> 'http://',
							'slug'		=> '',
                            'typeSlug'	=> '',
                        )
                    ),
                ),
                'images' => array(
                    'full'	=> array(
                        'width'  => '800px',
                        'height' => '500px',
                    ),
                    'thumb' => array(
                        'width'  => '300px',
                        'height' => '300px',
                    ),
                ),
            ),
            'gallery' => array(
                'title'				=> 'Gallery',
                'view'				=> 'templates/gallery',
				'has_header'		=> false,
                'pagination'        => 5,
                'default_metadata'	=> array(
                    'items' => array(
                        array(
							'image_id'	=> '-1',
							'image_url'	=> 'http://',
                            'title'		=> 'Titel',
                            'body'		=> 'Tekst',
                            'slug'		=> '',
                            'typeSlug'	=> '',
                        ),
                    ),
                ),
                'images' => array(
                    'full'	=> array(
                        'width'  => '100%',
                        'height' => '500px',
                    ),
                    'thumb' => array(
                        'width'  => '300px',
                        'height' => '300px',
                    ),
                ),
            ),
*/
            'form' => array(
				'title'				=> 'Formulier',
				'view'				=> 'templates/form',
				'has_header'		=> true,
				'default_metadata'	=> array(
					'email'		=> 'E-mail',
					'tel'		=> 'Telefoon',
					'misc'		=> 'Fax',
					'formhead'	=> 'Send us a message',
					'label1'	=> 'Naam',
					'label2'	=> 'E-mail',
					'label3'	=> 'Bericht',
					'email_to'	=> 'email@adres.com',
					'text'		=> '<strong>Extra tekst</strong><p>Tekst</p>',
					'items' 	=> array(
						array(
							'title' => 'Type adres',
							'body'	=> 'Adres',
						),
					),
				),
				'images' => array(),
			),

/*
			'contentpage' => array(
				'title'				=> 'Content pagina',
				'view'				=> 'templates/contentpage',
				'default_metadata'	=> array(
					'items' => array()
				),
				'images' => array(),
			),
*/
/*
			'breadcrumbs' => array(
				'title'				=> 'Breadcrumbs',
				'view'				=> 'templates/breadcrumbs',
				'default_metadata'	=> array(
					'items' => array(
						array(
							'title' => 'titel',
							'url'	=> 'http://',
						)
					),
				),
				'images' => array(),
			),
*/

			'header' => array(
				'title'				=> 'Header',
				'view'				=> 'templates/header',
				'has_header'		=> false,
				'default_metadata'	=> array(
					'headerText'	=> 'Hoofd',
					'subText'		=> 'Sub',
					'items'			=> array(),
				),
				'images' => array(
				),
			),

			'header-text' => array(
				'title'				=> 'Tekst header',
				'view'				=> 'templates/header-text',
				'has_header'		=> false,
				'default_metadata'	=> array(
					'headerLarge'	=> 'Kop',
					'headerSmall'	=> 'Sub kop',
					'body'			=> 'Tekst',
					'items'		=> array(),
				),
				'images' => array(),
			),
			'text-columns' => array(
				'title'				=> 'Tekst met kolommen',
				'view'				=> 'templates/text-columns',
				'has_header'		=> true,
				'default_metadata'	=> array(
					'items' 	=> array(
						array(
							'header'	=> 'Kop 1',
							'text'		=> 'Tekst kolom 1',
							'slug'		=> '',
							'typeSlug'	=> '',
						),
						array(
							'header'	=> 'Kop 2',
							'text'		=> 'Tekst kolom 2',
							'slug'		=> '',
							'typeSlug'	=> '',
						),
					),
				),
				'images' => array(),
			),
			/*
						'list-detail' => array(
							'title'				=> 'Lijst detail',
							'view'				=> 'templates/list-detail',
							'has_header'		=> false,
							'default_metadata'	=> array(
								'image_id'		=> '-1',
								'image_url'		=> 'http://',
								'body'			=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
								'items' => array(),
							),
							'images' => array(),
						),
						'news' => array(
							'title'				=> 'Nieuws',
							'view'				=> 'templates/news',
							'has_header'		=> false,
							'default_metadata'	=> array(
								'source'		=> 'steiner.nl',
								'items' => array(
									array(
										'image_id'	=> '-1',
										'image_url'	=> 'http://',
										'title'		=> 'Titel',
										'body'		=> 'Tekst',
										'url'		=> 'http://',
									)
								),
							),
							'images' => array(
								'full'	=> array(
									'width'  => '600',
									'height' => '300',
								),
								'thumb' => array(
									'width'  => '303',
									'height' => '228',
								),
							),
						),
			/*
						'pagination' => array(
							'title'				=> 'Pagina nummers',
							'view'				=> 'templates/pagination',
							'default_metadata'	=> array(
								'items' => array(),
							),
							'images' => array(),
						),

						'product-detail' => array(
							'title'				=> 'Product detail',
							'view'				=> 'templates/product-detail',
							'has_header'		=> false,
							'default_metadata'	=> array(
								'description'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer imperdiet, lacus in sodales semper, nisl enim rutrum nulla, eget volutpat arcu massa in erat. Maecenas lacus dui, venenatis a lacinia at, sodales at mauris.',
								'case'			=> '',
								'strap'			=> '',
								'dial'			=> '',
								'jewels'		=> '',
								'extra'			=> 'Extra information',
								'extra_text'	=> '',
								'main_image'	=> 'product-big.png',
								'items' => array(
									array(
										'image_id'	=> -1,
										'image_url'	=> '',
									),
									array(
										'image_id'	=> -1,
										'image_url'	=> '',
									),
									array(
										'image_id'	=> -1,
										'image_url'	=> '',
									),
								),
							),
							'images' => array(
								'full'	=> array(
									'width'  => '333',
									'height' => '500',
								),
								'thumb' => array(
									'width'  => '73',
									'height' => '73',
								),
							),
						),
						'text' => array(
							'title'				=> 'Tekst',
							'view'				=> 'templates/text',
							'has_header'		=> false,
							'default_metadata'	=> array(
								'header'	=> 'Kop',
								'text'		=> 'Tekst',
								'slug'		=> '',
								'typeSlug'	=> '',
							),
							'images' => array(),
						),
						'collection-holder' => array(
							'title'				=> 'Collection Holder',
							'view'				=> 'templates/collection-holder',
							'has_header'		=> false,
							'default_metadata'	=> array(
								'collection'	=> 'Nieuwe collectie',
								'items' 		=> array(
									array(
										'id'			=> -1,
										'image_id'		=> -1,
										'image_url'		=> '',
										'title'			=> 'Collectie',
										'text'			=> 'Omschrijving',
										'slug'			=> '',
									),
								),
							),
							'images' => array(
								'full'	=> array(
									'width'  => '1200',
									'height' => '800',
								),
								'thumb' => array(
									'width'  => '600',
									'height' => '400',
								),
							),
						),
						'product-holder' => array(
							'title'				=> 'Product Holder',
							'view'				=> 'templates/product-holder',
							'has_header'		=> false,
							'default_metadata'	=> array(
								'items' 	=> array(
									array(
										'id'		=> -1,
										'image_id'	=> -1,
										'image_url'	=> '',
										'title'		=> 'Product',
										'text'		=> 'Omschrijving',
										'slug'		=> '',
									),
								),
							),
							'images' => array(
								'full'	=> array(
									'width'  => '1200',
									'height' => '800',
								),
								'thumb' => array(
									'width'  => '600',
									'height' => '400',
								),
							),
						),*/
		),
	),
);
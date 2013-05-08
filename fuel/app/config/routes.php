<?php
return array(
	'_root_'			=> 'public/page',  // The default route
	'_404_'				=> 'public/404',    // The main 404 route

	// Public
	'/(:any)'			=> 'public/$1',
	'page'				=> 'public/page',
	'page/(:any)'		=> 'public/page/$1',

	// Private
	'beheer'		 	=> 	'private/category',
	'beheer/(:any)' 	=> 	'private/$1',
	'beheer/_404_'		=>	'private/404',
);
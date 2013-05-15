<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(

	/*
	 * If you don't specify a DB configuration name when you create a connection
	 * the configuration to be used will be determined by the 'active' value
	 */
	'active' => 'default',

	/**
	 * Base PDO config
	 */
	'default' => array(
		'type'        => 'pdo',
		'connection'  => array(
			'persistent' => false,
			'compress'   => false,
		),
		'identifier'   => '`',
		'table_prefix' => '',
		'charset'      => 'utf8',
		'enable_cache' => true,
		'profiling'    => false,
	),

);

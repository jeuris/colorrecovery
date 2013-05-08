<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

$site_path		= './../';
$file_path		= './../files/';	

/**
 * Set error reporting and display errors settings.  You will want to change these when in production.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Europe/Amsterdam');

define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);
define('APPPATH', realpath(__DIR__.'/../fuel/app/').DIRECTORY_SEPARATOR);
define('PKGPATH', realpath(__DIR__.'/../fuel/packages/').DIRECTORY_SEPARATOR);
define('COREPATH', realpath(__DIR__.'/../fuel/core/').DIRECTORY_SEPARATOR);
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());
define('SITEPATH', realpath($site_path).DIRECTORY_SEPARATOR);
define('FILEPATH', realpath($file_path).DIRECTORY_SEPARATOR);


// Boot the app
require APPPATH.'bootstrap.php';

// Generate the request, execute it and send the output.
try
{
	$response = Request::forge()->execute()->response();
}
catch (HttpNotFoundException $e)
{
	$route = array_key_exists('_404_', Router::$routes) ? Router::$routes['_404_']->translation : Config::get('routes._404_');

	if($route instanceof Closure)
	{
		$response = $route();

		if( ! $response instanceof Response)
		{
			$response = Response::forge($response);
		}
	}
	elseif ($route)
	{
		$response = Request::forge($route, false)->execute()->response();
	}
	else
	{
		throw $e;
	}
}

// This will add the execution time and memory usage to the output.
// Comment this out if you don't use it.
$bm = Profiler::app_total();
$response->body(
	str_replace(
		array('{exec_time}', '{mem_usage}'),
		array(round($bm[0], 4), round($bm[1] / pow(1024, 2), 3)),
		$response->body()
	)
);

$response->send(true);

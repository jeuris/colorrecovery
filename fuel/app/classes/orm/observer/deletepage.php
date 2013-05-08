<?php
namespace Orm;

use Oil\Exception;

class Observer_Deletepage extends Observer
{
	public function before_delete(Model $page)
	{
		$pagetype = $page->get_pagetype();
		$object = $pagetype['model']::find($pagetype['target_id']);

		var_dump($object);

		try
		{
			$object->delete();
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}
}
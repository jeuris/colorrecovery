<?php
use Orm\Model;

class Model_PagesTemplates extends Model
{
	protected static $_belongs_to = array(
		'page' => array(
			'key_from' => 'page_id',
			'model_to' => 'Model_Page',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => true,
		),
	);
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
			'property' => 'created_at',
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
			'property' => 'updated_at',
		),
	);

}
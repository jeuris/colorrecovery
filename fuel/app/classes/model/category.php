<?php
use Orm\Model;

class Model_Category extends Model
{
	protected static $_has_one = array(
		'page' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Page',
			'key_to' => 'category_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		)
	);
	
	protected static $_has_many = array(
		'subcategories' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Subcategory',
			'key_to' => 'category_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		)
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
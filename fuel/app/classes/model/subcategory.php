<?php
use Orm\Model;

class Model_Subcategory extends Model
{
	protected static $_belongs_to = array(
		'category' => array(
			'key_from' => 'category_id',
			'model_to' => 'Model_Category',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_has_one = array(
		'page' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Page',
			'key_to' => 'subcategory_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'collections' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Collection',
			'key_to' => 'subcategory_id',
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
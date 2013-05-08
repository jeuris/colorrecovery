<?php

namespace Fuel\Migrations;

class Create_items
{
	public function up()
	{
		\DBUtil::create_table('items', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'category_id' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'subcategory_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'collection_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'type' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'sort' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'type' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'slug' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'created_at' => array('type' => 'timestamp', 'null' => true),
			'updated_at' => array('type' => 'timestamp', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('items');
	}
}
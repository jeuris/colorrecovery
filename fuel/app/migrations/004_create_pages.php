<?php

namespace Fuel\Migrations;

class Create_pages
{
	public function up()
	{
		\DBUtil::create_table('pages', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'slug' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'category_id' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'subcategory_id' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'collection_id' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'item_id' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'published' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'created_at' => array('type' => 'timestamp', 'null' => true),
			'updated_at' => array('type' => 'timestamp', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('pages');
	}
}
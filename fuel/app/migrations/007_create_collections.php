<?php

namespace Fuel\Migrations;

class Create_collections
{
	public function up()
	{
		\DBUtil::create_table('collections', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'category_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'subcategory_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'sort' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'slug' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'created_at' => array('type' => 'timestamp', 'null' => true),
			'updated_at' => array('type' => 'timestamp', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('collections');
	}
}
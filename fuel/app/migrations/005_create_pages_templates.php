<?php

namespace Fuel\Migrations;

class Create_pages_templates
{
	public function up()
	{
		\DBUtil::create_table('pages_templates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'page_id' => array('constraint' => 11, 'type' => 'int'),
			'template_id' => array('constraint' => 255, 'type' => 'varchar'),
			'sort' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'published' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'metadata' => array('type' => 'text', 'null' => true),
			'created_at' => array('type' => 'timestamp', 'null' => true),
			'updated_at' => array('type' => 'timestamp', 'null' => true),
		), array('id', 'page_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('pages_templates');
	}
}
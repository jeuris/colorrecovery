<?php
class Controller_Public extends Controller_Hybrid
{
	public $template = 'public/default';
	public $data	 = array();

	public function before()
	{
		$this->app_config				= Config::get('app.app_config');
		$this->filelocations 			= $this->app_config['filepath'];

		if( Input::is_ajax() )
		{
			return parent::before();
		}
		else
		{
			parent::before();

			$this->template->page_title	 = $this->app_config['name'];
			$this->template->set_global('config', $this->app_config);
			$this->template->set_global('filelocations', $this->filelocations);

			$menu = Model_Subcategory::find('all', array(
				'where'	   => array(
					'category_id' => '1',
				),
				'order_by' => array(
					'sort' => 'asc'
				),
			));
			$submenu = Model_Subcategory::find('all', array(
				'where'	   => array(
					'category_id' => '2',
				),
				'order_by' => array(
					'sort' => 'asc'
				),
			));

			//alleen nodig voor template
			$this->template->menu    = $menu;
			$this->template->submenu = $submenu;
		}

		// setup
		$this->data['menu'] = Model_Category::find('all', array(
			'order_by' => array(
				'sort' => 'asc'
			),
		));
	}
	
	public function action_index()
	{
		// doe iets
	}
	
	public function action_test()
	{
		
	}
	
	public function action_404()
	{
		// 404
	}

	public function after($response)
	{
		return parent::after($response);
	}
}
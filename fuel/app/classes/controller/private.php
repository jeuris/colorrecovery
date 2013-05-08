<?php
class Controller_Private extends Controller_Hybrid
{
	public $template 			= 'private/default';
	public $data     			= array();
	protected $filelocations	= array();
	protected $pagetypes		= array();
	protected $itemtypes		= array();
	protected $app_config;

	public function before()
	{
		//nodig voor zowel REST als template
		$permission = array($this->request->controller, $this->request->action);
		$this->app_config				= Config::get('app.app_config');
		$this->data['all_templates']	= $this->app_config['templates'];
		$this->data['page_manager']		= $this->app_config['page_manager'];
		$this->filelocations 			= $this->app_config['filepath'];
		$this->pagetypes	 			= $this->app_config['pagetypes'];
		$this->itemtypes 				= $this->app_config['itemtypes'];

		if(Input::is_ajax() )
		{
			return parent::before();
		}
		else
		{
			parent::before();

			if ( ! Auth::check() and Request::active()->action != 'login')
			{
				Response::redirect('beheer/login');
			}
			else
			{
				$this->template->page_title	  = $this->app_config['name'];
				$this->template->set_global('config', $this->app_config);
				$this->template->set_global('filelocations', $this->filelocations);

				$menu = Model_Category::find('all', array(
					'order_by' => array(
						'sort' => 'asc'
					),
				));

				$this->template->menu = $menu;

				if( Auth::check() )
				{
					$this->template->current_user = Model_User::find(Arr::get(Auth::get_user_id(), 1));
					$this->get_group();
				}
			}
		}
	}

	public function action_login()
	{
		if( Input::method() != 'POST' )
		{
			$this->template = View::forge('private/admin/login', $this->data);
			// $this->before();
		}
		else
		{
			$val = Validation::forge();
			// $val->add('email', 'E-mail of gebruikersnaam')->add_rule('required');
			// $val->add('password', 'Password')->add_rule('required');

			if ($val->run())
			{
				$auth = Auth::instance();

				if (Auth::check() or $auth->login(Input::post('email'), Input::post('password')))
				{
					Response::redirect('/beheer');
				}
				else
				{
					$this->data['login_error'] = 'Ongeldige combinatie';
					$this->template = \View::forge('private/admin/login', $this->data);
				}
			}
		}
	}

	public function action_logout()
	{
		Auth::logout();
		Response::redirect('/beheer/login');
	}

	// todo : not for production? or only groups <= 100
	public function action_reset($confirmed=0)
	{
		if($confirmed !== 0)
		{
			// list_tables not working for PDO :(
			$truncate = array('categories', 'collections', 'images', 'items', 'pages', 'pages_templates', 'subcategories');

			foreach($truncate as $t)
			{
				DBUtil::truncate_table($t);
			}

			Response::redirect('/beheer/logout');
		}
		else
		{
			$this->template->content='Alles wordt verwijderd en je wordt uitgelogd. <a href="/beheer/reset/1">Ja ja, oke...</a>';
		}

	}

	/*
	 * Protected methods
	*/
	protected function get_group()
	{
		$groupArray = \Auth::get_groups();
		$group = (int)$groupArray[0][1];
		View::set_global('user_group', $group);

		return $group;
	}

	protected function createSlug($slug, $type)
	{
		$model = $this->getModelByTemplate($type);
		$slug = strtolower( Inflector::friendly_title($slug) );
		$recurring = $model::query()
		->where('slug', 'like', $slug.'%')
		->get();

		if(count($recurring) != 0)
		{
			$slug = $slug . '-' . count($recurring);
		}
		return $slug;
	}

	protected function getModelByTemplate($template_id)
	{
		switch($template_id)
		{
			case 'collection-holder' :		
				return "Model_Collection";
			break;
			
			case 'product-holder' :
				return "Model_Item";
			break;
			case 'category' :
				return "Model_Category";
			break;
			case 'subcategory' :
				return "Model_Subcategory";
			break;
			case 'collection' :
				return "Model_Collection";
			break;
			case 'item' :
				return 'Model_Item';
			break;
			case 'text-columns' :
				return 'Model_Page';
			case 'grid' :
				return 'Model_Page';
			case 'list' :
				return 'Model_Page';
			case 'text' :
				return 'Model_Page';
		}
	}
}


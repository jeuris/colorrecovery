<?php
class Controller_Public_Page extends Controller_Public
{
	public function action_index()
	{
		$page = Model_Page::find(Config::get('app.app_config.default_page'));
		if($page)
		{
			Response::redirect('/page/view/'.$page->slug);
		}
		else
		{
			Response::redirect('404');
		}
	}

	public function action_view($slug)
	{
		if( ! Request::is_hmvc() ) // preview mode back-end
		{
			$page = Model_Page::find('first', array('where'=>array('slug'=>$slug, 'published'=>1) ) );
		}
		else
		{
			$page = Model_Page::find('first', array('where'=>array('slug'=>$slug)));
		}

		if( $page )
		{
			$this->data['page_templates'] = $page->html_array();
			$this->template->content = View::forge('public/page', $this->data);
            $this->template->script = 'List.init("' . $slug . '");';
		}
		else
		{
			$this->template->content = View::forge('public/404');
		}
	}
}
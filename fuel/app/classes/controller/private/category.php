<?php
class Controller_Private_Category extends Controller_Private
{
	public function action_index()
	{
		//self::action_add();
	}
	
	public function action_add()
	{

		if( Input::method() !== 'POST' )
		{
			$this->template->content = View::forge('private/category/create');
		}
		else
		{
			
			$category = new Model_Category;
			$category->slug = $this->createSlug(Input::post('title'), 'category');
			$category->title = Input::post('title');
			$category->save();

			$page = new Model_Page();
			$page->category_id = $category->id;
			$page->slug = $category->slug;
			$page->save();

			$template = new Model_PagesTemplates();
			$template->page_id = $page->id;
			$template->template_id = 'header';
			$template->metadata = json_encode($this->app_config['templates']['header']['default_metadata']);
			$template->save();

			Response::redirect('beheer/category');
		}
	}
	
	public function action_edit($slug=null)
	{
		//$this->data['content'] = 'Test';
	}
}
<?php
class Controller_Private_Subcategory extends Controller_Private
{
	public function before()
	{
		parent::before();
	}
	
	public function action_add($category_id=1)
	{
		$this->data['category_id']	= $category_id;
		
		if( Input::method() !== 'POST' )
		{
			$this->data['content']		= View::forge('private/page/create', $this->data);
		}
		else
		{
			$subcategory 				= new Model_subcategory();
			$subcategory->title			= Input::post('title');
			$subcategory->category_id	= $category_id;
			$subcategory->slug 			= $this->createSlug(Input::post('title'), 'subcategory');
			$subcategory->save();

			$page = new Model_Page();
			$page->category_id = $subcategory->category_id;
			$page->subcategory_id = $subcategory->id;
			$page->slug = $subcategory->slug;
			$page->save();

			$page_header = new Model_PagesTemplates();
			$page_header->page_id		= $page->id;
			$page_header->template_id	= 'header';
			$page_header->metadata		= json_encode($this->app_config['templates']['header']['default_metadata']);
			$page_header->save();

			Response::redirect('/beheer/page/edit/'.$page->id);
		}
	}
	
	public function action_delete($id)
	{
		/*
		$subcategory = Model_Subcategory::find($id);
		exit();
		
		$page 		 = Model_Page::find('first', array('where' => array('id'=>$subcategory->page_id) ) );
		
		$page->delete(false);
		$collection->delete(false);
		*/
		Response::redirect('/beheer/');
	}
}
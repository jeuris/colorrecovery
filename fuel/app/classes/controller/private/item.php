<?php
class Controller_Private_Item extends Controller_Private
{
	public function before()
	{
		parent::before();
	}
	
	public function action_add($category_id, $subcategory_id, $collection_id)
	{
		if(Input::method() == 'POST')
		{
			$item 								= new Model_Item();
			$item->category_id					= $maincollection_id;
			$item->subcategory_id				= $subcollection_id;
			$item->collection_id				= $collection_id;
			$item->title 						= Input::post('title');
			$item->sort 						= 0;
			$item->slug 						= Inflector::friendly_title(Input::post('title'));
			$item->save();

			$page = new Model_Page();
			$page->item_id = $item->id;
			$page->save();

			$page_product_detail 				= new Model_PagesTemplates();
			$page_product_detail->page_id 		= $page->id;
			$page_product_detail->template_id	= 13;
			$page_product_detail->metdata 		= json_encode($this->app_config['templates']['header']['default_metatdata']);
			$page_product_detail->save();

			Response::redirect('/beheer/page/edit/'.$page->id);
		}
		else
		{
			$this->data['content']		= View::forge('private/page/create', $this->data);			
		}
	}
	
	public function action_delete($id)
	{
		/*
		$subcollection  = Model_Subcollection::find($id);
		$page 			= Model_Page::find('first', array('where' => array('id'=>$subcollection->page_id) ) );
		
		$page->delete();
		$subcollection->delete();
		
		Response::redirect('/beheer/');
		*/
	}
}
<?php
class Controller_Private_Collection extends Controller_Private
{
	public function before()
	{
		parent::before();
	}
	
	public function action_add($maincollection_id=1)
	{
		$this->data['maincollection_id']	= $maincollection_id;
		
		if( Input::method() !== 'POST' )
		{
			$this->data['content']		= View::forge('private/page/create', $this->data);
		}
		else
		{
			$collection = new Model_Collection();
			$collection->title				= Input::post('title');
			$collection->maincollection_id	= $maincollection_id;
			$collection->save();

			$page = new Model_Page();
			$page->collection_id = $collection->id;
			$page->save();
			
			$page_header = new Model_PagesTemplates();
			$page_header->page_id		= $page->id;
			$page_header->template_id	= 'header';
			$page_header->metadata		= json_encode($this->app_config['templates']['header']['default_metatdata']);
			$page_header->save();

			Response::redirect('/beheer/page/edit/'.$page->id);
		}
	}
	
	public function action_delete($id)
	{
		$subcollection  = Model_Collection::find($id);

		$page 			= Model_Page::find('first', array('where' => array('id'=>$subcollection->page_id) ) );
		
		$page->delete();
		$subcollection->delete();
		
		Response::redirect('/beheer/');
	}
}
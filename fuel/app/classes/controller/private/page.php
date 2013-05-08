<?php
class Controller_Private_Page extends Controller_Private
{
	public function action_edit($pageid=null)
	{
		if( isset($pageid) )
		{
			$this->data['page'] = Model_Page::find($pageid, array(
				'related' => array(
					'templates' => array(
						'order_by' => 'sort',
					),
				),
			));

			$pagetype                   = $this->data['page']->get_pagetype();
			$model                      = $pagetype["model"]::find('first', array( 'where' => array('id'=>$pagetype["target_id"])));
			$this->data["pagesubject"]  = $model;
			$breadcrumb                 = $this->data['page']->get_crumb();

			$this->template->breadcrumb = $breadcrumb;
			$this->template->set_global('page_title', 'Pagina wijzigen: '.$model->title, false);
			$this->template->header 	= View::forge('private/page/editheader', $this->data);
			$this->template->content	= View::forge('private/page/edit', $this->data);
		}
	}
	public function action_addtemplate($pageid)
	{

	}

	public function action_index()
	{
		$temp = $this->app_config['templates']['header'];
		
		$template = new Model_PagesTemplates();
		
		$template->page_id		= 3;
		$template->template_id	= 'text';
		$template->metadata		= array('iets');
		$template->save();
	}
	
	public function action_edittemplate($pagetemplateid=null)
	{
		if( isset($pagetemplateid) )
		{

			$pageTemplate = Model_PagesTemplates::find($pagetemplateid);

			$this->data['pagetemplate'] = $pageTemplate;
			$this->data['json']			= json_decode( $this->data['pagetemplate']->metadata, true );
			$this->data['content']		= View::forge( 'private/page/edittemplate', $this->data );
		}
	}
	
	public function action_delete($pageid)
	{
		$this->template = 'public/default';
		parent::before();

		$page = Model_Page::find($pageid);
		$page->delete();

		Response::redirect('/beheer/');
	}

	public function action_preview($slug)
	{
		$this->template = Request::forge('/page/view/' . $slug)->execute();
	}
}
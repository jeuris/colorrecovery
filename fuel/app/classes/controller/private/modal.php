<?php
class Controller_Private_Modal extends Controller_Private
{
	public function action_test()
	{

	}

	public function action_subcategory($category_id)
	{
		$data['item_id'] = $category_id;
		echo View::forge('private/modals/createsubcategory', $data);
	}

	public function action_collection($maincollection_id)
	{
		$data['item_id'] = $maincollection_id;
		echo View::forge('private/modals/createcollection', $data);
	}

	public function action_item($maincollection_id, $subcollection_id)
	{
		$data['maincollection_id'] = $subcollection_id;
		$data['subcollection_id'] = $subcollection_id;
		echo View::forge('private/modals/createitem', $data);
	}

	public function action_templatepicker($page_id)
	{
		$page = Model_Page::find($page_id);
		$allowed_set = false;

		$pageType = $page->get_pagetype();

		switch ($pageType["type"]) {
			case 'category':

				$category = Model_Category::find('first', array('where' => array('id' => $pageType["target_id"])));

				$templates = $this->templateselector($category);
				break;

			case 'subcategory':
				$subcategory = Model_Subcategory::find('first', array('where' => array('id' => $pageType["target_id"])));
				$category = $subcategory->category;

				$templates = $this->templateselector($category, $subcategory);
				break;

			case 'collection':

				$collection = Model_Collection::find('first', array('where' => array('id' => $pageType["target_id"])));
				$subcategory = $collection->subcategory;
				$category = $collection->category;

				$templates = $this->templateselector($category, $subcategory, $collection);
				break;
		}

		$data['page_id'] = $page_id;
		$data['all_templates'] = $templates;

		echo View::forge('private/modals/templatepicker', $data);
	}

	public function action_imagecropper($image_id, $template_id, $item_id=-1)
	{
		$page_template = Model_PagesTemplates::find($template_id);
		$templateTitle = $page_template->template_id;
		$config = $this->app_config['templates'][$templateTitle];

		$data['template_id'] = $template_id;
		$data['item_id'] = $item_id;
		$data['filelocations'] = $this->filelocations;
		$data['image'] = Model_Image::find($image_id);
		$data['image_id'] = $image_id;
		$data['page_template'] = $page_template;
		$data['config'] = $config;
		echo View::forge('private/modals/imagecropper', $data);
	}

	public function action_linkcreator($pages_template_id, $item_id)
	{
		$data['pages_template_id'] 	= $pages_template_id;
		$data['item_id'] 			= $item_id;
		$data['categories'] 		= Model_Category::find('all');
		$data['pages']		 		= Model_Page::find('all', array('where' => array('category_id' => null)));

		//get slug and type in case linked allready;
		$page_template 	= Model_PagesTemplates::find($pages_template_id);
		$metaObject 	= json_decode($page_template->metadata, false);
		
		if(isset($metaObject->items))
		{
			$items = $metaObject->items;
			$item = $items[$item_id];
			
			if(isset($item->slug))
			{	
				$data['presetSlug'] = $item->slug;
				$data['presetSlugType'] = $item->typeSlug;
			}
		}
		else
		{
			if(isset($metaObject->slug))
			{
				$data['presetSlug'] = $metaObject->slug;
				$data['presetSlugType'] = $metaObject->typeSlug;
			}
		}

		echo View::forge('private/modals/linkcreator', $data);	
	}

	private function templateselector($category, $subcategory = null, $collection = null, $product = null)
	{
		$allowed = array();
		// checkt op category level
		if(isset($category))
		{
			if(isset($this->data['page_manager'][$category->title]))
			{
				$allowed = $this->data['page_manager'][$category->title]['allowed_templates'];
			}
		}

		// override en checkt op subcategory level
		if(isset($subcategory))
		{
			if(isset($this->data['page_manager'][$category->title]['subcategories'][$subcategory->title]))
			{
				$allowed = $this->data['page_manager'][$category->title]['subcategories'][$subcategory->title]['allowed_templates'];
			}
		}

		if(isset($collection))
		{
			/*if(isset($this->data['page_manager'][$category->title]['subcategories'][$subcategory->title]))
			{
				$allowed = $this->data['page_manager'][$category->title]['subcategories'][$subcategory->title]['allowed_templates'];
			}*/
		}

		// override en checkt op product level
		if(isset($product))
		{
			
		}

		if(count($allowed) > 0)
		{
			$templates = Arr::filter_keys($this->data['all_templates'], $allowed);
		} else {
			$templates = $this->data['all_templates'];
		}

		return $templates;
	}

	private function action_linkmodal()
	{

	}

}
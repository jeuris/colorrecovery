<?php
class Controller_Private_API extends Controller_Private
{
	public function post_addtemplate()
	{
		$response = array();
		
		$template_id = Input::post('template_id');
		$page_id = Input::post('page_id');
		$temp = $this->app_config['templates'][$template_id];
		$data = $temp['default_metadata'];
		
		$last = Model_PagesTemplates::find('last', array('order_by'=>array('sort'=>'desc')));
		
		$template = new Model_PagesTemplates();
		$template->page_id		= (int)Input::post('page_id');
		$template->template_id	= Input::post('template_id');
		$template->metadata		= json_encode( $data );
		$template->sort			= ( (int)$last->sort ) + 1;
		$template->save();
		
		$response['template_name']	= $temp['title'];
		$response['template_id']	= $template->id;
        $response['admin_template'] = View::forge('private/admin/templates/sortitem', array('id'=>$template->id,'title'=>$temp['title'], 't'=>$template, 'json'=>$data, 'all_templates'=>$this->app_config['templates']))->render();
		$response['html']			= View::forge($temp['view'], array('page_template'=>$template,'json'=>$data))->render();

		return $response;
	}

	public function post_savetemplate($id, $page_id)
	{
		$response = array();
		$data	= array();
		$items	= (int)Input::post('itemcount');

		if( $items > 0 )
		{
			// hoofd keys
			foreach( $_POST as $k=>$v )
			{
				if( substr($k, 0, 4) != 'item' )
				{
					// remove whitespace
					$data[$k] = preg_replace('/\s+/', ' ', $v);
				}
			}
			
			// item keys
			$data['items'] = array();
			for( $i = 1 ; $i <= $items ; $i++ )
			{
				$item = array();

				foreach( $_POST as $k=>$v )
				{
					if( substr($k, 0, 6) == ('item'.$i.'-') )
					{
						$json_key = substr($k , 6);
						$item[$i][$json_key] = $v;
					}
					else if( substr($k, 0, 7) == ('item'.$i.'-') )
					{
						$json_key = substr($k , 7);
						$item[$i][$json_key] = $v;
					}
				}
				
				$new_item = array_values($item);

				if( isset( $new_item[0] ) )
				{
					array_push($data['items'], $new_item[0]);
				}
				else
				{
					array_push($data['items'], $item);
				}
			}

			$data = $this->checkItems($id, $page_id, $data);
			
			$response['data'] = $data;
			
			/*
			// todo: send back link ids (link button)
			if( array_key_exists('id', $data['items'][0]) )
			{
				$ids = $this->getIds($page_id);
				$response['ids'] = $ids;
			}
			*/
		}
		else
		{
			$data = Input::post();
		}

		$template = Model_PagesTemplates::find($id);
		$template->metadata = json_encode($data);
		$template->save();
		
		return $response;
	}

	public function post_removetemplateitem($pagetemplate, $index)
	{
		return array("message" => $pagetemplate); // todo : ??
		
		$response	= array();
		$template	= Model_PagesTemplates::find($pagetemplate);
		$data		= json_decode( $template->metadata, true );
		$slug  		= $data['items'][$index]['slug'];
		$model		= $this->getModelByTemplate($template->template_id);
		$data		= $model::find('first', array('where' => array('slug'=>$slug) ));
		$data->delete();
		
		$pageTemplate = Model_PagesTemplates::find($pagetemplate);	
		$jsonEncoded = json_decode($pageTemplate->metadata, false);
		$items = $jsonEncoded->items;

		$count = 0;
		foreach ($items as $item) 
		{
			if($item->slug == $slug)
			{
				unset($items[$count]);
				break;
			}
			$count ++;
		}
		$jsonEncoded->items = $items;
		$pageTemplate->metadata = json_encode($jsonEncoded);
		$pageTemplate->save();
		
		return $response;
	}

	public function post_updatetemplatesorting()
	{
		foreach( Input::post('positions') as $n=>$template_id )
		{
			$template = Model_PagesTemplates::find($template_id);
			$template->sort = $n;
			$template->save();
		}
	}
	
	public function post_deletetemplate($id)
	{
		$response = array();
		$template = Model_PagesTemplates::find($id);
		$template->delete(false);
		
		$response['message'] = 'Deleted pagetemplate '.$id;
	}
	
	public function post_editmaincollection($id)
	{
		$collection = Model_Subcategory::find($id);
		$collection->title = Input::post('title');
		$collection->save();
		
		$response['message'] = 'edited: '.$id;
		return $response;
	}
	
	public function post_deletepage($id)
	{
		$response = array();
		$page = Model_Page::find($id);
		$page->delete();
		
		$response['message'] = 'Deleted page '.$id;
	}

	public function post_editexistingimage()
	{
		$x1	= 				(int)Input::post('x1');
		$x2	= 				(int)Input::post('x2');
		$y1	= 				(int)Input::post('y1');
		$y2	= 				(int)Input::post('y2');
		$fullWidth = 		(int)Input::post('fullWidth');
		$fullHeight = 		(int)Input::post('fullHeight');
		$thumbWidth = 		(int)Input::post('thumbWidth');
		$thumbHeight = 		(int)Input::post('thumbHeight');
		$template_id = 		(int)Input::post('template_id');
		$image_id = 		(int)Input::post('image_id');
		$item_id = 			(int)Input::post('item_id');

		$image = 			Model_Image::find($image_id);
		$url = 				$image->url;

		$imgpath = SITEPATH . 'public/files/';
		
		Image::load($imgpath . 'temp/' . $url)
		->crop($x1, $y1, $x2, $y2)
		->crop_resize($fullWidth, $fullHeight)
		->save($imgpath . 'full/' . $url);

		if(isset($thumbWidth) && $thumbWidth> 0)
		{
			Image::load($imgpath . 'temp/' . $url)
			->crop($x1, $y1, $x2, $y2)
			->crop_resize($thumbWidth, $thumbHeight)
			->save($imgpath . 'thumb/' . $url);
		}
		
		$response['x1'] = $x1;
		$response['x2'] = $x2;
		$response['y1'] = $y1;
		$response['y2'] = $y2;
		$response['fullWidth'] = $fullWidth;
		$response['fullHeight'] = $fullHeight;
		$response['thumbWidth'] = $thumbWidth;
		$response['thumbHeight'] = $thumbHeight;
		$response['path'] = $imgpath . $url;
		
		return $response;
	}

	public function post_addnewimage()
	{
		$item_id = Input::post('item_id');
		$template_id = Input::post('template_id');

		$config = array(
            'path' => SITEPATH.'public/files/temp/',
            'randomize' => true,
            'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
        );


        Upload::process($config);
		
        if (Upload::is_valid())
        {
            Upload::save();

            $images = Upload::get_files();
            $image = new Model_Image();
	        $image->title = "test";
	        $image->url = $images[0]["saved_as"];
	        $image->save();

	        //save thumb
	        $imgpath = SITEPATH . 'public/files/';
	        $fullWidth = Input::post('fullWidth');
	        $fullHeight = Input::post('fullHeight');
	        $thumbWidth = Input::post('thumbWidth');
	        $thumbHeight = Input::post('thumbHeight');
		
			if(isset($fullWidth))
			{
				Image::load($imgpath . 'temp/' . $image->url)
				->crop_resize($fullWidth, $fullHeight)
				->save($imgpath . 'full/' . $image->url);
			}
			if(isset($thumbWidth))
			{
				Image::load($imgpath . 'temp/' . $image->url)
				->crop_resize($thumbWidth, $thumbHeight)
				->save($imgpath . 'thumb/' . $image->url);
			}

	        if(isset($template_id) && $template_id >= 0)
	        {
	        	$pt = Model_PagesTemplates::find($template_id);
				$meta = $pt->metadata;
				$json = json_decode($meta);

	        	if(!isset($item_id) || $item_id == -1)
		        {
					$json->image_id = $image->id;
					$json->image_url = $images[0]["saved_as"];
		        }
		        else
		        {
					if( isset($json->items[$item_id]) )
					{
						$json->items[$item_id]->image_id  = $image->id;
						$json->items[$item_id]->image_url = $images[0]["saved_as"];
					}
					else
					{
						$item = array( "image_id"=>$image->id, "image_url"=>$images[0]["saved_as"]);
						array_push($json->items, $item);
					}
		        }

		        $pt->metadata = json_encode($json);
				$pt->save();
	        }
            return $this->response(array("images" => $images, "image_id" => $image->id));
        }
        return $this->response(array('data' => 'er ging iets mis. probeer opnieuw'));
	}

	public function post_publishpage($id)
	{
		$response = array();

		$page = Model_Page::find($id);
		$n = 1-$page->published;

		$page->published = $n;
		$page->save();

		$response['newstate'] = $page->published;

		return $response;
	}

	public function post_publishtemplate($id)
	{
		$response = array();

		$temp = Model_PagesTemplates::find($id);
		$n = 1-$temp->published;

		$temp->published = $n;
		$temp->save();

		$response['newstate'] = $temp->published;

		return $response;
	}

	// Private functions
	private function checkItems($id, $page_id, $pagedata)
	{
		$newData		= array();
		$response		= array();
		$allListItems	= $pagedata['items'];
		
		$config = Config::get('app.app_config');
		
		$page_template	= Model_PagesTemplates::find($id);
        $pageType = $page_template->page->get_pagetype();

        $metadata = $page_template->metadata;
		$metadataEncoded = json_encode($metadata, true);
		
		switch($page_template->template_id)
		{
			case "collection-holder" :
				foreach($allListItems as $k => $allListItem)
				{
					$collection = null;

					if( isset($allListItem['slug']) )
					{
						$allListItem['old_slug'] = $allListItem['slug'];
						$collection = Model_Collection::find('first', array('where' => array('slug' => $allListItem['slug'])));
					}
					
					if(isset($collection) && $collection != null)
					{
						if($collection->title != $allListItem['title'])
						{	
							$collection->title = $allListItem['title'];
							$collection->slug  = $this->createSlug($allListItem['title'], $page_template->template_id);
							$collection->save();
						}
					}
					else
					{
						$collection 				= new Model_Collection();
						$collection->category_id 	= $pageType["category_id"];
						$collection->subcategory_id = $pageType["subcategory_id"];
						$collection->title 			= $allListItem['title'];
						$collection->sort 			= 0;
						$collection->slug 			= $this->createSlug($allListItem['title'], $page_template->template_id);
						$collection->save();

						$page = new Model_Page();
						$page->category_id = $pageType["category_id"];
						$page->subcategory_id = $pageType["subcategory_id"];
						$page->collection_id = $collection->id;
						$page->slug = $collection->slug;
						$page->save();
						
						$page_header = new Model_PagesTemplates();
						$page_header->page_id		= $page->id;
						$page_header->template_id	= 'header';
						$page_header->metadata		= json_encode( $config['templates']['header']['default_metadata'] );
						$page_header->save();
						
						$product_holder = new Model_PagesTemplates();
						$product_holder->page_id		= $page->id;
						$product_holder->template_id	= 'product-holder';
						$product_holder->metadata		= json_encode( $config['templates']['product-holder']['default_metadata'] );
						$product_holder->save();
					}
					
					$allListItem['slug'] = $collection->slug;
					$allListItem['id']   = $collection->id;
					$newData[$k] = $allListItem;
				}

				$pagedata['items'] = $newData;
				return $pagedata;
				
			break;

			case "product-holder" :
				foreach($allListItems as $k => $allListItem)
				{
					$productItem = null;

					if( isset($allListItem['slug']) )
					{
						$allListItem['old_slug'] = $allListItem['slug'];
						$productItem = Model_Item::find('first', array('where' => array('slug' => $allListItem['slug'])));
					}
	
					if(isset($productItem) && $productItem != null)
					{
						if($productItem->title != $allListItem['title'])
						{	
							$productItem->title = $allListItem['title'];
							$productItem->slug  = $this->createSlug($allListItem['title'], $page_template->template_id);
							$productItem->save();
						}
					}
					else
					{
						if( ! isset($pageType["collection_id"]))
						{
							$pageType["collection_id"] = -1;
						}
						$productItem = new Model_Item();
						$productItem->category_id = $pageType["category_id"];
						$productItem->subcategory_id = $pageType["subcategory_id"];
						$productItem->collection_id = $pageType["collection_id"];
						$productItem->title = $allListItem['title'];
						$productItem->sort = 0;
						$productItem->slug = $this->createSlug($allListItem['title'], $page_template->template_id);
						$productItem->type = $this->itemtypes["product"];
						$productItem->save();
						
						$page = new Model_Page();
						$page->category_id = $pageType["category_id"];
						$page->subcategory_id = $pageType["subcategory_id"];
						$page->collection_id = $pageType["collection_id"];
						$page->item_id = $productItem->id;
						$page->slug = $productItem->slug;
						$page->save();

						$page_header = new Model_PagesTemplates();
						$page_header->page_id		= $page->id;
						$page_header->template_id	= 'header';
						$page_header->metadata		= json_encode( $config['templates']['header']['default_metadata'] );
						$page_header->save();
						
						$product_detail = new Model_PagesTemplates();
						$product_detail->page_id		= $page->id;
						$product_detail->template_id	= 'product-detail';
						$product_detail->metadata		= json_encode( $config['templates']['product-detail']['default_metadata'] );
						$product_detail->save();
					}

					$allListItem['id']		= $productItem->id;
					$allListItem['slug']	= $productItem->slug;
					$newData[$k] = $allListItem;
				}
				
				$pagedata['items'] = $newData;
				
				return $pagedata;
				
			break;
			
			default :
				return $pagedata;
		}
	}

	public function post_createnewpage()
	{
		$name 						= Input::post('name');
		$page_template_id			= Input::post('pagetemplateid');

		$item 						= new Model_Item();
		$item->title = $name;
		$item->slug = $this->createSlug($name, 'item');
		$item->save();

		$page 						= new Model_Page();
		$page->slug 				= $item->slug;
		$page->item_id 				= $item->id;
		$page->save();

		$pageTemplate 				= Model_PagesTemplates::find($page_template_id);
		$config 					= Config::get('app.app_config');
		
		$firstTemplate				= new Model_PagesTemplates();
		$firstTemplate->page_id		= $page->id;

		if($pageTemplate->template_id == 'list')
		{
			$firstTemplate->template_id		= 'list-detail';
			$firstTemplate->metadata		= json_encode( $config['templates']['list-detail']['default_metadata'] );
		}
		else
		{
			$firstTemplate->template_id		= 'header';
			$firstTemplate->metadata		= json_encode( $config['templates']['header']['default_metadata'] );
		}
		$firstTemplate->save();	

		return array("slug" => $item->slug);
	}

	public function get_pagebyitem($pagetemplate, $index=-1)
	{
		$response			= array();
		$template			= Model_PagesTemplates::find($pagetemplate);
		$data				= json_decode( $template->metadata, true );

		if($index == -1)
		{
			$slug  				= $data['slug'];
		}
		else
		{
			$slug  				= $data['items'][$index]['slug'];	
		}

		$model 				= $this->getModelByTemplate($template->template_id);
		$data 				= $model::find('first', array('where'=>array('slug'=>$slug)));
		
		//dealing with page model or other model?
		if(isset($data->page))
		{
			$response['page'] 	= $data->page->id;	
		}
		else
		{
			$response['page'] 	= $data->id;		
		}
	
		return $response;
	}

	public function post_pagebyslugandtype()
	{
		$slug 				= Input::post('slug');
		$type 				= Input::post('type');

		$response			= array();
		$model 				= $this->getModelByTemplate($type);
		$data 				= $model::find('first', array('where'=>array('slug'=>$slug) ));
		$response['page'] 	= $data->page->id;
		
		return $response;
	}

	public function get_templatemetadata($template_id, $item=false)
	{
		$response = array();
		$config   = Config::get('app.app_config.templates.'.$template_id.'.default_metadata');

		$response['cfg'] = $config;
		if($item != false)
		{
			$response['cfg'] = $config['items'][0];
		}

		return $response;
	}
}
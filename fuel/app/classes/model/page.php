<?php
use Orm\Model;

class Model_Page extends Model
{
	protected static $_belongs_to = array(
		'category' => array(
			'key_from' => 'category_id',
			'model_to' => 'Model_Category',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'subcategory' => array(
			'key_from' => 'subcategory_id',
			'model_to' => 'Model_Subcategory',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'collection' => array(
			'key_from' => 'collection_id',
			'model_to' => 'Model_Collection',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'item' => array(
			'key_from' => 'item_id',
			'model_to' => 'Model_Item',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	protected static $_has_many = array(
		'templates' => array(
			'key_from' => 'id',
			'model_to' => 'Model_PagesTemplates',
			'key_to' => 'page_id',
			'cascade_save' => false,
			'cascade_delete' => true,
			'conditions' => array(
				'order_by' => array(
					'sort' => 'ASC'
				),
			),
		)
	);
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
			'property' => 'created_at',
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
			'property' => 'updated_at',
		),
		'Orm\\Observer_Deletepage' => array(
			'events' => array('before_delete'),
	    ),
	);
	public function html()
	{
		$html   = '';
		$config = Config::get('app.app_config.templates');
		foreach($this->templates as $template)
		{
			$temp  = $config[$template->template_id];
			$data  = json_decode($template->metadata, true);
			$html .= View::forge($temp['view'], array('page_template'=>$template,'json'=>$data))->render();
		}

		return $html;
	}
	public function html_array()
	{
		$html_array = array();
		$config 	= Config::get('app.app_config.templates');
		foreach($this->templates as $template)
		{
			$temp_conf = $config[$template->template_id];
			$temp_data = json_decode($template->metadata, true);
			$temp_html = $this->clean_html(View::forge($temp_conf['view'], array('page_template'=>$template, 'json'=>$temp_data))->render());

			array_push($html_array, array(
				$template->template_id => $temp_html
				, 'updated' => $template->updated_at
				, 'data'	=> $temp_data
			));
		}
		return $html_array;
	}
	public function clean_html($html)
	{
		$stripped		= array();
		$allowed_tags	= implode('', Config::get('app.app_config.allowed_html_tags'));
		$allowed_attr	= Config::get('app.app_config.allowed_html_attributes');
		$strip_when_att = array('display:none','display:none;');

		$xml = simplexml_load_string('<root>'.str_replace('<br>','<br />',$html).'</root>', 'SimpleXMLElement', 32 | 2);
		if( $xml )
		{
			foreach ($xml->xpath('descendant::*[@*]') as $tag)
			{
				foreach( $tag->attributes() as $name=>$value)
				{
					$dom_ref = dom_import_simplexml($tag);
					if( ! in_array($name, $allowed_attr) )
					{
						$tag->attributes()->$name = '';
						$stripped[$name] = '/ '. $name .'=""/';
					}
					// strip tag completely when found in array
					if( in_array($value, $strip_when_att) )
					{
						$dom_ref->parentNode->removeChild($dom_ref);
					}
				}
			}
			$dom = new DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($xml->asXML());
			$dom->normalizeDocument();

			//$clean_html = strip_tags(preg_replace($stripped, '', $xml->asXML()), $allowed_tags);
			$clean_html = strip_tags(preg_replace($stripped, '', $xml->asXML()), $allowed_tags);

			return preg_replace("/[\r\n\t]+/", "", $clean_html);
		}
		else
		{
			return false;
		}

	}
    public function get_pagetype()
    {
        $result = array();

        if($this->item_id)
        {
            $result['model']            = "Model_Item";
            $result['type']             = "item";
            $result['item_id']          = $this->item_id;
            $result['collection_id']    = $this->collection_id;
            $result['subcategory_id']   = $this->subcategory_id;
            $result['category_id']      = $this->category_id;
            $result['target_id']        = $this->item_id;
        }
        else if($this->collection_id)
        {
            $result['model']            = "Model_Collection";
            $result['type']             = "collection";
            $result['collection_id']    = $this->collection_id;
            $result['subcategory_id']   = $this->subcategory_id;
            $result['category_id']      = $this->category_id;
            $result['target_id']        = $this->collection_id;
        }
        else if($this->subcategory_id)
        {
            $result['model']            = "Model_Subcategory";
            $result['type']             = "subcategory";
            $result['subcategory_id']   = $this->subcategory_id;
            $result['category_id']      = $this->category_id;
            $result['target_id']        = $this->subcategory_id;
        }
        else if($this->category_id)
        {
            $result['model']            = "Model_Category";
            $result['type']             = "category";
            $result['category_id']      = $this->category_id;
            $result['target_id']        = $this->category_id;
        }

        return $result;
    }

    public function get_crumb()
    {
        $crumbs = array();

        if(isset($this->category_id) && $this->category_id > 0)
        {
            $category = Model_Category::find($this->category_id);
            //$category = array('category' => Uri::base() . 'beheer/' . $cat . '/', 'slug' => $cat . '/');
            array_push($crumbs, array('title' => $category->slug, 'id' => $category->page->id));
        }

        if(isset($this->subcategory_id) && $this->subcategory_id > 0)
        {
            $subcategory = Model_Subcategory::find($this->subcategory_id);
            //$subcategory = array('subcategory' => Uri::base() . 'beheer/' . $cat . '/' . $subcat . '/', 'slug' => $subcat);
            array_push($crumbs, array('title' => $subcategory->slug, 'id' => $subcategory->page->id));
        }

        if(isset($this->collection_id)  && $this->collection_id > 0)
        {
            $collection = Model_Collection::find($this->collection_id);
            //$collection = array('collection' => Uri::base() . 'beheer/' . $cat . '/' . $subcat . '/' . $col . '/', 'slug' => $col);
            array_push($crumbs, array('title' => $collection->slug, 'id' => $collection->page->id));
        }

        if(isset($this->item_id) && $this->item_id > 0)
        {
            $item = Model_Item::find($this->item_id);
            //$item = array('item' => Uri::base() . 'beheer/' . $cat . '/' . $subcat . '/' . $col . '/' . $it . '/', 'slug' => $it);
            array_push($crumbs, array('title' => $item->slug, 'id' => $item->page->id));
        }

        return $crumbs;
    }
}
<?php
class Controller_Public_News extends Controller_Public
{
	public function action_facebook()
	{

		Package::load('social');
		$response = array();

		$config = Config::get('app.app_config.feeds.facebook');

		$facebook	= \Social\Facebook::instance();
		$posts		= $facebook->api($config['user_id'].'/posts');
		$posts 		= array_shift($posts);

		$items = array();
		foreach($posts as $post)
		{
			$item = array();

			switch( $post['type'] )
			{
				case 'status' :
					$item['title'] = 'Update';
					$item['body']  = htmlspecialchars( $post['story'] );
				break;

				case 'photo' :
					$item['title']		= htmlspecialchars( $post['message'] );
					//$item['body']		= htmlspecialchars( $post['story'] );
					$item['image_id']	= 'fb';
					$item['image_url']	= $post['picture'];
				break;

				case 'video' :
					//
				break;

				case 'link' :
					//
				break;

			}
			array_push($items, $item);
		}


		//return $this->response( array('feed'=>$posts) );
		return json_encode($items);
	}
}
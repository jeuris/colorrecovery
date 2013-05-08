<?php
class Controller_Public_API extends Controller_Rest
{
	public function get_page($id=1)
	{
		$page = Model_Page::find($id, array(
			'related' => array(
				'templates' => array(
					'order_by' => 'sort',
				),
			),
		));
		
		$templates		= $page->templates;
		$page_content	= array('title'=>$page->title);
		
		$page_parts	  = array();
		foreach( $templates as $template )
		{
			$data = array('json' => json_decode($template->metadata, true));
			$html = View::forge($template->template->view, $data)->render();
			
			array_push($page_parts, $html);
		}
		
		$page_content['parts'] = $page_parts;
		
		return $page_content;
	}

	public function get_image($id)
	{
		$model_image = Model_Image::find($id);
		return $model_image->url;
	}

	public function post_sendmail()
	{
		$response = array();

		$val = Validation::forge('email');
		$val->add_field('email', 'Email', 'required|valid_email');

		$target = strrev(str_replace('---','@', Input::post('target')));
		$from   = array(Input::post('input2')=>Input::post('input1'));
		$text   = "From: ".Input::post('input2').' ('.Input::post('input1').")\n".'Message: '.Input::post('text1');

		if( $val->run(array('email'=>Input::post('input1')))  )
		{
			Package::load('swiftmailer');
			$transport = Swift_SmtpTransport::newInstance('smtp.mxa-dev.com', 2525)
			->setUsername('info@mxa-dev.com')
			->setPassword('zr6w8684f$');
			$mailer = Swift_Mailer::newInstance($transport);

			// send
			try
			{
				$message = Swift_Message::newInstance('New message (contactform)')
					->setContentType('text/plain')
					->setFrom($from)
					->setTo($target)
					->setBody($text);
				//->addPart($txt_html, 'text/html');

				$result = $mailer->send($message);
				$response['mailresult'] = $result;

				if( $result === 1 )
				{
					$response['message'] = 'success';
				}
				else
				{
					$response['message'] = 'failed';
				}
			}
			catch( Exception $e )
			{
				$response['error']   = $e->getCode();
				$response['message'] = $e->getMessage();
			}
		}
		else
		{
			$response['error']   = 'email';
			$response['message'] = 'The email address was invalid';
		}
		return $response;
	}
}

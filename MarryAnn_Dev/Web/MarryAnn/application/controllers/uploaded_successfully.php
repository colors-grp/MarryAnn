<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class uploaded_successfully extends CI_Controller {
	public function index()
	{
		$this->load->helper('url');
		/*$response = $this->facebook->api(
				'me/objects/hitsevenapp:fanous',
				'POST',
				array(
						'app_id' => 170161316509571,
						'type' => "hitsevenapp:fanous",
						'url' => "http://samples.ogp.me/262819533910415",
						'title' => "Sample Fanous",
						'image' => "http://dev.hitseven.net/SS/h7-assets/resources/img/selfie/hitseven_logo.png",
						'description' => "test"
				)
		);*/
		
		$response = $this->facebook->api(
				'me/hitsevenapp:took_a_selfie',
				'POST',
				array(
						'fanous' => "http://samples.ogp.me/262819533910415"
				)
		);
		//print_r($response);
		
	    $this->load->view('uploaded_successfully_view');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
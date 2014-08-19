<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fanos_selfie extends CI_Controller {
	public function index()
	{
		$this->load->view('your_fanos_view');
	}
	
	function get_image(){
		$this->load->helper('form');
		$this->load->helper('url');
		
		$config['upload_path']   =   "/home/hitsevey/public_html/SS/h7-assets/resources/img/uploads/";
       	$config['allowed_types'] =   "gif|jpg|jpeg|png"; 
       	$config['max_size']      =   "5000";
      	$config['max_width']     =   "1907";
       	$config['max_height']    =   "2048";
       	$this->load->library('upload',$config);
       	$this->upload->initialize($config);
       	if(!$this->upload->do_upload()){
       		echo $this->upload->display_errors();
       	}
 
       	else{
           	$finfo=$this->upload->data();
           	$this->_createThumbnail($finfo['file_name']);
           	$data['uploadInfo'] = $finfo;
           	$data['thumbnail_name'] = $finfo['raw_name']. '_thumb' .$finfo['file_ext']; 
           	$data['flag'] = 0;

           	$this->load->view('your_fwanees_view', $data);
       	}
    }
 
    //Create Thumbnail function
 
    function _createThumbnail($filename){
 
        $config['image_library']    = "gd2";      
        $config['source_image']     = "/home/hitsevey/public_html/SS/h7-assets/resources/img/uploads/" .$filename;      
        $config['create_thumb']     = TRUE;      
        $config['maintain_ratio']   = TRUE;      
        $config['width'] = "100";      
        $config['height'] = "100";
 
        $this->load->library('image_lib',$config);
 
        if(!$this->image_lib->resize()){
            echo $this->image_lib->display_errors();
        }      
    }
    
    function get_facebook_pic(){
		$this->load->library('facebook');    	
    	// Get User ID
    	$user = $this->facebook->getUser();
 
    	if ($user) {
    	try {
    	// Get the user profile data you have permission to view
    	$user_profile = $this->facebook->api('/me');
    	
    	$albums = $this->facebook->api('/me/albums');
  
    	for($i = 0; $i < count($albums['data']); $i++){
    		$_SESSION['albums_names'][$i] = $albums['data'][$i]['name'];
    		$_SESSION['albums_ids'][$i] = $albums['data'][$i]['id'];
    	}
    	
    	} catch (FacebookApiException $e) {
    	$user = null;
    	}
    	} else {
    	die('<script>top.location.href="'.$this->facebook->getLoginUrl(array('scope' => 'user_photos')).'";</script>');
    	}
    	
    	$url = 'http://graph.facebook.com/'.$user_profile['id'].'/picture?width=231';
    	
    	$img = file_get_contents($url);
    	$fileName = '/home/hitsevey/public_html/SS/h7-assets/resources/img/uploads/'.$user_profile['id'].'.jpg';
    	$file = fopen($fileName, 'w+');
    	fputs($file, $img);
    	fclose($file);
    	
    	//flag to check the pic from fb or uploaded
    	$data['flag'] = 1;
    	$data['fb_id'] = $user_profile['id'];
    	
    	$_SESSION['fb_id'] = $user_profile['id'];
    	
    	$this->load->view('your_fwanees_view', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
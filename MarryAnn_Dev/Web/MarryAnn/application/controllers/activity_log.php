<?php 
class Activity_log extends CI_Controller {
	function show_log() {
		//Set current page
		$_SESSION['user_id'] = $this->session->userdata('account_id'); 
		$data['page'] = 'activity_view';
		$this->load->model('activity_model');
		
		// temporary hard coded ...
		$this->load->model('core_call');
		$me = $this->core_call->getMe($this->session->userdata('account_id'));
		$data['header_view']['name'] = $me->fullname;
		$data['header_view']['user_id'] = $data['main_view']['user_id'] = $_SESSION['user_id'];
		$data['header_view']['fb_id'] = $_SESSION['fb_id'];
	
		//Get Activity log for user
		$data['activity_view']['logs'] = $this->activity_model->get_log($_SESSION['user_id']);
		
		$data['name'] = $me->fullname;
		$data['fb_id'] = $_SESSION['fb_id'];
		//Load default view 
		$this->load->view('template' , $data);
	}
}
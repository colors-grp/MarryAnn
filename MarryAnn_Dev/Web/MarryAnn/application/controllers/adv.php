<?php
class adv extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('adv_model'));
	}

	function index(){
		$this->adv_model->add_adv($this->input->post('name'), $this->input->post('email'), $this->input->post('company'), $this->input->post('comment_text'));
		
		redirect($this->input->post('redirect'));
// 		$this->session->set_flashdata('redirect', $this->uri->uri_string());
// 		echo $this->uri->uri_string();
// 		redirect($this->session->flashdata('redirect'));
	}
}
?>
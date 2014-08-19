<?php
class adv_model extends CI_Model {
	function add_adv($name, $email, $company, $comment){
		$this->load->database();
		$data = array(
				'name' => $name ,
				'email' => $email ,
				'company' => $company,
				'comment' => $comment
		);
		
		$this->db->insert('tb_adv', $data);
		
	}
}
?>
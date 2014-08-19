<?php
class Guide_model extends CI_Model{
	function get_tv_guide() {
		$query = $this->db->get('tv_guide');
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}	
	function get_channels($program_id) {
		$this->db->where('show_id' , $program_id);
		$query = $this->db->get('tv_guide_detail');
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	
}
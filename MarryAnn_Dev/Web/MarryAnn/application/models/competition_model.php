<?php
class Competition_model extends CI_Model {
	function get_start_end_date($comp_id) {
		$this->db->where('id', $comp_id);
		$query = $this->db->get('competition');
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
}

<?php
class Admin_model extends CI_Model {
	function get_competitions() {
		$query = $this->db->get('competition');
		return $query;
	}
}
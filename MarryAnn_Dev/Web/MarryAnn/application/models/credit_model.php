<?php
class credit_model extends CI_Model {
        // Get daily Platfrom credit from platform_credit Table
        // Inputs: Platform id, day
        // Output: Credit
	function get_patform_credit($platform_id, $day){
            $this->db->select('*');
            $this->db->from('platform_credit');
            $this->db->where('platform_id',$platform_id);
            $this->db->where('day',$day);
            return $this->db->get->result_array();
	}
}
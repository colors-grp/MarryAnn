<?php
class Platform_model extends CI_Model{
    //Update platform type
    // Inputs: id, type.
    // Output: success flag.
    function insert($data) {
        $this->db->insert('platform_type', $data);
        return $this->db->insert_id();
    }
    
    function get_my_type(){
        $this->db->select('*');
        $this->db->from('platform_type');
        $query = $this->db->get();
        return $query->result_array();
    }
}
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
    
    // Get all platforms names
    // Input: none.
    // Output: list of platform names.
    function get_all_platforms_names(){
        $this->db->select('id, name');
        $this->db->distinct();
        $query = $this->db->get('platform_credit');
        return $query->result_array();
    }
    
    // Get platform id given its name
    // Input: platform name.
    // Output: platform id.
    function get_platform_id($name){
        $this->db->select('name');
        $this->db->distinct();
        $this->db->where('name',$name);
        $query = $this->db->get('platform_credit');
        return $query->result_array();
    }
    
    // Get row from platform_credit table given its name and its day
    // Input: platform name, day.
    // Output: credit.
    function get_platform_by_name_day($name, $day){
        $this->db->select('*');
        $this->db->where('name',$name);
        $this->db->where('day',$day);
        $query = $this->db->get('platform_credit');
        return $query->result_array();
    }
    
    // Get platform by name
    // Input: platform name.
    // Output: platform id.
    function get_platform_by_name($name){
        $this->db->select('*');
        $this->db->where('name',$name);
        $query = $this->db->get('platform_credit');
        return $query->result_array();
    }
    
    // Update platform credit table given id and data
    // Input: id, data.
    // Output: affected rows.
    function update_platform_credit($id, $day, $data){
        $this->db->where('id',$id);
        $this->db->where('day',$day);
        return $this->db->update('platform_credit',$data);
    }
}
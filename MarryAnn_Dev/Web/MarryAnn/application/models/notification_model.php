<?php
class Notification_model extends CI_Model{
    // Get current broadcast notifications notifications
    // inputs: non
    // output: array
    function get_current_broadcasts(){
        $date = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('notification');
        $this->db->where('date',$date);
        return $this->db->get->result_array();
    }
}
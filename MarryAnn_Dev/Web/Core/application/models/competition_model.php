<?php
class Competition_model extends CI_Model {
	//add new competitions to users
	function set_competition($user_id , $competition_id) {
		$tmp = array('user_id' =>  $user_id,'competition_id' => $competition_id);
		$this->db->insert('user_competition', $tmp);
	}
	
	//get all competitions of a certain user using his hit7 id
	function get_competition_by_user_id($id=NULL) {
		$this->db->where('user_id' , $id);
		$query = $this->db->get('user_competitions');
		if($query -> num_rows() > 0)
		return $query->result();
		return FALSE;
	}
	
	//get all competitions in hit7
	function get_all_competition() {
		$query = $this->db->get('competitions');
		if($query -> num_rows() > 0)
		return $query;
		return FALSE;
	}
	function get_site_url($sitecode) {
		$this->db->where('id', $sitecode);
		$this->db->select('url');
		$query = $this->db->get('competition');
		if ($query->num_rows() > 0)
			return $query->row()->url;
		return FALSE;
	}
        function get_current_competition($sitecode){
            $this->db->select('*');
            $this->db->where('id',$sitecode);
            $query = $this->db->get('competition');
            log_message('error','mo7eb competition_model get_current_competition $sitecode='.$sitecode);
            log_message('error','mo7eb competition_model get_current_competition $query='.  print_r($query,TRUE));
            if($query->num_rows() > 0){
                return $query->row(0);
            }
            return FALSE;
        }
        
        function create($data){
            $this->db->insert('competition', $data);
            return $this->db->insert_id();
        }
        
        function get_competition_by_url($url){
            log_message('error', 'get_competition_by_url $url=' . print_r($url,1));
            $this->db->select('*');
            $this->db->where('url',$url);
            $this->db->from('competition');
            $query = $this->db->get();
            log_message('error', 'get_competition_by_url $query=' . print_r($query->result_array(),1));
            return $query->result_array();
        }
        
        function update_competition_name($id, $data){
            $this->db->where('id',$id);
            $this->db->update('competition', $data);
            return $this->db->affected_rows();
        }
        
        // Assign admin to an existed competition
        function insert_admin_competition($data){
            $this->db->insert('admin_competition', $data);
            return $this->db->insert_id();
        }
        
        // Get admin competitions from admin_competition table
        function get_admin_competitions($id){
            $this->db->where('id', $id);
            $query = $this->db->get('admin_competition');
            return $query->result_array();
        }
}
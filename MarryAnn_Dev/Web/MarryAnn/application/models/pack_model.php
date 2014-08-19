<?php
class pack_model extends CI_Model {
	
	function get_pack($pack_id){
		$this->db->select('*');
		$this->db->from('pack');
		$this->db->where('pack_id', $pack_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	//insert a new pack to the user
	function add_user_pack($user_id, $pack_id, $count){
		$data = array(
			'user_id' => $user_id,
			'pack_id' => $pack_id,
			'count' => $count
		);
		$this->db->insert('user_pack', $data);
		return $this->db->affected_rows();
	}
	
	//get user packs
	function get_user_packs($user_id, $pack_id){
		$this->db->select('*');
		$this->db->from('user_pack');
		$this->db->where('user_id', $user_id);
		$this->db->where('pack_id', $pack_id);
		$query = $this->db->get()->result_array();	
		return $query;
	}
	
	//update the number of user's packs, if flag is 0 decrement the count, 1 increase the count
	function update_user_packs($user_id, $pack_id, $flag){
		$this->db->select('count');
		$this->db->from('user_pack');
		$this->db->where('user_id', $user_id);
		$this->db->where('pack_id', $pack_id);
		$query = $this->db->get();
		$count = $query->row(0)->count;
		
		if($flag == 0)
			$count--;
		elseif($flag == 1)
			$count++;
		
		$this->db->where('user_id', $user_id);
		$this->db->where('pack_id', $pack_id);
		$data = array('count' =>  $count);
		$this->db->update('user_pack' , $data);
		return $this->db->affected_rows();
	}
}
	
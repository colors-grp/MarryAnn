<?php
class credit_model extends CI_Model {
	function get_credit($user_id) {
		// Select user with facebook ID and put the record in 'query'
		$this->db->where('id', $user_id);
		$this->db->select('credit');
		$query = $this->db->get('a3m_account');
		// Get and return user credit using the ID
		foreach ($query->result() as $row)
			$credit = $row->credit;
		return $credit;
	}
	function buy_credit($user_id, $credit) {
            //this condition will happen when user is buying free card then the affected_rows will = zero then the function will return false
            if($credit == 0){
                return true;
            }
		// Select user with facebook ID and put the record in 'query'
		log_message('error', 'credit_model $user_id: '. $user_id);
                log_message('error', 'credit_model $new_credit: '. $credit);
		$this->db->where('id', $user_id);
		$this->db->select('credit');
		$query = $this->db->get('a3m_account')->row();
		// Get and return user credit using the ID
		// Update database with new credit
		$old_credit = $query->credit;
                //log_message('error', 'mo7eb credit_model $old_credit: '. $old_credit);
		$credit += $old_credit;
                //log_message('error', 'mo7eb credit_model $final_credit: '. $credit);
		$query->credit = $credit;
		$this->db->where('id', $user_id);
		$this->db->update('a3m_account', $query);
		// Khairy_25Mar integration revisit ... you removed this in the new code ...
                //log_message('error','mo7eb credit_model buy_credit $this->db->affected_rows()='.$this->db->affected_rows());
		if (($this->db->affected_rows() > 0))
			return true;
		else
			return false;
	}
}
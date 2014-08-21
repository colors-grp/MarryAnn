<?php
class Card_model extends CI_Model {
	//Get all cards in a certain category
	function get_cards_by_id($category_id) {
		$this->db->where('category_id', $category_id);
		$query = $this->db->get('card');
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}

	//Given a user id and a category , returns cards that user owns in the category
	function get_user_cards_by_id($category_id , $user_id) {
            $this->db->select('*');
            $this->db->from('user_card');
            $this->db->where('user_card.category_id' , $category_id);
            $this->db->where('user_card.user_id' , $user_id);

            $this->db->join('card', 'user_card.card_id = card.id AND user_card.category_id = card.category_id');
            $this->db->order_by('id','ASC');
            $query = $this->db->get();
            log_message('error', 'Mo7eb user cards->>>'. $category_id . '   ' . $query->num_rows());
            if($query->num_rows() > 0)
                    return $query;
            return FALSE;
	}

	//check whether user owns the card
	function own_card($cat_id , $card_id ,$user_id ) {
		$this->db->where('category_id' , $cat_id);
		$this->db->where('card_id' , $card_id);
		$this->db->where('user_id' , $user_id);
		$query = $this->db->get('user_card');
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}

	//Add card to user with status 0 (Free Status) by default
	function insert_user_card($category_id , $card_id , $user_id, $status = 0){
		$data = array(
				'user_id' => $user_id ,
				'card_id' => $card_id ,
				'category_id' => $category_id,
                                'card_state' => $status
		);
		$this->db->insert('user_card', $data);
		return $this->db->affected_rows();
	}
        
        function get_category_cards($cat_id){
            $sql = "SELECT COUNT(*) AS total FROM card WHERE category_id =". $cat_id;
            $query = $this->db->query($sql);
            return $query->row()->total;
        }
        
        function get_not_interest_cards($user_id,$cat_id){
            $sql = "SELECT * FROM card AS c  WHERE c.id NOT IN (SELECT c.id FROM card AS c, user_card AS uc WHERE c.id = uc.card_id AND uc.user_id = ".$user_id." AND c.category_id = uc.category_id AND uc.category_id = ".$cat_id.") AND c.category_id = ".$cat_id.";";
            $query = $this->db->query($sql);
            if($query != FALSE && $query->num_rows() > 0)
			return $query;
            return FALSE;
        }
        //return card from database given card id and cat id
        function get_card_name_by_id($cat_id,$card_id){
            $this->db->select('*');
            $this->db->from('card');
            $this->db->where('category_id',$cat_id);
            $this->db->where('id',$card_id);
            $query = $this->db->get();
            if($query->num_rows() > 0)
                return $query;
            return FALSE;
        }
        
        //return all cards available according to start date
        function get_available_cards($cat_id){
            $this->db->select('*');
            $this->db->from('card');
            $this->db->where('category_id',$cat_id);
            $this->db->where('start_date <= DATE_ADD(now(),INTERVAL 6 HOUR)');
            $query = $this->db->get();
            if($query->num_rows() > 0)
                return $query;
            return FALSE;
        }
        //return all cards blocked according to start date
        function get_blocked_cards($cat_id){
            $this->db->select('*');
            $this->db->from('card');
            $this->db->where('category_id',$cat_id);
            $this->db->where('start_date > DATE_ADD(now(),INTERVAL 6 HOUR)');
            $query = $this->db->get();
            if($query->num_rows() > 0)
                return $query;
            return FALSE;
        }
        function update_cards_time(){
            for($card_id=1;$card_id<36;$card_id++){
                $sql = "UPDATE `card` SET start_date = DATE_ADD(DATE_ADD(now(),INTERVAL ". ($card_id-1) * 30 ." MINUTE), INTERVAL 6 HOUR) WHERE id = ".$card_id.";";
                $this->db->query($sql);
                $sql = "UPDATE `card` SET end_date = DATE_ADD(DATE_ADD(now(),INTERVAL ". ($card_id) * 30 ." MINUTE), INTERVAL 6 HOUR) WHERE id = ".$card_id.";";
                $this->db->query($sql);
            }
        }
        // Return user's cards in 1 of 3 areas (Free, Album OR Trade Center).
        // Given card state flag with ( 0 (default) = Free, 1 = Album, Trade Center = 2).
        function get_user_cards($user_id,$card_state=0,$card_serial=0){
            $this->db->select('*');
            $this->db->from('user_card');
            $this->db->where('user_id',$user_id);
            $this->db->where('card_state',$card_state);
            if($card_serial){
                $this->db->where('card_serial',$card_serial);
            }
            return $this->db->get()->result_array();
        }
        // Remove card(s) from user cards table according to given user id and cards array
        // Only 1 card of each type
        function remove_user_cards($user_id, $cat_id, $card_id){
            $deleted = array(array());
            for($i=0; $i<count($cat_id); $i++){
                for($j=0;$j<count($card_id[$i]);$j++){
                    $this->db->where('user_id',$user_id);
                    $this->db->where('category_id',$cat_id[$i]);
                    $this->db->where('card_id',$card_id[$i][$j]);
                    $this->db->limit(1);
                    $this->db->delete('user_card');
                    $deleted[$i][$j] = $this->db->affected_rows();
                }
            }
            return $deleted;
        }
        // Update card's state and card's user given user id, cat id, card id and card state
        function update_user_card($user_id_from,$user_id_to ,$cat_id, $card_id, $card_state_from, $card_state_to){
            $this->db->where('user_id',$user_id_from);
            $this->db->where('category_id',$cat_id);
            $this->db->where('card_id',$card_id);
            $this->db->where('card_state',$card_state_from);
            $data = array(
                'user_id' => $user_id_to,
                'card_state' => $card_state_to
            );
            $this->db->update('user_card', $data);
            return $this->db->affected_rows();
        }
        // Insert new record in user_gift_cards table
        // remove card from sender cards
        // inputs: sender id, receiver id, category id, card id
        // output: number of effected rows (as a success flag)
        function insert_gift_card($sender_id, $receiver_id, $cat_id, $card_id){
            $date = date('Y-m-d H:i:s');
            $data = array(
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'category_id' => $cat_id,
                'card_id' => $card_id,
                'seen' => '0',
                'date' => $date
            );
            $this->db->insert('user_gift_cards', $data);
            return $this->db->affected_rows();
        }
        // Get user's gift records from user_gift_cards Table
        // inputs: user id
        // ouput: records of received gifts
        function get_user_gifts($user_id){
            $this->db->select('*');
            $this->db->from('user_gift_cards');
            $this->db->where('receiver_id',$user_id);
            $this->db->where('seen','0');
            return $this->db->get()->result_array();
        }
        // Update user's gift's seen flag
        // inputs: sender id, receiver id, category id, card id, date
        // output: effected rows (as a success flag)
        function update_user_gift($sender_id, $receiver_id, $cat_id, $card_id, $date){
            $this->db->where('sender_id',$sender_id);
            $this->db->where('receiver_id',$receiver_id);
            $this->db->where('category_id',$cat_id);
            $this->db->where('card_id',$card_id);
            $this->db->where('date',$date);
            $this->db->where('seen','0');
            $data = array(
                'seen' => '1'
            );
            $this->db->update('user_gift_cards',$data);
            return $this->db->affected_rows();
        }
        
        function get_user_cards_count($user_id,$card_state=0){
        	$this->db->select('count(*) as count');
        	$this->db->from('user_card');
        	$this->db->where('user_id',$user_id);
        	$this->db->where('card_state',$card_state);
        	 
        	return $this->db->get()->result_array();
        }
        
        function count_user_gifts($user_id, $date){
        	$this->db->select('count(*) as count');
        	$this->db->from('user_gift_cards');
        	$this->db->where('sender_id',$user_id);
        	$this->db->where('date',$date);
        	return $this->db->get()->result_array();
        }
        
        // Return card from database given name
        // inputs: card name.
        // outputs: card id and category id
        function get_card_by_name($card_name){
        	$this->db->select('*');
        	$this->db->from('card');
        	$this->db->where('name',$card_name);
        	$query = $this->db->get();
        	return $query->result_array();
        }
        
        function get_card_holders($card_id, $cat_id, $card_state){
        	$this->db->select('*');
        	$this->db->from('user_card');
        	$this->db->where('card_id',$card_id);
        	$this->db->where('category_id',$cat_id);
        	$this->db->where('card_state',$card_state);
        	 
        	return $this->db->get()->result_array();
        }
        
        function get_cards_score($cards_ids){
            $total = 0;
            for($i=0;$i<count($cards_ids);$i++){
                $this->db->select('price');
                $this->db->from('card');
                $this->db->where('id',$cards_ids[0]['card_id']);
                $this->db->where('category_id',$cards_ids[0]['cat_id']);
                $query = $this->db->get()->result_array();
                if(count($query)){
                    $total += $query[0]['price'];
                }
            }
            return $total;
        }
}
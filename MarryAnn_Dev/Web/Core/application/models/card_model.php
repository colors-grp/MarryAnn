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
		$query = $this->db->get();
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

	//Add card to user when card is bought
	function insert_user_card($category_id , $card_id , $user_id) {
		$data = array(
				'user_id' => $user_id ,
				'card_id' => $card_id ,
				'category_id' => $category_id
		);
		$this->db->insert('user_card', $data);
		
		// Insert new game for user
		$this->db->where('category_id', $category_id);
		$this->db->where('card_id', $card_id);
		$this->db->select('game_id');
		$query = $this->db->get('category_card_game');
		log_message('error', 'category_card_game');
		foreach ($query->result() as $row) {
			$game_id = $row->game_id;
			log_message('error', 'ele 1 ' . $game_id);
			$data = array(
					'user_id' => $user_id,
					'game_id' => $game_id,
					'score' => 0
			);
			$this->db->insert('user_game', $data);
		}
	}
	
	//Get card price
	function get_card_price($cat_id , $card_id) {
		$this->db->where('category_id' , $cat_id);
		$this->db->where('id' , $card_id);
		$query = $this->db->get('card');
		if($query->num_rows() > 0) {
			$row = $query->row();
			$ret = array();
			$ret['price'] = $row->price;
			$ret['score'] = $row->score;
			return $ret;
		}
		return false;
	}
	
	function get_available_cards($cat_id){
		$this->db->select('*');
		$this->db->from('card');
		$this->db->where('category_id',$cat_id);
		$this->db->where('start_date <= DATE_ADD(now(),INTERVAL 7 HOUR)');
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
		$this->db->where('start_date > DATE_ADD(now(),INTERVAL 7 HOUR)');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	
	// Returns a certain card's games given category and card IDs
	function get_games($cat_id, $card_id) {
		$this->db->select('*');
		$this->db->from('category_card_game');
		$this->db->where('category_id', $cat_id);
		$this->db->where('card_id', $card_id);
		$this->db->join('game' ,'game.game_id = category_card_game.game_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	
	// Get question given certain category and card IDs
	function get_questions($game_id) {
		$this->db->select('*');
		$this->db->from('game_question');
		$this->db->where('game_id', $game_id);
		$this->db->join('question' ,'question.question_id = game_question.question_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	// Update score for categories
	function update_score_mobile($account_id, $cat_id, $card_id, $score){
		// Get Game_id if exists
		$this->db->select('*');
		$this->db->from('category_card_game');
		$this->db->where('category_id', $cat_id);
		$this->db->where('card_id', $card_id);
		$this->db->join('game' ,'game.game_id = category_card_game.game_id');
		$games = $this->db->get();
		if($games->num_rows() > 0){// Check if there are any games
			$game_id = $games->row(0)->game_id; // save score in 1st game only
			$score = intval($score);
			// Calculate user's new_max score if exists and the difference to be added into user_category score
			$this->db->select('*');
			$this->db->where('max_score', 'yes');
			$this->db->where('game_id', $game_id);
			$this->db->where('user_id', $account_id);
			$old_score = $this->db->get('user_game');
			$is_max = 'yes';
			$difference = 0;
			if($old_score->num_rows() > 0){
				$difference = $score - $old_score->row(0)->score;
				if($difference < 0){$difference = 0;}
				if($score > $old_score->row(0)->score){
					$data = array('max_score' => 'no');
					$this->db->where('max_score', 'yes');
					$this->db->where('game_id', $game_id);
					$this->db->where('user_id', $account_id);
					$this->db->update('user_game', $data);
				} else {
					$is_max = 'no';
				}
			} else {
                            $difference = $score;
                        }
			$data = array('user_id' => $account_id, 'game_id' => $game_id, 'score' => $score, 'max_score' => $is_max, 'time' => gmdate("F jS,Y h:i:s a", time()));
			log_message('error','mo7eb card_model update_score_mobile $data='.  print_r($data,TRUE));
                        $this->db->insert('user_game', $data);
			// Update total score in user_category table with the $difference
			$this->db->where('user_id', $account_id);
			$this->db->where('category_id', $cat_id);
			$query = $this->db->get('user_category')->row(0);
			$total_score = $difference + $query->score;
                        log_message('error','mo7eb card_model update_score_mobile $difference='.$difference.', user_category->$query='.  print_r($query->score,TRUE));
			$data = array('score' =>  ($total_score));
			$this->db->where('user_id', $account_id);
			$this->db->where('category_id', $cat_id);
			$this->db->update('user_category', $data);
			return $total_score;
		} else {
			return -1;
		}
	}
        function get_games_ids($cat_id,$card_id){
        // Get Game_id if exists
            $this->db->select('*');
            $this->db->from('category_card_game');
            $this->db->where('category_id', $cat_id);
            $this->db->where('card_id', $card_id);
            $this->db->join('game' ,'game.game_id = category_card_game.game_id');
            $games = $this->db->get();
            return $games->result_array();
        }
        function get_object_information($game_id){
            // Get find the object information if exists
            $this->db->select('*');
            $this->db->from('game_object_positions');
            $this->db->where('game_id', $game_id);
            $info = $this->db->get();
            return $info->result_array();
        }
        function get_card($cat_id, $card_id){
        // Return card object given category_id and card_id
            $this->db->select('*');
            $this->db->from('card');
            $this->db->where('category_id', $cat_id);
            $this->db->where('id', $card_id);
            return $this->db->get()->result_array();
        }
}
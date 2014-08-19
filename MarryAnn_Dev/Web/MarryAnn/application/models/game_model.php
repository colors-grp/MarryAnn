<?php
class Game_model extends CI_Model{
	// Returns a certain card's games given category and card IDs
	function get_games($cat_id, $card_id) {
		$this->db->select('*');
		$this->db->from('category_card_game');
		$this->db->where('category_id', $cat_id);
		$this->db->where('card_id', $card_id);
		$this->db->join('game' ,'game.game_id = category_card_game.game_id');
		$query = $this->db->get();
                //log_message('error','mo7eb game_model get_games $query='.  print_r($query,TRUE));
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	// Update user total score
	function update_total_score($score) {
                if(!isset($_SESSION['current_category_id']) || !isset($_SESSION['user_id'])){
                    return -1;
                }
		$category_id = $_SESSION['current_category_id'];
		$user_id = $_SESSION['user_id'];
		$this->db->where('user_id', $user_id);
		$this->db->where('category_id', $category_id);
		$query = $this->db->get('user_category')->row();
		$total_score = $score + $query->score;
		$data = array('score' =>  ($total_score));
		$this->db->where('user_id', $user_id);
		$this->db->where('category_id', $category_id);
		$this->db->update('user_category', $data);
		return $total_score;
	}
	// Update best score for a certain user in a certain game
	function calc_score($game_id, $score) {
		$user_id = $_SESSION['user_id'];
		$this->db->select('*');
		$this->db->where('max_score', 'yes');
		$this->db->where('game_id', $game_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_game');
		$is_max = 'yes';
		$mx = 0;
		if ($query->num_rows() > 0) {
			$mx = $query->row()->score;
			$mx = intval($mx);
			$score = intval($score);
			if ($score > $mx) {
				$data = array('max_score' => 'no');
				$this->db->where('max_score', 'yes');
				$this->db->where('game_id', $game_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_game', $data);
			}
			else
				$is_max = 'no';
		}
		$data = array('user_id' => $user_id, 'game_id' => $game_id, 'score' => $score, 'max_score' => $is_max, 'time' => gmdate("F jS,Y h:i:s a", time()));
		$this->db->insert('user_game', $data);
		$mx = $score - $mx;
		if ($mx < 0)
			$mx = 0;
		return $mx;
		
	}
	function add_mcq_question($question) {
		$this->db->insert('question', $question);
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
	function is_played($game_id) {
		$user_id = $_SESSION['user_id'];
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$this->db->where ('game_id', $game_id);
		$this->db->where ('max_score', 'yes');
		$query = $this->db->get('user_game');
		if ($query->num_rows() > 0)
			return $query->row()->score;
		return '-1';
	}
	function get_puzzle_stuff($game_id) {
		$this->db->select('*');
		$this->db->where('game_id', $game_id);
		$query = $this->db->get('puzzle');
		if ($query->num_rows() > 0)
			return $query->row();
		return FALSE;
	}
        function checkAnyGames($cat_id, $card_id){
            $sql = "SELECT * FROM category_card_game AS ccg WHERE ccg.category_id=".$cat_id." AND ccg.card_id=".$card_id." LIMIT 0,1;";
            $query = $this->db->query($sql);
            return ($query->num_rows() > 0)?true:false;
        }
        // Get players best score
	function get_user_best_score($game_id, $user_id) {
		$this->db->select('*');
		$this->db->where('max_score', 'yes');
		$this->db->where('game_id', $game_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_game');
//                log_message('error','mo7eb game_model get_user_best_score $query='.print_r($query->result(),TRUE));
//                log_message('error','mo7eb game_model get_user_best_score $score='.$query->row()->score);
                if($query->num_rows() > 0){
                    return $query->row()->score;
//                    log_message('error','mo7eb game_model get_user_best_score yes');
                }
		return 0;
	}
        function get_game_words($game_id){
            $this->db->select('*');
            $this->db->where('game_id', $game_id);
            $query = $this->db->get('game_words');
            if($query->num_rows() > 0){
                return $query->row(0)->words;
            }
            return "";
        }
        function get_game_object_positions($game_id){
            $this->db->select('*');
            $this->db->where('game_id', $game_id);
            $query = $this->db->get('game_object_positions');
            return $query->result_array();
        }
/////////////////////MOBILE FUNCTIONS////////////////////////////////////////////////////////////
//        function update_score_mobile($account_id, $cat_id, $card_id, $score){
        function update_score_cat_1(){
            $account_id = 75;
            $card_id = 1;
            $score = 192;
            $cat_id = 1;
        /// Get Game_id if exists
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
                }
                $data = array('user_id' => $account_id, 'game_id' => $game_id, 'score' => $score, 'max_score' => $is_max, 'time' => gmdate("F jS,Y h:i:s a", time()));
		$this->db->insert('user_game', $data);
	    // Update total score in user_category table with the $difference
                $this->db->where('user_id', $account_id);
		$this->db->where('category_id', $cat_id);
		$query = $this->db->get('user_category')->row();
		$total_score = $difference + $query->score;
		$data = array('score' =>  ($total_score));
		$this->db->where('user_id', $account_id);
		$this->db->where('category_id', $cat_id);
		$this->db->update('user_category', $data);
                return $total_score;
            } else {
                return -1;
            }
        }
///////////////////END OFMOBILE FUNCTIONS////////////////////////////////////////////////////////
}
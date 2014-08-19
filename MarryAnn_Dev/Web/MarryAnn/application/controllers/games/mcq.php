<?php
class Mcq extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//Load models needed
		$this->load->model('game_model');
	}
	function index() {
		// Get post variables
		$card_id = $this->input->post('card_id');
		$card_name = $this->input->post('card_name');
		$game_id = $this->input->post('game_id');
		$game_type = $this->input->post('game_type');

		// Get needed Session variables
		$category_id =  $_SESSION['current_category_id'];
		$cat_name =  $_SESSION['current_category_name'];

		// Assign session variables for "update_score" function
		$_SESSION['game_id'] = $game_id;
		$_SESSION['card_id'] = $card_id;
		$this->get_mcq_questions($card_id, $card_name, $game_id);
	}
	
	function get_mcq_questions($card_id, $card_name, $game_id) {
		$category_id =  $_SESSION['current_category_id'];
		$questions = $this->game_model->get_questions($game_id);
		if ($questions != FALSE) {
			$data['questions'] = $questions;
			$ques = array();
			$choice = array(array());
			$ans = array();
			$i = 0;
			foreach ($questions->result() as $row) {
				$ques[$i] = $row->content;
				$ans[$i] = $row->correct_answer;
				$choice[$i][0] = $row->choice1;
				$choice[$i][1] = $row->choice2;
				$choice[$i][2] = $row->choice3;
				$choice[$i][3] = $row->choice4;
				$i ++;
			}
			$data['ques'] = $ques;
			$data['choice'] = $choice;
			$data['ans'] = $ans;
			$data['card_id'] = $card_id;
			$data['card_name'] = $card_name;
			$data['cat_name'] = $_SESSION['current_category_name'];
			$data['cat_id'] = $category_id;
			$data['is_played'] = $this->game_model->is_played($game_id);
			$this->load->view('games/mcq_game', $data);
		}
		else {
			echo 'Failed to load ya jaloos el 6een';
		}
	}
}
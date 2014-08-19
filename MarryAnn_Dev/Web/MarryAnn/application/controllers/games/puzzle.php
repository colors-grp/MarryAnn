<?php
class Puzzle extends CI_Controller {
	
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
		$info['cat_id'] = $category_id;
		$info['card_id'] = $card_id;
		$info['card_name'] = $card_name;
		$info['cat_name'] = $cat_name;
		$info['game_id'] = $game_id;
		$info['data'] = $this->game_model->get_puzzle_stuff($game_id);
		$this->load->view('games/puzzle_game', $info);
	}
}
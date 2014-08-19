<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_contr_mo7eb extends CI_Controller {
    function __construct() {
		parent::__construct();
                $this->load->model('scoreboard_model');
                $this->load->model('category_model');
                $this->load->model('user_model');
                $this->load->model('game_model');
                $this->load->model('card_model');
    }
    function index(){
        /*
         * adding new users into scoreboards
         */
//			    	$users = array();
//			        $query = $this->user_model->get_all_details();
//			        foreach($query->result() as $row){
//			            array_push($users,$row);
//			        }
//			        for($i=0;$i<7;$i++){
//			            $catName = $this->category_model->get_category_name_by_id($i+1);
//			            $this->scoreboard_model->emptyScores($catName);
//			            $this->scoreboard_model->dummyUsersWithDummyScores($catName,2000,$users);
//			        }
        /*
         * make every card:
         *                  open every 30 mins and ends after that in 30 mins
         */
        $this->card_model->update_cards_time();
    }
}
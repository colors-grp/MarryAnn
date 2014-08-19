<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_game_view'))
{
	function get_game_view($cat_id,$card_id,$game_id,$game_type){
		$CI =& get_instance();
            // Load needed models
                $CI->load->model('category_model');
                $CI->load->model('card_model');
                $CI->load->model('game_model');
            // Get needed variables
		$card = $CI->card_model->get_card_name_by_id($cat_id,$card_id);
                $end_date = ($card)?$card->row(0)->end_date:'2014-08-01 00:00:00';
                $card_name = ($card)?$card->row(0)->name:'';
		$cat_name =  $CI->category_model->get_category_name_by_id($cat_id);
		
            // Assign session variables for "update_score" function
		$_SESSION['game_id'] = $game_id;
		$_SESSION['card_id'] = $card_id;
            // Assign view variables
		$info['cat_id'] = $cat_id;
		$info['card_id'] = $card_id;
		$info['card_name'] = $card_name;
		$info['cat_name'] = $cat_name;
		$info['game_id'] = $game_id;
                $info['end_date'] = $end_date;
                if(!isset($_SESSION['user_id'])){
                    echo -1;
                    return;
                }
                $info['best_score'] = $CI->game_model->get_user_best_score($game_id,$_SESSION['user_id']);
                $info['size'] = $_SESSION['size'];
                $info['currentElement'] = $_SESSION['currentElement'];
                log_message('error','mo7eb game_helper get_game_view $info='.print_r($info,TRUE));
                //log_message('error','mo7eb game_helper get_game_view $end_date='.print_r($end_date,TRUE));
                //log_message('error','mo7eb game_helper get_game_view gettype($end_date)='.gettype($end_date));
//                log_message('error','mo7eb game_helper get_game_view ==='.(($game_type == 'search_word')?'TRUE':'FALSE'));
            // Check if game is puzzle or mcq
                if($game_type == 'puzzle'){
                    $info['data'] = $CI->game_model->get_puzzle_stuff($game_id);
                    $info['data']->image_name = $info['data']->image_name.'.jpg';
                    //log_message('error','mo7eb game_helper get_game_view puzzle $info='.print_r($info,TRUE));
                    $CI->load->view('games/puzzle_game', $info);
                } else if($game_type == 'mcq') {
                    $info['data'] = get_mcq_questions($card_id, $card_name, $game_id,$CI,$info['end_date'],$info['best_score']);
                } else if($game_type == '2048') {
                    $CI->load->view('games/2048_game',$info);
                } else if($game_type == 'match3') {
                    $CI->load->view('games/match3_game',$info);
                } else if($game_type == 'word_search') {
                    $info['words'] = $CI->game_model->get_game_words($game_id);
                    $CI->load->view('games/word_search_game',$info);
                } else if($game_type == 'flappy_shahryar') {
                    $CI->load->view('games/flappy_shahryar_game',$info);
                } else if($game_type == 'find_object') {
                    $positions = $CI->game_model->get_game_object_positions($game_id);
                    if(count($positions) > 0){
                        $info['width'] = $positions[0]['width'];
                        $info['left'] = $positions[0]['left'];
                        $info['top'] = $positions[0]['top'];
                        $info['bottle_top'] = $positions[0]['bottle_top'];
                        $info['description'] = $positions[0]['description'];
                    } else {
                        $info['width'] = $info['left'] = $info['top'] = $info['bottle_top'] = 0;
                    }
                    $info['is_played'] = $CI->game_model->is_played($game_id);
                    $CI->load->view('games/find_object_game',$info);
                } else {
                    return 'Wrog Game';
                }
	}
}
if(!function_exists('get_mcq_questions')){
    function get_mcq_questions($card_id, $card_name, $game_id,$CI,$end_date,$best_score) {
		$category_id =  $_SESSION['current_category_id'];
		$questions = $CI->game_model->get_questions($game_id);
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
                        $data['best_score'] = $best_score;
			$data['is_played'] = $CI->game_model->is_played($game_id);
                        $data['size'] = $_SESSION['size'];
                        $data['currentElement'] = $_SESSION['currentElement'];
                        //log_message('error','game_helper get_mcq_question $data='.print_r($data,TRUE));
                        date_default_timezone_set('Africa/Cairo');
                        if(strtotime($end_date) <= now() && $data['is_played'] != -1){
                            log_message('error','loading mcq_answers');
                            $CI->load->view('games/mcq_answers', $data);
                        } else {
                            log_message('error','loading mcq_game');
                            $CI->load->view('games/mcq_game', $data);
                        }
		}
		else {
			echo 'Failed to load ya jaloos el 6een';
		}
	}
}
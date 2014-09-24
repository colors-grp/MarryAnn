<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_credit'))
{
	function get_credit() {
		$CI =& get_instance();
		// Get facebook user ID
		$user_id = $_SESSION['user_id'];
            // Load needed model
                $CI->load->model('core_call');
		// Invoke the core to get user's credit from the database
		$credit = $CI->core_call->getUserCredit($user_id);//????
		return $credit;
	}
}
if (!function_exists('to_time_stamp')) {
	function to_time_stamp($date) {
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,10);
		$timestamp = strtotime($day . '-' . $month . '-' . $year);
		return $timestamp;
	}
}
if (!function_exists('get_competition_id')) {
	function get_competition_id() {
		return 1;
	}
}

if (!function_exists('get_user_id')) {
	function get_user_id() {
		return $_SESSION['user_id'];
	}
}
if (!function_exists('get_user_type')) {
	function get_user_type() {
		$CI =& get_instance();
		$CI->load->model('user_model');
		$query = $CI->user_model->get_user_id($_SESSION['user_id']);
		if ($query)
			return $query->type;
		return 'Undefined User Type';
	}
}

if (!function_exists('get_start_end_dates')) {
	function get_start_end_dates($competition_id) {
		$CI =& get_instance();
		$CI->load->model('competition_model');
		$query = $CI->competition_model->get_start_end_date($competition_id)->row();
		if ($query != FALSE) {
			$dates['start'] = $query->start_date;
			$dates['end'] = $query->end_date;
			return $dates;
		}
		$dates['start'] = 'No Date';
		$dates['end'] = 'No Date';
		return $dates;
	}
}
if(!function_exists('buy_credit'))
{
	function buy_credit() {

		$CI =& get_instance();
		// Check whether the user chose a value from the radio button or not

		if (isset($_POST['credit'])) {
			// Get radio button value
			$credit = $_POST['credit'];
			// Get facebook user ID
			// Set needed parameters values
			$user_id = $_SESSION['user_id'];
			$CI->core_call->buy_credit($user_id, $credit);
			$CI->load->model('activity_model');
			$CI->activity_model->insert_log( $CI->session->userdata('user_id') , 2);
		}
		$cr = 0;
		$cr = get_credit();
		echo $cr;
	}
}

if(!function_exists('take_credit'))
{
	function take_credit($value) {
		$CI =& get_instance();
		// Set needed parameters values
		$user_id = $_SESSION['user_id'];
		$credit = $value;
		$CI->core_call->buy_credit($user_id, $credit);
	}
}

if(!function_exists('buy_card'))
{
	function buy_card($user_id) {
		$CI =& get_instance();

		$card_price = intval($CI->input->post('card_price'));
            log_message('error','mo7eb credit_helper buy_card $card_price='.$card_price);
		$user_points = intval($CI->input->post('user_points'));
            log_message('error','mo7eb credit_helper buy_card $user_points='.$user_points);
		$card_id = intval($CI->input->post('card_id'));
            log_message('error','mo7eb credit_helper buy_card $card_id='.$card_id);
		$cat_id = intval($CI->input->post('cat_id'));
            log_message('error','mo7eb credit_helper buy_card $cat_id='.$cat_id);
		$card_score = intval($CI->input->post('card_score'));
            log_message('error','mo7eb credit_helper buy_card $card_score='.$card_score);
		$CI->load->model('category_model');
                $result = $CI->category_model->update_user_score_category($cat_id , $user_id,$card_score);
            log_message('error','mo7eb credit_helper buy_card $result='.  print_r($result,TRUE));

		log_message('error','credit_helper buy_card $user_points'. $user_points . ' , --------------  $card_price='. $card_price);
		if ($user_points >= $card_price) {
			//1 --> buy card
			$CI->load->model('activity_model');
			$CI->activity_model->insert_log(  $CI->session->userdata('user_id') , 1);
                    log_message('error','mo7eb credit_helper buy_card after insert_log');
			take_credit($card_price * -1);
                    log_message('error','mo7eb credit_helper buy_card after take_credit');
			$CI->load->model('card_model');
			$CI->card_model->insert_user_card($cat_id , $card_id , $user_id);
                    log_message('error','mo7eb credit_helper buy_card after insert_user_card');
			echo get_credit();
                    log_message('error','mo7eb credit_helper buy_card after get_credit()');
		}
		else
			echo -1;
	}
}
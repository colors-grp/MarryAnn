<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * Based on an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Hitcall extends REST_Controller
{
	function getFriendsIDs($fb_id)
	{
		$this->load->model('core_call');
		$objectt = $this->core_call->mobileGetCommonFacebookFriends($fb_id);
// 		log_message('error' ,'obj = '. $objectt);
		if($objectt)
		{
			$rValue = $objectt->friends_fb_ids;
			return $rValue; //log_message('error', "the rValueeee == " . $rValue);
		}
		else
			return NULL;
	}
	
	function mobileGetFacebookIDs($USER_IDs)
	{
		$this->load->model('core_call');
		log_message('error', 'amr 1111 == mobileGetFacebookIDs');
		$objectt = $this->core_call->mobileGetFacebookIDs($USER_IDs);
		log_message('error' ,'obj = '. print_r($objectt, TRUE));
		//$rValue = $objectt->friends_fb_ids;
		return $objectt; //log_message('error', "the rValueeee == " . $rValue);
	}
	
	function get_facebook_ids($fb_id)
	{
		$this->load->model('core_call');
		$objectt = $this->core_call->mobileGetCommonFacebookFriends($fb_id);
		// 		log_message('error' ,'obj = '. $objectt);
		$rValue = $objectt->friends_fb_ids;
		return $rValue; //log_message('error', "the rValueeee == " . $rValue);
	}
	
	function categories_get()
	{
		$this->load->model('category_model');
		$cats = $this->category_model->get_all_category();
		$cats_array = array();
		$i = 0;
		foreach ($cats->result() as $row) {
			$cats_array[$i]['id'] = $row->id;
			$cats_array[$i]['name'] = $row->name;
			$i++;
		}
		if($cats_array)
			$this->response($cats_array, 200); // 200 being the HTTP response code
		else
			$this->response(array('error' => 'Categories could not be found'), 404);
	}
	
	function user_get() {
		$this->load->model('user_model');
		$fb_id = $this->get('facebookId');
		$is_user = $this->user_model->is_already_registered_user($fb_id);
		$res_array = array();
		$res_array[0] = $is_user;
		$this->response($res_array , 200);
	}
	
	function credit_get() {
		$this->load->model('user_model');
		$fb_id = $this->get('facebookId');	
		$user_id = $this->user_model->get_user_id($fb_id);	
		$credit = $this->user_model->get_user_credit($user_id);	
		$res_array = array();
		$res_array['credit'] = $credit;
		$this->response($res_array, 200);
	}
	
	function buy_card_get() {
		$this->load->model('user_model');
		$this->load->model('card_model');
		$this->load->model('category_model');
		
		$fb_id = $this->get('facebookId');
		$cat_id = $this->get('catId');
		$card_id = $this->get('cardId');
		
		$user_id = $this->user_model->get_user_id($fb_id);
		
		$query = $this->card_model->own_card($cat_id , $card_id , $user_id);
		$ret = array();
		if($query != FALSE) {
			$ret['result'] = 'User already owns card';
			$this->response($ret, 200);
		}
		
		$user_credit = $this->user_model->get_user_credit($fb_id);
		$card_info = $this->card_model->get_card_price($cat_id , $card_id);
		$card_price = $card_info['price'];
		$card_score = $card_info['score'];
		
		if($user_credit < $card_price) {
			$ret['result'] = 'User have insufficient credit';
			$this->response($ret, 200);
		} 
		
		//should this go to core ?!
		//Update user credit
		$user_credit -= $card_price;
		$this->user_model->update_user_credit($user_id , $user_credit);
		
		//update user category score
		$new_user_info = $this->category_model->update_user_score_category($cat_id , $user_id , $card_score);
		
		$this->card_model->insert_user_card($cat_id , $card_id , $user_id);		
		
		$ret['result'] = 'Card purchased successfully';
		$ret['userCredit'] = $user_credit;
		$ret['newCards'] = $new_user_info['num_of_cards'];
		$ret['newScore'] = $new_user_info['score'];
		
		$this->response($ret, 200);
	}	
	
	function update_category_get() {
		$this->load->model('user_model');
		$this->load->model('category_model');
		
		$fb_id = $this->get('facebookId');
		$cat_id = $this->get('catId');
		
		$user_id = $this->user_model->get_user_id($fb_id);
		$query = $this->category_model->get_category_interst_by_userID($user_id);
		$is_already_interest = false;
		foreach ($query->result() as $row) 
			if($row->category_id == $cat_id)
				$is_already_interest = true;
		
		$ret = array();
		if($is_already_interest == true)
			$ret['success'] =  'User already has this category';
		else {
			$this->category_model->insert_user_category($cat_id , $user_id);
			$ret['success'] = 'User category added';
		}
		$this->response($ret , 200);
	}
	
	function check_dirty_get() {		
		$fb_id = $this->get('facebookId');
		$this->load->model('user_model');
		$user_id = $this->user_model->get_user_id($fb_id);
		$is_dirty = $this->user_model->is_dirty($user_id);
		if($is_dirty == false) {
			$this->response(array('status' => 'no change') , 200);
		}else {
			$this->load->model('category_model');
			$user_id = $this->user_model->get_user_id($fb_id);
			$cats = $this->category_model->get_category_interst_by_userID($user_id);
			$cats_array = array();
			$i = 0;
			$cats_array['status'] = 'change';
			foreach ($cats->result() as $row) {
				$cats_array[$i]['id'] = $row->id;
				$cats_array[$i]['name'] = $row->name;
				$cats_array[$i]['cards'] = $row->num_of_cards;
				$cats_array[$i]['score'] = $row->score;
				$i++;
			}
			$cats_array['numOfCategories'] = $i;
			$this->user_model->update_dirty($user_id);
			$this->response($cats_array, 200); 
		}	
	}
	
	function all_scoreboard_get() {
		$cat_id = $this->get('categoryId');
		$cat_name = $this->get('categoryName');
		$start = $this->get('start');
		$size = $this->get('size');
		
		$this->load->model('scoreboard_model');
		
		$active_table = $this->scoreboard_model->get_active_table($cat_id);
		$query = $this->scoreboard_model->get_all_friends_active($cat_name, $active_table, $size, $start);

		$USER_IDs = array();
// 		$query = $this->scoreboard_model->get_scoreboard($cat_id,$cat_name,$start,$size);
		if($query!= FALSE) {
			$ret = array();
			$i = 0;
			foreach ($query->result() as $row) {
				if($row->user_id != 0)
				{
					$ret[$i]['name'] = $row->user_name;
					$ret[$i]['fbid'] = "100006946093739";
					$ret[$i]['score'] = $row->score;
					$ret[$i]['rank'] = $row->rank;
					$ret[$i]['user_id'] = $row->user_id;
					array_push($USER_IDs, $row->user_id);
				}
				$i++;
			}
			$ret['size'] = $i;
			//$this->response($ret , 200);
		}
		else {
			$ret['size'] = 0;
			$this->response($ret , 200);
		}
		
		$FB_IDs = $this->mobileGetFacebookIDs(base64_encode(json_encode($USER_IDs)))->fb_ids;
		
		//echo print_r(count($FB_IDs), TRUE);
		//echo print_r($USER_IDs, TRUE);
		//echo print_r($FB_IDs, TRUE);
		
		//$info['fb_id'] = $FB_IDs;
		
		for ($i=0;$i<count($FB_IDs);$i++){
			if($FB_IDs[$i]->user_id == $ret[$i]['user_id'])
				$ret[$i]['fbid'] = $FB_IDs[$i]->fb_id;
		}
		
		$this->response($ret , 200);
	}
	
	function get_user_fb_id($user_id, $original) {
		$json = json_decode($original);
		
		$rValue = array();
		for($i = 0, $len = count($json); $i < $len; ++$i) 
			if($json[$i]->account_id == $user_id)
				return $json[$i]->fb_id;
	}
	
	function get_json_col($original) {
		if($original) {
		$json = json_decode($original);
		
		//log_message('error', 'jsoonnnnn 111== '.$json[1]->account_id);
		//log_message('error', 'jsoonnnnn2222 == '.$json[1]['account_id']);
		$rValue = array();
		for($i = 0, $len = count($json); $i < $len; ++$i) {
			array_push($rValue, $json[$i]->account_id);
		}
		//log_message('error', 'jsoonnnnn == '. print_r($rValue, TRUE));
		return $rValue;
		}
		else 
			return NULL;
	}
	
	function friends_scoreboard_get() {
		$cat_id = $this->get('categoryId');
		$cat_name = $this->get('categoryName');
		$start = $this->get('start');
		$size = $this->get('size');
		$fb_id = $this->get('facebookId');
		//$token = $this->get('token');
		$user_id = $this->get('userId');
		
		$this->load->model('scoreboard_model');
		$this->load->model('user_model');
// 		$user_id = $this->user_model->get_user_id($fb_id);
		if($user_id == FALSE) {
			$ret['error'] = 'user is not in database';
			$this->response($ret , 200);
		}
		
		$cool_friends = $this->getFriendsIDs($fb_id);
		
		/*
		 * cool_friends looks like this:
		 * 
		 * [{"fb_id":"1287496630","account_id":"10","fullname":"Nour Mohamed"},
		 * {"fb_id":"100000130552768","account_id":"11","fullname":"Heba Gamal Abu El-Ghar"},
		 * {"fb_id":"100000147991301","account_id":"12","fullname":"Mohammed Khairy"},
		 * {"fb_id":"100004980370623","account_id":"64","fullname":"Mohamed Colors"},{"fb_id":"534012208","account_id":"65","fullname":"Mostafa Saadany"},{"fb_id":"714507342","account_id":"75","fullname":"Khaled Moheb"},{"fb_id":"821250159","account_id":"84","fullname":"Mai Hussein"},{"fb_id":"842942205","account_id":"86","fullname":"Soad Hamdy"},{"fb_id":"685960645","account_id":"90","fullname":"Ahmed Moharram"},{"fb_id":"634330188","account_id":"91","fullname":"\u0645\u0647\u0640\u0640\u0640\u0627\u062c\u0645\u0640\u0640\u0640\u0627\u0644"},{"fb_id":"631392176","account_id":"92","fullname":"Sara El-Zaabalawy"},{"fb_id":"100000167610543","account_id":"113","fullname":"Hagar Abu El-ghar"}]
		 * 
		 * Each entry fyl JSON contain fb_id, account_id, and fullname ... 
		 * 
		 */
		//$friends_facebook_ids = $this->getFriendsTempWrong($fb_id, $token);
// 		print_r($friends_facebook_ids);
		
		
		$friends_ids = $this->get_json_col($cool_friends);//$this->user_model->get_hitseven_ids($friends_facebook_ids);
		
		//log_message('error', 'The array === '. $friends_ids);
		
		
		if($friends_ids != FALSE) {
			array_push($friends_ids, $user_id);

			$active_table = $this->scoreboard_model->get_active_table($cat_id);
			$query = $this->scoreboard_model->get_all_friends_active($cat_name, $active_table, $size, $start , $friends_ids);
			if($query!= FALSE) {
				$ret = array();
				$i = 0;
				foreach ($query->result() as $row) {
					$ret[$i]['name'] = $row->user_name;
					$ret[$i]['fbid'] = $this->get_user_fb_id($row->user_id, $cool_friends);
					$ret[$i]['score'] = $row->score;
					$ret[$i]['rank'] = $start+1+$i;
					$ret[$i]['overall'] = $row->rank;
					$i++;
				}
				$ret['size'] = $i;
				$this->response($ret , 200);
			}
		}
		$ret['size'] = 0;
		$this->response($ret , 200);
	}
	
	function get_friends($user_id, $token) {
		//$this->load->model(array('account/account_model'));
		//$this->load->model(array('account/account_facebook_model'));
	
		//$fb = $this->account_facebook_model->get_by_account_id($user_id);
		// Heba's beautiful code !!!!!
		//$friends_info = $this->account_facebook_model->getFriends($fb[0]->facebook_id, $fb[0]->token);
		$friends_info = $this->getFriendsTempWrong($user_id, $token);
		
// 		print_r($friends_info);
		
		$friends_ids = array();
		$cnt = 0;
		for ($i = 0 ; $i < count($friends_info['data']) ; $i++) {
			array_push($friends_ids, $friends_info['data'][$i]['id']);
// 			echo  $friends_info['data'][$i]['id'].'</br>';
			$cnt++;
		} 
		if($cnt != 0)
			return $friends_ids;
		return FALSE;
	}	
	
	/* THIS METHOD MUST BE REMOVED SOMETIME SOON */
	function getFriendsTempWrong($fb_id, $token)
	{
		$this->load->library(array('account/facebook_lib'));
	
		// Tab3an el 7aga Hard coded wy 7anroo7 fe dahya isA ...
		$facebook = new Facebook(array(
				'appId' => '352621514881126',
				'secret' =>'cd54e94fcc7509e7140def0b70fb4e59',
				'cookie' =>true
		));
	

		$facebook->setAccessToken($token);
	
		if($fb_id){
			$friends = NULL;
			try {
				$friends = $facebook->api('/me/friends');
				//log_message('error', 'account_fb_model getFriends $friends=' . print_r($friends,TRUE));
				return $friends;
			} catch (FacebookApiException $e) {
				log_message('error', 'account_fb_model getFriends catch: '.$e->getMessage());
				//echo $e->getMessage();
			}
		}
		else
			log_message('error','Could not Get Facebook ID: ');
	}
	
	function score_get() {
		$this->load->model('scoreboard_model');
		$this->load->model('user_model');
		
		$user_id = $this->get('userId');

//		$blue_score = $this->scoreboard_model->get_user_score_in_category('sallySyamak' , $user_id);
//		$orange_score = $this->scoreboard_model->get_user_score_in_category('mosalslat' , $user_id);
//		$violet_score = $this->scoreboard_model->get_user_score_in_category('manElQatel' , $user_id);
//		$green_score = $this->scoreboard_model->get_user_score_in_category('shahryar' , $user_id);
                
                $blue_score = $this->scoreboard_model->get_user_category_score(1,$user_id);
		$orange_score = $this->scoreboard_model->get_user_category_score(2,$user_id);
		$violet_score = $this->scoreboard_model->get_user_category_score(3,$user_id);
		$green_score = $this->scoreboard_model->get_user_category_score(4,$user_id);
                
                
		
		$ret['sallySyamak'] = $blue_score;
		$ret['mosalslat'] = $orange_score;
		$ret['manElQatel'] = $violet_score;
		$ret['shahryar'] = $green_score;
		
		$this->response($ret , 200);
	}
	
	function cards_status_get() {
		$cat_id = $this->get('categoryId');
                $size = $this->get('size');
		$this->load->model('card_model');
		$good = $this->card_model->get_available_cards($cat_id);
		$bad = $this->card_model->get_blocked_cards($cat_id);
		$ret = array();
		if($good != FALSE)
			foreach ($good->result() as $row)  {
				$ret[$row -> id] = "1";
                                // For Shahrayar category - a hard coded special case to return the number of story images in panels variable ...
				if($cat_id == '4') {
					$str = 'panels_'.$row->id;
					$ret[$str] = $this->story_panels_number_get($row->id,$size);
				}
                                $ret['cardname_'.$row->id] = $row->name;
		}
		if($bad != FALSE)
			foreach ($bad->result() as $row) 
				$ret[$row -> id] = "0";
		
		$this->response($ret , 200);
	}
	
	function story_panels_number_get($card_id,$size) {
// 		$card_id = $this->get('cardId');
		$this->load->helper('directory');
		$map = directory_map('./assets/cards/shahryar/'.$card_id.'/'.$size.'/story');
		return count($map);
// 		$this->response($map , 200);
	}
	
	function tv_guide_get() {
		$this->load->model('guide_model');
		$res = $this->guide_model->get_tv_guide();
		$ret = array();
		$i = 0;
		foreach ($res->result() as $row) {
			$ret[$i]['id'] = $row->id;
			$ret[$i]['name'] = $row->name;
// 			$ret[$i]['time'] = $row->time;
// 			$ret[$i]['link'] = $row->image;
// 			$ret[$i]['details'] = $row->details;
			$i++;
		}
		$ret['size'] = $i;
		$this->response($ret , 200);
	}
	
	function tv_channels_get() {
		$programId = $this->get('programId');
		$this->load->model('guide_model');
		$res = $this->guide_model->get_channels($programId);
		$ret = array();
		$i = 0;
		foreach ($res->result() as $row) {
			$ret[$i]['channel'] = $row->channel_name;
			$ret[$i]['time'] = $row->time;
			$i++;
		}
		$ret['size'] = $i;
		$this->response($ret , 200);
	}
	
	function add_new_usercategories_get(){ //($fb_id,$username,$fullname,$firstname,$lastname,$email,$birthday, $appCode){
		$this->load->model('user_model');
		$user_id = $this->get('user_id');
		$fullname = $this->get('fullname');		
		$ret = array();
		$is_registered = $this->user_model->check_user_scores($user_id);
		if(!$is_registered) {
		// Add categories to user
			$this->user_model->insert_user_category(1,$user_id);
			$this->user_model->insert_user_category(2,$user_id);
			$this->user_model->insert_user_category(3,$user_id);
			$this->user_model->insert_user_category(4,$user_id);
	
			// Add user score to all categories
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'shahryar');
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'sallySyamak');
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'mosalslat');
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'manElQatel');
			
			$ret['status'] = 'User added to scoreboard';
		}else 
			$ret['status'] = 'User already exists';
		$this->response($ret , 200);
	}
	
	function add_new_user_get(){ //($fb_id,$username,$fullname,$firstname,$lastname,$email,$birthday, $appCode){
		$this->load->model('user_model');
		$fb_id = $this->get('facebookId');
		$is_user = $this->user_model->is_already_registered_user($fb_id);
		$ret = array();
		if($is_user == FALSE) {
			$username = $this->get('username');
			$firstname = $this->get('firstname');
			$lastname = $this->get('lastname');
			$fullname = $firstname.' '.$lastname;
			$email = $this->get('email');
			$birthday = $this->get('birthday');;			
			$token = $this->get('token');
			
			// Get competition credit
			$this->load->model('account/account_details_model');
			$this->load->model('account/account_model');
			$this->load->model('account/account_facebook_model');
				
			// Create user and giving him credit from default competition credit
			$user_id = $this->account_model->create($username, $email, $birthday, 0);
			
			// Add user details
			$data['fullname'] = $fullname;
			$data['firstname'] = $firstname;
			$data['lastname'] = $lastname;
			$data['dateofbirth'] = $birthday;
			$this->account_details_model->update($user_id, $data);
			
			// Add user facebook information
			$this->account_facebook_model->insert($user_id, $fb_id, $token);
			
			
			// Add categories to user
			$this->user_model->insert_user_category(1,$user_id);
			$this->user_model->insert_user_category(2,$user_id);
			$this->user_model->insert_user_category(3,$user_id);
			$this->user_model->insert_user_category(4,$user_id);
						
			// Add user score to all categories 
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'shahryar');
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'sallySyamak');
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'mosalslat');
			$this->user_model->insert_new_user_in_scoreboards($user_id, $fullname, 'manElQatel');
			
			// Response
			$ret['res'] = "1";
			$this->response($ret , 200);
		}
		$ret['res'] = "0";
		$this->response($ret , 200);
	}
	
	function mosalslat_card_question_get() {
		$cat_id = $this->get('categoryId');
		$card_id = $this->get('cardId');
                $user_id = $this->get('userId');

		$this->load->model('card_model');
            // Get card object from database to get the end date to know when to display the answers to the user
                $card = $this->card_model->get_card($cat_id,$card_id);
		$gameId = $this->card_model->get_games($cat_id , $card_id);
		if($gameId != FALSE)
			$gameId = $gameId->row()->game_id;
		else {
			$ret ['status'] = 'This card has no game Id';
			$this->response($ret , 200);
		}
		$question = $this->card_model->get_questions($gameId);
		$ret = array();
		if($question != FALSE) {
			$i = 0;
			foreach ($question->result() as $row) {
				$ret[$i]['question'] = $row->content;
				$ret[$i]['choice1'] = $row->choice1;
				$ret[$i]['choice2'] = $row->choice2;
				$ret[$i]['choice3'] = $row->choice3;
				$ret[$i]['choice4'] = $row->choice4;
				$ret[$i]['correct_choice'] = $row->correct_answer;
				$i++;
			}
                    // Load needed model and helper
                        $this->load->helper('date');
                        $this->load->model('game_model');
                    // Get is_played flag from user_game table
                        $is_played = $this->game_model->is_played($gameId,$user_id);
                    // Set default time zone to cairo
                        date_default_timezone_set('Africa/Cairo');
                    // Check if we passed card end date
                        if(strtotime($card[0]['end_date']) <= now() && $is_played != -1){
                            $ret['answers'] = 1;
                        } else {
                            $ret['answers'] = 0;
                        }
		}else {
			$ret ['status'] = 'This game Id has no questions';
			$this->response($ret , 200);
		}
		$ret['size'] = $i;
		$ret ['status'] = 'Request performed successfully';
		$this->response($ret , 200);
	}
	
	function update_score_for_card_get() {
		$this->load->model('card_model');
		$account_id =$this->get('userId');
		$cat_id =$this->get('catId');
		$card_id =$this->get('cardId');
		$score =$this->get('score');
		$result = $this->card_model->update_score_mobile($account_id, $cat_id, $card_id, $score);
		$ret['status'] = $result;
		$this->response($ret , 200);
	}
        
        function find_object_positions_get(){
            $cat_id = $this->get('catId');
            $card_id = $this->get('cardId');
        //Load needed models
            $this->load->model('card_model');
        //Get all card games then select only the 1st game
            $games = $this->card_model->get_games_ids($cat_id,$card_id);
            if(count($games) > 0 ){
                $game_id = $games[0]['game_id'];
                $info = $this->card_model->get_object_information($game_id);
                if(count($info) > 0){
                    $data['top'] = $info[0]['top'];
                    $data['left'] = $info[0]['left'];
                    $data['width'] = $info[0]['width'];
                    $data['iphone4x'] = $info[0]['iphone4x'];
                    $data['iphone4y'] = $info[0]['iphone4y'];
                    $data['iphone5x'] = $info[0]['iphone5x'];
                    $data['iphone5y'] = $info[0]['iphone5y'];
                    $data['story'] = $info[0]['description'];
//                    $data['found_top'] = ($bg_height + $info[0]['bottle_top']) / $bg_height;
                    $this->response($data, 200);
                } else {
                    $this->response(array('error' => 'No information in this game'), 404);
                }
            }else{
                $this->response(array('error' => 'No games in this card'), 404);
            }
        }
        
        function check_mcq_played_get(){
            $cat_id = $this->get('categoryId');
            $card_id = $this->get('cardId');
            $user_id = $this->get('userId');

            $this->load->model('card_model');
        // Get card object from database to get the end date to know when to display the answers to the user
            $card = $this->card_model->get_card($cat_id,$card_id);
            $gameId = $this->card_model->get_games($cat_id , $card_id);
            if($gameId != FALSE){
                $gameId = $gameId->row()->game_id;
            // Load needed model and helper
                $this->load->helper('date');
                $this->load->model('game_model');
            // Get is_played flag from user_game table
                $is_played = $this->game_model->is_played($gameId,$user_id);
            // Set default time zone to cairo
                date_default_timezone_set('Africa/Cairo');
            // Check if we passed card end date
                if(strtotime($card[0]['end_date']) <= now() && $is_played != -1){
                    $ret['answers'] = 1;
                } else {
                    $ret['answers'] = 0;
                }
                $this->response($ret , 200);
            } else {
                    $ret ['status'] = 'This card has no game Id';
                    $this->response($ret , 200);
            }
        }
        
        function check_game_played_get(){
            $cat_id = $this->get('categoryId');
            $card_id = $this->get('cardId');
            $user_id = $this->get('userId');

            $this->load->model('card_model');
        // Get card object from database to get the end date to know when to display the answers to the user
            $gameId = $this->card_model->get_games($cat_id , $card_id);
            if($gameId != FALSE){
                $gameId = $gameId->row()->game_id;
            // Load needed model and helper
                $this->load->helper('date');
                $this->load->model('game_model');
            // Get is_played flag from user_game table
                $is_played = $this->game_model->is_played($gameId,$user_id);
            // Set default time zone to cairo
                date_default_timezone_set('Africa/Cairo');
            // Check if we passed card end date
                $ret['played'] = ($is_played==-1)?0:1;
                $this->response($ret , 200);
            } else {
                    $ret ['status'] = 'This card has no game Id';
                    $this->response($ret , 200);
            }
        }
        
        function get_user_game_score_get(){
            $cat_id = $this->get('categoryId');
            $card_id = $this->get('cardId');
            $user_id = $this->get('userId');
            $this->load->model('card_model');
        // Get card object from database to get the end date to know when to display the answers to the user
            $gameId = $this->card_model->get_games($cat_id , $card_id);
            if($gameId != FALSE){
                $gameId = $gameId->row()->game_id;
            // Load needed model and helper
                $this->load->helper('date');
                $this->load->model('game_model');
            // Get user score from user_game table
                $ret['score'] = $this->game_model->get_user_score($gameId,$user_id);
                $this->response($ret , 200);
            } else {
                    $ret ['status'] = 'This card has no game Id';
                    $this->response($ret , 200);
            }
        }
}

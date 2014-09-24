<?php

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
                $this->load->helper('card');
		$this->load->library(array('account/authentication', 'account/authorization'));
                $model = array('scoreboard_model','category_model','platform_model','core_call','session_model');
		$this->load->model($model);

		// Facebook connections are banned from Platform ...

		//$this->load->model(array('account/account_facebook_model'));
		//$this->load->model(array('facebook_utils'));
	}

	function index()
	{

		maintain_ssl();
                
                //echo 'We are here';

		$accountid = $this->input->get('accountid');
                $mode = $this->input->get('mode');
		$_SESSION['language'] = 'arabic';

		// If the user is signed in ...
		if ($this->authentication->is_signed_in())
		{
                    $mode = $this->session->userdata('mode');
                    $accountid = $this->session->userdata('account_id');
                    log_message('error', 'signed in and back home !!! account id = '. $accountid .' mode='.$mode);
                    $data['account'] = $this->core_call->get_by_id($accountid);
                    $data['account_details'] = $this->core_call->get_by_account_id($accountid);
                    if($mode == 1){ // Facebook
			$fb = json_decode($this->core_call->fb_get_by_account_id($accountid));
                        log_message('error','mo7eb home index() $fb='.  print_r($fb,TRUE));
			$_SESSION['fb_id'] = $fb[0]->facebook_id;
			log_message('error', 'redirect 3la platform, FB ID = ' . $_SESSION['fb_id']);
                    } elseif ($mode == 2){ // Twitter
                        $tw = json_decode($this->core_call->tw_get_by_account_id($accountid));
                        log_message('error','mo7eb home index() $tw='.  print_r($tw,TRUE));
                        $this->session->set_userdata('fb_id', $tw[0]->twitter_id);
			$_SESSION['fb_id'] = $tw[0]->twitter_id;
                        log_message('error', 'redirect 3la platform, TW ID = ' . $_SESSION['fb_id']);
                    } else {
                        $this->authentication->sign_out();
                        redirect('home');
                    }
//                        $fb_ids = array('503964508','1287496630','100000130552768','100000147991301','534012208','100008288062011','714507342','100005231178418','534012208', '821250159', '589150229', '580380268', '631392176', '634330188', '686740606', '100002305830180', '100002634478630', '100000167610543', '628380766', '842640084', '685960645', '828585787', '890660370', '801500509', '100000672895347', '686250625', '779900470', '896615017', '100005211378470','100007619778464', '100008351148673', '842942205', '1016382824','100008314040779','545098544','100001237441620','806355203','1754575577','100004176396136','100000141955961','1123570696','100004978659406','100008349759501','10202950961627802','100004342754999', '100005953815028', '100006296058790');
//                        if( in_array($_SESSION['fb_id'], $fb_ids))
//                        {
                            redirect('home/home_page');
//                        } else {
//                            $data['error_num'] = 1;
//                        }
		}
                //echo 'after if user is signed in' . '<br />';

		// This is true for redirections from Core ...
		if($accountid)
		{
                        $this->session->set_userdata('account_id', $accountid);
                        $this->session->set_userdata('mode', $mode);
                        log_message('error', 'back from core !!! account id = '. $accountid .' mode='.$mode);
			log_message('error', 'bevore Sign in acc id == '.$accountid);
			$this->authentication->sign_in($accountid);
		}
                //echo 'after if redirection from core'. '<br />';
                // contains top 3 users for each category
        // Get homepage top 3 ranks with thier facebook IDs
            // Get all categories from db
                $result = $this->category_model->get_all_category()->result_array();
                //echo 'after getting all categories'. '<br />';
            // Get top 3 of every category from current scoreboards
                $data['scoreboard_home_view'] = $this->scoreboard_model->get_home_page_scoreboard($result);
                //echo 'after loading home scoreboard view'. '<br />';
            // Get Facebook IDs of all users from core db
                $users_ids = array();
                for($i=0;$i<count($data['scoreboard_home_view']);$i++){
                    for($j=0;$j<count($data['scoreboard_home_view'][$i]['data']);$j++){
                        array_push($users_ids, $data['scoreboard_home_view'][$i]['data'][$j]->user_id);
                    }
                }
                //log_message('error','mo7eb home index $users_ids='.  print_r($users_ids,TRUE));
                $fb_ids = $this->core_call->getFacebookIDs($users_ids);
                $pos = 0;
                for($i=0;$i<count($data['scoreboard_home_view']);$i++){
                    for($j=0;$j<count($data['scoreboard_home_view'][$i]['data']);$j++,$pos++){
                        $data['scoreboard_home_view'][$i]['data'][$j]->fb_id = $fb_ids[$pos];
                    }
                }
                //log_message('error','mo7eb home index $fb_ids='.  print_r($fb_ids,TRUE));
            //get categories (SORTED)
		$data['sorted_cats'] = $this->scoreboard_model->get_sorted_cats();
            //Loading the current round data
                $temp = $this->platform_model->get_my_type();
                $data['sitecode'] = $temp[0]['id'];
                log_message('error','mo7eb home index() $sitecode=' . $temp[0]['id']);
            // Get top three users in every category
                for($cat_id=1;$cat_id<=4;$cat_id++){
                    //$cat_name = $this->category_model->get_category_name_by_id($cat_id);
                    //log_message('error','mo7eb home index() $cat_id='.$cat_id.' $cat_name='.$cat_name);
                    $data['category_score'][$cat_id-1] = $this->get_top_three_players($cat_id);
                }
                log_message('error','mo7eb home index() $data[category_score]='.  print_r($data['category_score'],TRUE));
            //gonna load the home view anyway ! ...
                if( stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
                        $this->load->view('pages/IE_home');
                        return;
                } elseif ($this->isMobileDevice()) {
                    $this->load->view('pages/mob_home');
                    return;
                }
                //echo 'before loading home not logged'. '<br />';
		$this->load->view('pages/Home_not_logged', $data);
                //echo 'after loading home not logged'. '<br />';
	}
        
        function home_page(){
        // Get user_id from session cuz will be used many times
            $user_id = $this->session->userdata('account_id');
            if($user_id == 0){
                $this->authentication->sign_out();
                redirect('home');
                return;
            }
            $_SESSION['user_id'] = $user_id;
        // Load needed models
            $this->load->model('scoreboard_model');
            $this->load->model('card_model');
            $this->load->model('category_model');
            $this->load->model('core_call');
        // Get categories from database
            $data['cats'] = $cats = $this->category_model->get_all_category()->result_array();
        // Get user's full name from core
            $result = json_decode($this->core_call->get_by_account_id($user_id));
            $data['user_fullname'] = $result->fullname;
        // Check user's interest categories
            $user_cats = $this->category_model->get_category_interst_by_userID($user_id);
            // make $user_cats array
                $user_cats = ($user_cats)?$user_cats->result_array():array();
        // Add not added categories to user's interest_categories and add new row in that category
            log_message('error','mo7eb home home_page $cats='.  print_r($cats,TRUE));
            log_message('error','mo7eb home home_page $user_cats='.  print_r($user_cats,TRUE));
            $this->load->helper('card');
            if(count($user_cats) < count($cats)){
                foreach($cats as $cat){
                    if(!in_array_field($cat['name'], 'name', $user_cats)){
                        $this->category_model->insert_user_category($cat['id'],$user_id);
                    //Add new row to scoarboard with zero score
//                        $rank = $this->scoreboard_model->get_total_scores($cat['name'])->row(0)->total + 1;
                        $username = $this->core_call->getMe($user_id)->fullname;
                        $this->scoreboard_model->insert_new_user($user_id, $username, $cat['name']);//, $rank);
                        $this->scoreboard_model->insert_new_user_in_scoreboards($user_id, $username, $cat['name']);//, $rank);
                    }
                }
            }
        // Get boolean array of cards been added to every category
            $data['new_cards'] = add_new_cards($user_id);
        // Get user score in every category
            $data['score'] = array();
            for($i=0;$i<count($cats);$i++){
                $data['score'][$i] = $this->scoreboard_model->get_user_category_score($cats[$i]['id'],$user_id)->row()->score;
            }
        // for testing...................................................
            //log_message('error','mo7eb home home_page $data='.  print_r($data,TRUE));
            $user_cards = array();
            $available_cards = array();
            foreach ($cats as $cat) {
                $cards = $this->card_model->get_user_cards_by_id($cat['id'],$user_id);
                array_push($user_cards, ($cards)?$cards->result_array():array());
                $cards = $this->card_model->get_available_cards($cat['id']);
                array_push($available_cards, ($cards)?$cards->result_array():array());
            }
            log_message('error','mo7eb home home_page new_cards='.print_r($data['new_cards'],TRUE));
            //log_message('error','mo7eb home home_page users_cards='.print_r($user_cards,TRUE));
            //log_message('error','mo7eb home home_page available_cards='.print_r($available_cards,TRUE));
        ///////////////////////////////////////////////////////////
        // Load home page
            if( stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') ){
                    $this->load->view('pages/IE_home');
                    return;
            } elseif ($this->isMobileDevice()) {
                $this->load->view('pages/mob_home');
                return;
            }
            $this->load->view('pages/Homepage',$data);
         
            //redirect('platform');
        }
        
        function get_top_three_players($cat_id){
        // Get current seleced category from session to load its scoreboard and Refreshing session variable
        	$cat_name = $this->category_model->get_category_name_by_id($cat_id);
        //Get top 3 plaeyrs
        	$limit = 3;
         // Get active table flag
            $active_table = $this->scoreboard_model->get_active_table($cat_id);
        	//log_message('error','mo7eb home get_top_three_players $cat_id='.$cat_id.' $cat_name='.$cat_name);
        	$top_three = $this->scoreboard_model->get_active_scoreboard($cat_id, $cat_name, $active_table , $limit);
//                $top_three['top_users']->result_array();
                $result['top_three'] = $top_three = ($top_three['top_users'])?$top_three['top_users']->result_array():array();
       	// Extract top_three ids
       		$users_ids = array();
       		foreach ($top_three as $user){
       			array_push($users_ids, $user['user_id']);
       		}
       		//log_message('error','mo7eb scoreboard get_top_three_players $users_ids='.print_r($users_ids,TRUE));
        // load needed model
        	$result['fb_ids'] = $fb_ids = $this->core_call->getFacebookIDs($users_ids);
        	//log_message('error','mo7eb scoreboard get_top_three_players $fb_ids='.print_r($fb_ids,TRUE));
        // load ajax page given $result array as parameter
                return $result;
        }
        
        function isMobileDevice(){
            $aMobileUA = array(
                '/iphone/i' => 'iPhone', 
                '/ipod/i' => 'iPod', 
                '/ipad/i' => 'iPad', 
                '/android/i' => 'Android', 
                '/blackberry/i' => 'BlackBerry', 
                '/webos/i' => 'Mobile'
            );
            //Return true if Mobile User Agent is detected
            foreach($aMobileUA as $sMobileKey => $sMobileOS){
                if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
                    return true;
                }
            }
            //Otherwise return false..  
            return false;
        }
}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Platform extends CI_Controller {
	protected $CI;
	function __construct() {
		parent::__construct();
		$this->CI =& get_instance();

		// This is a new comment 
		// Load models ...
		$this->load->model('core_call');
		$this->load->model('competition_model');
		$this->load->model('category_model');
		$this->load->model('card_model');
		$this->load->model('user_model');
                $this->load->model ( 'scoreboard_model' );

		//Load credit helper
		$this->load->helper('credit');
		
		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
		
		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array( 'session_model', 'core_call'));
		
		//Start session if it is not already started
		if (session_id() == '')
			session_start();
	}

	//A function that returns the Id and name of first category
	function get_first_category_info($interest_categories) {
		if($interest_categories != FALSE) {
			$cat_info = $interest_categories->row();
			$info['id'] =  $cat_info->id;
			$info['name'] = $cat_info->name;
			return $info;
		}
	}

	// A function that returns categories user not interseted in
	// given all categories and categories user interseted in
	function get_not_interst_categories($all_categories , $interest_categories) {
		$res = array();
		foreach ($all_categories->result() as $row) {
			$int = $interest_categories;
			$to_add = 1;
			if($int != false) {
				foreach ($int->result() as $row2)
					if($row->id == $row2->id)
					$to_add = 0;
			}

			if($to_add == 1)
				array_push($res , $row);
		}
		return $res;
	}

	// A controller proxy to helper functions needed from JavaScript ...
	function buy_credit()
	{
		buy_credit();
	}

	function buy_card()
	{
		$user_id = get_user_id();
		$result = buy_card($user_id);
                log_message('error','mo7eb platform buy_card $result='.  print_r($result,TRUE));
                echo $result;
	}

	// Get user ID ... Currently set to return a dummy value for testing ...
	function get_dashboard_info($user_id, $interset_cats) {
		if (!$interset_cats)
			return FALSE;
		$result = array();
		$i = 0;
		foreach ($interset_cats->result() as $int_cat) {
                    $viewLimit = 3; // number must be odd cuz the cur_user will be in middel
                    $cat_name = $this->category_model->get_category_name_by_id($int_cat->id);
                    $cur_rank = $this->scoreboard_model->get_user_rank($user_id, $cat_name)->row(0)->rank;
                    $total_scores = $this->scoreboard_model->get_total_scores($cat_name)->row(0)->total;
                    $difference = 1;
                    if($cur_rank == 1){
                        $difference = 0;
                    }
                    else if($cur_rank == $total_scores){
                        $difference = 2;
                    }
                    $result[$i]['users'] = $this->scoreboard_model->get_dash_ranks($user_id, $cat_name, $difference, $viewLimit);
                    $result[$i]['cat_id'] = $int_cat->id;
                    $result[$i]['cat_name'] = $int_cat->name;
                    $result[$i]['pos'] = $difference;
                    $i ++;
		}
                return FALSE;
	}

	// Entry point for Platform ...
	function index() {
//            $fb_ids = array('503964508','1287496630','100000130552768','100000147991301','534012208','100008288062011','714507342','100005231178418','534012208', '821250159', '589150229', '580380268', '631392176', '634330188', '686740606', '100002305830180', '100002634478630', '100000167610543', '628380766', '842640084', '685960645', '828585787', '890660370', '801500509', '100000672895347', '686250625', '779900470', '896615017', '100005211378470','100007619778464', '100008351148673', '842942205', '1016382824','100008314040779','545098544','100001237441620','806355203','1754575577','100004176396136','100000141955961','1123570696','100004978659406','100008349759501','10202950961627802','100004342754999', '100005953815028', '100006296058790');
//            if(!in_array($_SESSION['fb_id'], $fb_ids) || stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') || $this->isMobileDevice())
//            {
//                redirect('home');
//            }
            $this->load->library('account/authentication');
            if (!$this->authentication->is_signed_in() || !isset($_SESSION['fb_id'])) {
                    redirect('home');
            } else {
                // Get needed variables
                    $cat_id = $this->input->get('cat_id');
                    // in case of playing user
                        if(!is_numeric($cat_id) || $cat_id > 3 || $cat_id < 0){$cat_id = 0;}
                    // add 1 to cat_id
                        $cat_id++;
                    //////////////////
                    $user_id = $_SESSION['user_id'] = $this->session->userdata('account_id');
                    //$comp_id = $_SESSION['competition_id'] = get_competition_id();
//			log_message('error','Mo7eb platform index() >>>> $user_id='.$user_id.' SESSION='.$_SESSION['user_id'].' thisSession='.$this->session->userdata('account_id'));
                //////////////////////
//			$dates = get_start_end_dates($comp_id);
//			$data['main_view']['start_date'] = to_time_stamp($dates['start']);
//			$data['main_view']['end_date'] = to_time_stamp($dates['end']);
//			$data['header_view']['page'] = 'cat';
                    // temporary hard coded ...
                    $me = $this->core_call->getMe($this->session->userdata('account_id'));
//			$data['header_view']['name'] = $me->fullname;
                    $data['main_view']['name'] = $me->fullname;
                    // check whether the user is admin or not
                    //$user_type = get_user_type();
                    //$data['header_view']['is_admin'] = ($user_type == 'admin' ? true : false);
                    $data['header_view']['user_id'] = $data['main_view']['user_id'] = $user_id;

                    // Get user credit ...
                    $data['main_view']['user_points'] = get_credit();
                    //$data['main_view']['user_points'] = 0;
                    log_message('error','mo7eb platform index $user_points='.$data['main_view']['user_points']);

                    // Get User favorite categories ...
                    $interset_cats = $data['main_view']['interest_cats'] = $this->category_model->get_category_interst_by_userID($user_id);
                    // Get dashboard
//                    $dashResult = $this->get_dashboard_info($user_id, $interset_cats);
//                    if($dashResult == FALSE){
//                        $data['main_view']['dashboard'] = FALSE;
//                    } else {
//                        $data['main_view']['dashboard'] = $dashResult;
//                    }
                    // Get round dashboard info
//                        $this->load->model('round_model');
//                        $_SESSION['cur_round'] = $this->round_model->getCurrentRound($this->config->item('sitecode'));
//                        if($_SESSION['cur_round'] != FALSE){
//                            $_SESSION['cur_round'] = $_SESSION['cur_round']->row(0);
//                        }

                    // Get all categories ...
//			$all_categories = $this->category_model->get_all_category();

                    // Calculate which categories are not in Favorite panel ...
//			$data['main_view']['not_interest_cats'] = $this->get_not_interst_categories($all_categories , $data['main_view']['interest_cats']);

                    // Set the currently selected Category
//			if(!isset($_SESSION['current_category_id'] )) {
//				//Get first category info to be set in the session array
//				$first_cat = $this->get_first_category_info($data['main_view']['interest_cats']);
//
//				//Set first category ID and name only if they aren't already in session
//				$_SESSION['current_category_id'] = $first_cat['id'];
//				$_SESSION['current_category_name'] = $first_cat['name'];
//			}
                    $_SESSION['current_category_id'] = $cat_id;
                    $data['main_view']['cat_id'] = $cat_id-1;
                    $cat_name = $data['main_view']['cat_name'] = $_SESSION['current_category_name'] = $this->category_model->get_category_name_by_id($cat_id);
                    log_message('error','mo7eb platform index() $cat_id='.$cat_id.' $cat_name='.$cat_name);
                // Get user_id from session and user_name from scoreboard
                    $user_id = get_user_id();
                    $result = json_decode($this->core_call->get_by_account_id($user_id));
                    //$result->fullname = 'Sharon Amhcfeggejfc Romanwitz';
                    $pos = strpos($result->fullname, ' ',strpos($result->fullname, ' ')+1);
                    $user_fullname = substr($result->fullname, 0, ($pos)?$pos:strlen($result->fullname));
                    //log_message('error','mo7eb platform index() strpos($result->fullname, _ )='.strpos($result->fullname, ' '));
                    //log_message('error','mo7eb platform index() strpos($result->fullname, _ ,strpos($result->fullname, _ )+1) ='.strpos($result->fullname, ' ',strpos($result->fullname, ' ')+1));
                    //log_message('error','mo7eb platform index() $user_fullname='.$user_fullname);
                    $data['main_view']['user_fullname'] = $user_fullname;
                // Get user's score in every category
//                    $data['main_view']['user_score'] = array();
//                    for($i=0;$i<4;$i++){
//                        $data['main_view']['user_score'][$i] = $this->scoreboard_model->get_user_score($this->category_model->get_category_name_by_id($i+1),$user_id)->row()->score;
//                    }
                    //log_message('error','mo7eb platform index() $user_scores='.  print_r($data['main_view']['user_score'],TRUE));
                    //log_message('error','mo7eb platform index() $result='.print_r($result,TRUE));
                    //$user_name = ($result != "Unable to get user details from a3m_account_details")?$result
                    //Set session data
                    $_SESSION['user_id'] = $user_id;
                    $data['main_view']['fb_id'] = $_SESSION['fb_id'];
                    $_SESSION['card_view'] = 'list';
                    $_SESSION['current_page'] = 'market';
                // Get current user's rank and score
//                    $data['main_view']['user_rank'] = $this->scoreboard_model->get_user_rank_active($user_id, $_SESSION['current_category_name']);
                    $data['main_view']['user_score'] = $this->scoreboard_model->get_user_category_score($cat_id,$user_id);
                    $data['main_view']['user_score'] = ($data['main_view']['user_score'])?$data['main_view']['user_score']->row()->score:0;
                    //Load the template view
//			$this->load->view('template', $data);
                    $data['page'] = 'cat';
                    $this->load->view('pages/'.$data['page'], $data['main_view']);
            }
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
//        function testFunctions(){
//            $this->load->model('game_model');
//            $this->game_model->update_score_cat_1();
//        }
}
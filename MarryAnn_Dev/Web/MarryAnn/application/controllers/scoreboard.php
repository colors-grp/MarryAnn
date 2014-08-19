<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Scoreboard extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		// Load needed models
		$this->load->model('category_model');
		$this->load->model ( 'scoreboard_model' );

		//Load credit helper
		$this->load->helper('credit');
                $this->load->helper('account');
                

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));

		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array( 'session_model', 'core_call'));

	}
	
	
	//A function that returns the Id and name of first category
	function get_first_category_info($interest_categories) {
		if($interest_categories != FALSE) {
			$cat_info = $interest_categories->row(0);
			$info['id'] =  $cat_info->id;
			$info['name'] = $cat_info->name;
			return $info;
		}
	}

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
                    // Create new array with users_ids
                    $accounts_ids = array();
                    foreach($result[$i]['users']->result_array() as $recoreds){
                        array_push($accounts_ids, $recoreds['user_id']);
                    }
                    // Get User's facebook_ids
                    $result[$i]['fb_id'] = $this->core_call->getFacebookIDs($accounts_ids);
                    log_message('error','mo7eb scoreboard get_dashboard_info $result['.$i.'][fb_id]='.  print_r($result[$i]['fb_id'],TRUE));
                    //log_message('error','mo7eb scoreboard get_dashboard_info $result[$i][users]'.print_r($result[$i]['users']->result_array(),TRUE));
                    $i ++;
		}
		return $result;
	}
	function index() {

		if (!$this->authentication->is_signed_in() || !isset($_SESSION['fb_id'])) {
			redirect('home');
		} else {
			$comp_id = $_SESSION['competition_id'] = get_competition_id();
			$dates = get_start_end_dates($comp_id);
			$data['scoreboard_view']['start_date'] = to_time_stamp($dates['start']);
			$data['scoreboard_view']['end_date'] = to_time_stamp($dates['end']);

			//Set current page
			$data['page'] = 'scoreboard_view';
			$data['header_view']['page'] = 'scoreboard_view';
                        
			// check whether the user is admin or not
			$user_type = get_user_type();
			$data['header_view']['is_admin'] = ($user_type == 'admin' ? true : false);

			$this->load->model('core_call');
			$me = $this->core_call->getMe($this->session->userdata('account_id'));
			// temporary hard coded ...
			$data['header_view']['name'] = $me->fullname;
			$data['header_view']['fb_id'] = $_SESSION['fb_id'];
			$user_id = $data['header_view']['user_id'] = $data['scoreboard_view']['user_id'] = $_SESSION['user_id'];
			$data['scoreboard_view']['fb_id'] = $_SESSION['fb_id'];
			$data['scoreboard_view']['name'] = $me->fullname;

			// Get user credit ...
			$data['scoreboard_view']['user_points'] = get_credit();

			// Get User favorite categories ...
			$interset_cats = $data['scoreboard_view']['interest_cats'] = $this->category_model->get_category_interst_by_userID($_SESSION['user_id']);
			
			if(!isset($_SESSION['current_category_id'] )) {
				//Get first category info to be set in the session array
				$first_cat = $this->get_first_category_info($data['scoreboard_view']['interest_cats']);
				
				//Set first category ID and name only if they aren't already in session
				$_SESSION['current_category_id'] = $first_cat['id'];
				$_SESSION['current_category_name'] = $first_cat['name'];
			}
                        // Get dashboard
			$data['scoreboard_view']['dashboard'] = $this->get_dashboard_info($user_id, $interset_cats);
			//Set session data (current_category_id , current_category_name)
			$_SESSION ['current_page'] = 'scoreboard';
                        //log_message('error','mo7eb scoreboard index $data['friends']='.  print_r($data['friends'],TRUE));
                        
			//Load the template view
			$this->load->view('template', $data);
		}
	}

	function get_scoreboard_details() {
            $this->load->library('account/authentication');
            if (!$this->authentication->is_signed_in() || !isset($_SESSION['fb_id'])) {
                echo -1;
                return;
            }
        // reset NScrolls session variable for infinite scrolling usage
            $_SESSION['NScrolls'] = 1;
        // Get variables needed
            $all = $this->input->post('all');
            if(!isset($_SESSION['all'])){
                $_SESSION['all'] = $all = 0;
            }
            if($all == 2){
                $all = $_SESSION['all'];
            } else {
                $_SESSION['all'] = $all;
            }
        // Get current seleced category from session to load its scoreboard and Refreshing session variable
            $cat_id = $this->input->post('cat_id');
            if($cat_id > 4 || $cat_id < -1 || ($cat_id == -1 && !isset($_SESSION['current_category_id']))){ echo -1; return; }
            $_SESSION['current_category_id'] = $cat_id = ($cat_id != -1)? $cat_id : $_SESSION['current_category_id'];
        // Get category name and refresh session variable
            $_SESSION['current_category_name'] = $cat_name = $this->category_model->get_category_name_by_id($cat_id);
        // Get active table flag
            $active_table = $this->scoreboard_model->get_active_table($cat_id);
//            $active_table = ($active_table == 1)?2:1;
        //Get scoreboard contents according to current category
            $scoreboard = FALSE;
            $ret = FALSE;
            log_message('error','mo7eb scoreboard get_scoreboard_details $cat_id='.$cat_id.'typeof(cat_id)='.  gettype($cat_id));
            log_message('error','mo7eb scoreboard get_scoreboard_details $active_table ='.$active_table);
            $limit = 50;
            if($cat_id != -1){
            // Get Scoreboard rows using $cat_id and limit
                if($all){// get all players scoreboard
                    $scoreboard = $this->scoreboard_model->get_active_scoreboard($cat_id, $cat_name, $active_table , $limit);
                    log_message('error','mo7eb scoreboard $socreboard[top_users]->result() = '.  print_r($scoreboard['top_users']->result(),TRUE));
                    if(isset($scoreboard ['all']) && $scoreboard ['all'] != FALSE){
                    log_message('error','mo7eb scoreboard $socreboard[all]->result() = '.  print_r($scoreboard['all']->result(),TRUE));
                    }
                //Get all ranks according to ranks in the selected category
                    $i = 0;
                    if(isset($scoreboard ['all']) && $scoreboard ['all'] != FALSE){
                        //log_message('error','mo7eb scoreboard get_scoreboard_details $scoreboard[all]='.  print_r($scoreboard ['all'],TRUE));
                    foreach ( $scoreboard ['all']->result() as $row ) {
                            $ret ['all'] [$i] = get_object_vars($row);
                            $i ++;
                    }}
                    //Get ranks on top of each category
                    $i = 0;
                    if(isset($scoreboard ['top']) && $scoreboard ['top'] != FALSE){
                    foreach ( $scoreboard ['top']->result() as $row ) {
                            $ret['top'][$i] = get_object_vars($row);
                            $i ++;
                    }
                    }
                    //Get Top users facebook ids according to the number of ranks in the category
                    $top_users_ids = array();
                    if(isset($scoreboard ['top_users']) && $scoreboard ['top_users'] != FALSE){
                    foreach ( $scoreboard ['top_users']->result() as $row ) {
                        array_push($top_users_ids, $row->user_id);
                    }
                    }
                    //log_message('error','mo7eb scoreboard get_scoreboard_details $top_users_ids='.  print_r($top_users_ids,TRUE));
                    $ret['fb_ids'] = $this->core_call->getFacebookIDs($top_users_ids);
                    //log_message('error','mo7eb scoreboard get_scoreboard_details $ret[fb_ids]='.  print_r($ret['fb_ids'],TRUE));
                    //Get Top users according to the number of ranks in the category
                    $i = 0;
                    if(isset($scoreboard ['top_users']) && $scoreboard ['top_users'] != FALSE){
                    foreach ( $scoreboard ['top_users']->result() as $row ) {
                            $ret['top_users'][$i] = get_object_vars($row);
                            $i ++;
                    }}
                } else {// View Friends recordes
                // load needed models
                    $this->load->model('core_call');
                    // Get Current user common friends between facebook and database
                    $friends = json_decode($this->core_call->getCommonFriends($_SESSION['fb_id']));
                    $friends = ($friends)?$friends:array();
                    //log_message('error','mo7eb get_scoreboard_details $friends='.  print_r($friends,TRUE));
                    $obj = new stdClass();
                    $me = $this->core_call->getMe($_SESSION['user_id']);
                    $obj->fullname = $me->fullname;
                    $obj->fb_id = $_SESSION['fb_id'];
                    $obj->account_id = $_SESSION['user_id'];
                    array_push($friends,$obj);
//                    log_message('error','mo7eb scoreboard get_scoreboard_details $friends='.  print_r($friends,TRUE));
                    // Create new array with account ids to get thier ranks from database
                    if(count($friends) > 0){
                        $account_ids = array();
                        $i = 0;
                        foreach ($friends as $recored){
                            $account_ids[$i] = $recored->account_id;
                            $i++;
                        }
                        $account_ids[$i] = $_SESSION['user_id'];
                        // Get scoreboard of friends only Given accounts_ids, $cat_id and limit of rows
                        $cat_name = $this->category_model->get_category_name_by_id($cat_id);
                        $scoreboard = $this->scoreboard_model->get_active_scoreboard($cat_id, $cat_name, $active_table , $limit , $account_ids);
                        // Create new array with contents of all scoreboard data + fb_id and fullname
                        $i = 0;
                        foreach($scoreboard['all'] as $SRecoreds){
                            foreach ($friends as $FRecored){
                                if($SRecoreds['user_name'] == $FRecored->fullname){
                                    $scoreboard['all'][$i]['fb_id'] = $FRecored->fb_id;
                                    break;
                                }
                            }
                            $i++;
                        }
                        //log_message('error','mo7eb scoreboard get_scoreboard_details $scoreboard[all]='.  print_r($scoreboard['all'],TRUE));
                        //Get all ranks according to ranks in the selected category
                        $i = 0;
                        foreach ( $scoreboard ['all'] as $row ) {
                                $ret ['all'] [$i] = $row;
                                $i ++;
                        }
                        //Get ranks on top of each category
                        $i = 0;
                        foreach ( $scoreboard ['top']->result () as $row ) {
                                $ret['top'][$i] = get_object_vars($row);
                                $i ++;
                        }
                    }
                }
            }

            //Set session data
            $_SESSION ['user_data'] = $ret;
            $_SESSION ['current_page'] = 'scoreboard';
            $_SESSION ['all'] = $all;

            //log_message('error','mo7eb scoreboard get_scoreboard_details $ret = '.  print_r($ret,TRUE));

            //Load scoreboard ajax view
            $this->load->view ( 'ajax/scoreboard_ajax' );
	}
        
        // get more ranks from database from infinit scrolling in scoreboard view
        function get_more_ranks(){
            $this->load->library('account/authentication');
            if (!$this->authentication->is_signed_in() || !isset($_SESSION['fb_id'])) {
                echo -1;
                return;
            }
            // initialize $result array
            $result = array();
            //log_message('error','mo7eb scoreboard get_more_ranks ENTERED...');
            // Get NScrolls from session
            $NScrolls = $_SESSION['NScrolls'];
            // increment NScrolls for next call
            $_SESSION['NScrolls'] = $NScrolls + 1;
            //Get current seleced category from session to load its scoreboard
            $cat_id =$_SESSION ['current_category_id' ];
            // Get all flag from session
            $all = $_SESSION['all'];
            //log_message('error','mo7eb scoreboard get_more_ranks $all='.$all);
            $limit = 50; // limit of ranks selected from database
            $offset = $NScrolls * $limit + 3; // indicates current offset multiplied by number of rows selected before
            if($cat_id != -1){
                if($all){// all players ranks
                // select next ranks from scoreboard
                    $cat_name = $this->category_model->get_category_name_by_id($cat_id);
//                    $result['ranks'] = $this->scoreboard_model->get_next($cat_name, $offset, $limit);
                    $active  = $this->scoreboard_model->get_active_table($cat_id);
                    $result['ranks'] = $this->scoreboard_model->get_next_active($cat_name, $offset, $limit,$active);
                } else {// friends ranks
                // load needed models
                    $this->load->model('core_call');
                // Get Current user common friends between facebook and database
                    $friends = json_decode($this->core_call->getCommonFriends($_SESSION['fb_id']));
                // Create new array with account ids to get thier ranks from database
                    $account_ids = array();
                    $i = 0;
                    foreach ($friends as $recored){
                        $account_ids[$i] = $recored->account_id;
                        $i++;
                    }
                // Get scoreboard of friends only Given accounts_ids, $cat_id and limit of rows
                    $cat_name = $this->category_model->get_category_name_by_id($cat_id);
                    $active  = $this->scoreboard_model->get_active_table($cat_id);
//                    $result['ranks'] = $this->scoreboard_model->get_next_in( $cat_name, $offset, $limit , $account_ids);
                    $result['ranks'] = $this->scoreboard_model->get_next_active_in( $cat_name, $offset, $limit , $account_ids,$active);
                }
            // load ajax page given $result array as parameter
                $this->load->view('ajax/scoreboard_more_rows_ajax', $result);
            }
        }
        function get_top_three_players(){
        // Get current seleced category from session to load its scoreboard and Refreshing session variable
        	$cat_id = $this->input->post('cat_id');
        	if($cat_id > 4 || $cat_id < -1 || ($cat_id == -1 && !isset($_SESSION['current_category_id']))){ echo -1; return;}
                $_SESSION['current_category_id'] = $cat_id = ($cat_id != -1)? $cat_id : $_SESSION['current_category_id'];
        // Get category name and refresh session variable
        	$_SESSION['current_category_name'] = $cat_name = $this->category_model->get_category_name_by_id($cat_id);
        // Get active table flag
                $active_table = $this->scoreboard_model->get_active_table($cat_id);
                //$active_table = ($active_table == 1)?2:1;
        //Get top 3 plaeyrs
        	$limit = 3;
        	log_message('error','mo7eb scoreboard get_top_three_players $cat_id='.$cat_id.' $cat_name='.$cat_name);
        	$top_three = $this->scoreboard_model->get_active_scoreboard($cat_id, $cat_name , $active_table, $limit);
        	//log_message('error','mo7eb scoreboard get_top_three_players $top_three[top]='.print_r($top_three['top']->result_array(),TRUE));
        	//log_message('error','mo7eb scoreboard get_top_three_players $top_three[all]='.print_r($top_three['all']->result_array(),TRUE));
//        	log_message('error','mo7eb scoreboard get_top_three_players $top_three[top_users]='.print_r($top_three['top_users']->result_array(),TRUE));
        	$result['top_three'] = $top_three = $top_three['top_users']->result_array();
        	//$result['top_three'] = $top_three = ($top_three)?$top_three->result_array():array();
       	// Extract top_three ids
       		$users_ids = array();
       		foreach ($top_three as $user){
       			array_push($users_ids, $user['user_id']);
       		}
       		log_message('error','mo7eb scoreboard get_top_three_players $users_ids='.print_r($users_ids,TRUE));
        // load needed model
        	$this->load->model('core_call');
        	$result['fb_ids'] = $fb_ids = $this->core_call->getFacebookIDs($users_ids);
        	log_message('error','mo7eb scoreboard get_top_three_players $fb_ids='.print_r($fb_ids,TRUE));
        // load ajax page given $result array as parameter
        	$this->load->view('ajax/scoreboard_top_players_ajax', $result);
        }
        
        function get_user_score(){    
        // Get current seleced category from session to load its scoreboard and Refreshing session variable
            $cat_id = $this->input->post('cat_id');
            if(!isset($_SESSION['user_id']) || !isset($cat_id) || $cat_id > 4 || $cat_id < -1){ echo -1; return;}
            $_SESSION['current_category_id'] = $cat_id = ($cat_id != -1)? $cat_id : $_SESSION['current_category_id'];
        // Get category name and refresh session variable
            $_SESSION['current_category_name'] = $cat_name = $this->category_model->get_category_name_by_id($cat_id);
        // Get user_category score
            $score = $this->scoreboard_model->get_user_category_score($cat_id,$_SESSION['user_id'])->row()->score;
            log_message('error','mo7eb get_user_score cat_id='.$cat_id.' user_id = '.$_SESSION['user_id'].' score = '.$score);
            echo $score;
        }
        
        function get_user_scoreboard_score(){
            log_message('error','mo7eb get_user_scoreboard_score entered');
        // Get current seleced category from session to load its scoreboard and Refreshing session variable
            $cat_id = $this->input->post('cat_id');
            if(!isset($_SESSION['user_id']) || !isset($cat_id) || $cat_id > 4 || $cat_id < -1){ echo -1; return;}
            $_SESSION['current_category_id'] = $cat_id = ($cat_id != -1)? $cat_id : $_SESSION['current_category_id'];
        // Get active table flag
                $active_table = $this->scoreboard_model->get_active_table($cat_id);
        // Get category name and refresh session variable
            $_SESSION['current_category_name'] = $cat_name = $this->category_model->get_category_name_by_id($cat_id);
        // Get user_category score
            $score = $this->scoreboard_model->get_user_score_active($cat_name,$_SESSION['user_id'],$active_table);
            log_message('error','mo7eb get_user_scoreboard_score cat_id='.$cat_id.' user_id = '.$_SESSION['user_id'].' score = '.$score);
            echo $score;
        }
}
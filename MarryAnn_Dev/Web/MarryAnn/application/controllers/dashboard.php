<?php 
class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//Load models needed
                $this->load->model('category_model');
                $this->load->model('scoreboard_model');
	}
        function load_new_ranks(){
        // Get needed variables
            $cat_id = $this->input->post('cat_id');
            $user_id = $_SESSION['user_id'];
        // check if no category was selected
            if($cat_id == '-1') {
                $cat_id =  $_SESSION['current_category_id'];
            }
        // Get interest categories
            $interset_cats = $this->category_model->get_category_interst_by_userID($_SESSION['user_id']);
        // Initialize $dashboard and users information variables
            $dashboard = $ranks['users'] = TRUE;
        // Get ranks of user and nearest 2 players
            $ranks = $this->get_ranks_info($_SESSION['user_id'], $interset_cats, $cat_id);
            if($ranks == FALSE || $cat_id == '-1')
                { $ranks['users'] = FALSE; }
            else {
                $info['pos'] = $ranks['pos'];
                $info['fb_ids'] = $ranks['fb_ids'];
            }
        // Get user's ranks in all interest categories
            $info['dashboard'] = (($dashboard = $this->get_dashboard_info($user_id, $interset_cats))!=FALSE)?$dashboard:FALSE;
            $info['users'] = $ranks['users'];
            //log_message('error','mo7eb load_new_ranks $info[fb_ids]='.  print_r($info['fb_ids'],TRUE));
            //log_message('error','mo7eb load_new_ranks $info[dashboard]='.  print_r($info['dashboard'],TRUE));
            //log_message('error','Mo7eb load_new_ranks cat_id >>>>>>> '. $cat_id);
            //log_message('error','Mo7eb load_new_ranks ranks >>>>>>> '. print_r($ranks['users'],TRUE));
            //log_message('error','Mo7eb load_new_ranks int_cats >>>>>>> '. print_r($interset_cats->result(),TRUE));
            $this->load->view("ajax/dashboard_ranks_ajax", $info);
        }
        
        function get_ranks_info($user_id, $interset_cats, $cat_id) {
		if (!$interset_cats)
			return FALSE;
		$result = array();
		foreach ($interset_cats->result() as $int_cat) {
                    //log_message('error','Mo7eb get_ranks_info cat_id = '. $cat_id .'   int_cat->id = '. $int_cat->id);
                    if($int_cat->id == $cat_id){
                        //log_message('error','Mo7eb >>>>>>> yes');
                        $viewLimit = 3; // number must be odd cuz the cur_user will be in middel
                        $cat_name = $this->category_model->get_category_name_by_id($cat_id);
                        $cur_rank = $this->scoreboard_model->get_user_rank($user_id, $cat_name)->row(0)->rank;
                        $total_scores = $this->scoreboard_model->get_total_scores($cat_name)->row(0)->total;
                        $difference = 1;
                        if($cur_rank == 1){
                            $difference = 0;
                        }
                        else if($cur_rank == $total_scores){
                            $difference = 2;
                        }
                        $result['users'] = $this->scoreboard_model->get_dash_ranks($user_id, $cat_name, $difference, $viewLimit);
                        // Create new array with users_ids
                        $accounts_ids = array();
                        foreach($result['users']->result_array() as $recoreds){
                            array_push($accounts_ids, $recoreds['user_id']);
                        }
                        // Get User's facebook_ids
                        $result['fb_ids'] = $this->core_call->getFacebookIDs($accounts_ids);
                        //log_message('error','mo7eb dashboard get_dashboard_info $result[fb_id]='.  print_r($result['fb_ids'],TRUE));
                        //log_message('error','mo7eb scoreboard get_dashboard_info $result[$i][users]'.print_r($result[$i]['users']->result_array(),TRUE));
                        //log_message('error','Mo7eb load_new_ranks $result >>>>>>> '. print_r($result['users']->result(),TRUE));
                        $result['pos'] = $difference;
                        return $result;
                    }
		}
                return FALSE;
	}
        
        function get_dashboard_info($user_id, $interset_cats) {
		if (!$interset_cats)
			return FALSE;
		$result = array();
		$i = 0;
		foreach ($interset_cats->result() as $int_cat) {
                    $viewLimit = 3; // number must be odd
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
                return $result;
	}
}
<?php 
class Category extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//Load models needed
		$this->load->model('card_model');
		$this->load->model('category_model');
		$this->load->model('activity_model');
                $this->load->model('scoreboard_model');
                $this->load->model('user_model');
	}
	
	function get_category_name()  {
		$info['cat_id'] = $_SESSION['current_category_id'];
		$info['cat_name'] = $_SESSION['current_category_name'];
		$this->load->view('ajax/card_name_view_ajax' , $info);
	}

        function hex2rgb($hex) {
            log_message('error','mo7eb category hex2rgb $hex before='.$hex);
            $hex = str_replace("#", "", $hex);
            log_message('error','mo7eb category hex2rgb $hex after='.$hex);
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
            $rgb = array($r, $g, $b);
            log_message('error','mo7eb category hex2rgb $rgb='.print_r($rgb,TRUE));
            return $rgb; // returns an array with the rgb values
        }
        
	function load_interest_category() {
            // Get data sent from page
            $info['cat_id'] = $this->input->post('cat_id');
            $info['cat_name'] = $this->input->post('cat_name');
            // Get user_id From session
            $info['user_id'] = $_SESSION['user_id'];
            // User session data are updated
            if($info['cat_id'] == '-1' && !empty($_SESSION['current_category_id'])) {
                    $info['cat_id'] =  $_SESSION['current_category_id'];
                    $info['cat_name'] = $_SESSION['current_category_name'];
            }
            // Set new session variables
            $_SESSION['current_category_id'] = $info['cat_id'];
            $_SESSION['current_category_name'] = $info['cat_name'];
        // Get category color hash from database
            $rgb = $this->hex2rgb($this->category_model->get_category_color_by_id($info['cat_id']));
            $info['color'] = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',0.25)';
            // Get Interest Categories
            $info['interest_cats'] = $this->category_model->get_category_interst_by_userID($info['user_id']);
            //Get number of cards in category
            if($info['interest_cats'])
            {
                $i = 0;
                foreach ( $info['interest_cats']->result() as $row){
                    $info['total_cards'][$i] = $this->card_model->get_category_cards($row->id);
                    $i++;
                }
            }
            // Get Current page to be redirected
            $info['current_page'] = $_SESSION['current_page'];
            // return ajax page
            $this->load->view('ajax/load_interest_category_view_ajax' , $info);
	}
	function load_interest_category_my_collection() {
		$info['cat_id'] = $this->input->post('cat_id');
		$info['cat_name'] = $this->input->post('cat_name');
		$info['user_id'] = $_SESSION['user_id'];
		//User session data are updated
		if($info['cat_id'] == '-1' && !empty($_SESSION['current_category_id'])) {
			$info['cat_id'] =  $_SESSION['current_category_id'];
			$info['cat_name'] = $_SESSION['current_category_name'];
		}
            // Get category color hash from database
                $rgb = $this->hex2rgb($this->category_model->get_category_color_by_id($info['cat_id']));
                $info['color'] = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',0.25)';
                
		//Set new session variables
		$_SESSION['current_category_id'] = $info['cat_id'];
		$_SESSION['current_category_name'] = $info['cat_name'];
	
		$info['interest_cats'] = $this->category_model->get_category_interst_by_userID($info['user_id']);
                //Get number of cards in category
                if($info['interest_cats']){
                    $i = 0;
                    foreach ( $info['interest_cats']->result() as $row){
                        $info['total_cards'][$i] = $this->card_model->get_category_cards($row->id);
                        $i++;
                    }
                }
                //
		$info['current_page'] = $_SESSION['current_page'];
		$this->load->view('ajax/load_interest_category_my_collection_view_ajax' , $info);
	}
	
	/*function load_not_interest_category(){
            $cat_id = $this->input->post('cat_id');
            $user_id = $_SESSION['user_id'];
            $to_load = $this->input->post('to_load');
            if($to_load == false) {
                    $this->category_model->insert_user_category($cat_id , $user_id);
                    //3 --> Follow new category
                    $this->activity_model->insert_log( $user_id , 3);
                    //Add new row to scoarboard with zero score
                    $cat_name = $this->category_model->get_category_name_by_id($cat_id);
                    $rank = $this->scoreboard_model->get_total_scores($cat_name)->row(0)->total + 1;
                    $username = $this->user_model->get_user_details($user_id)->row(0)->fullname;
                    $this->scoreboard_model->insert_new_user($user_id, $username, $cat_name, $rank);
            }
            //Get interest cats
            $interest_cats = $this->category_model->get_category_interst_by_userID($user_id);
            //Get All
            $all_cats = $this->category_model->get_all_category();
            //Get NOT interested
            $info['not_interest_cats'] = $this->get_not_interst_categories($all_cats, $interest_cats);
            $this->load->view('ajax/load_not_interest_category_view_ajax',$info);
	}
	function load_not_interest_category_my_collction() {
		$cat_id = $this->input->post('cat_id');
		$user_id = $_SESSION['user_id'];
		$to_load = $this->input->post('to_load');
		if($to_load == false) {
			$this->category_model->insert_user_category($cat_id , $user_id);
			//3 --> Follow new category
			$this->activity_model->insert_log( $user_id , 3);
                        $cat_name = $this->category_model->get_category_name_by_id($cat_id);
                        $rank = $this->scoreboard_model->get_total_scores($cat_name)->row(0)->total + 1;
                        $username = $this->user_model->get_user_details($user_id)->row(0)->fullname;
                        $this->scoreboard_model->insert_new_user($user_id, $username, $cat_name, $rank);
		}
		//Get interest cats
		$interest_cats = $this->category_model->get_category_interst_by_userID($user_id);
		//Get All
		$all_cats = $this->category_model->get_all_category();
		//Get NOT interested
		$info['not_interest_cats'] = $this->get_not_interst_categories($all_cats, $interest_cats);
		$this->load->view('ajax/load_not_interest_category_my_collection_view_ajax',$info);
	}
	
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
			if($to_add == 1) {
				log_message('error', $row -> name);
				array_push($res , $row);
			}
		}
		return $res;
	}*/
	function get_category_name_without_href () {
		$data = $_SESSION['current_category_name'];
		echo $data;
	}
}
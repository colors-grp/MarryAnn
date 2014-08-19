<?php
class Card extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//Load models needed
		$this->load->model('card_model');
		$this->load->model('category_model');
		$this->load->model('activity_model');
		$this->load->model('game_model');
		$this->load->helper('credit');
	}
	// Display user cards in a list format given certain category
	function get_card_list_view() {
		// Get user ID and Categoty Info (ID, Name)
		$user_id =$_SESSION['user_id'];
		$cat_id = $this->input->post('cat_id');
		$cat_name = $this->input->post('cat_name');
		// Check whether redirected from another view (eg: scoreboard, MyCollections) ...
		// Also cat_id == -1 if card view is changed (list/grid) ...
		if($cat_id == '-1' && !empty($_SESSION['current_category_id'])) {
			$cat_id =  $_SESSION['current_category_id'];
			$cat_name = $_SESSION['current_category_name'];
			//Set that current view is list view
			$_SESSION['card_view'] = 'list';
		}
		// Check whether redirected from another view (eg: scoreboard, MyCollections) and previous card view was grid
		if ($_SESSION['card_view'] == 'grid') {
			$_SESSION['current_category_id'] = $cat_id;
			$_SESSION['current_category_name'] = $cat_name;
			return $this-> get_card_grid_view();
		}
		// Set session variables
		$_SESSION['current_category_id'] = $cat_id;
		$_SESSION['current_category_name'] = $cat_name;
		
		// Set parameters sent to view
		$info['cat_id'] = $cat_id;
		$info['category_name'] = $cat_name;
                log_message('error','Mo7eb get_card_list_view >>>>>> current_category_id='.$_SESSION['current_category_id']);
		$info['cards'] = $this->card_model->get_cards_by_id($cat_id);
                $info['new_cards'] = $this->card_model->get_not_interest_cards($user_id,$cat_id);
		
		// Checks if there are cards in category or not
		if ($info['cards']) {
			$user_cards = $this->card_model->get_user_cards_by_id($cat_id, $user_id);
			$info['user_cards'] = array();
                        $info['cards'] = array();
                        if ($info['new_cards'] != FALSE){
                            if($info['new_cards']->num_rows() > 0){
                                foreach ($info['new_cards']->result() as $nc){
                                    array_push($info['cards'],$nc);
                                }
                            }
                        }
			$info['user_points'] = get_credit();
			// Prepare an array containing owned cards
			if ($user_cards != FALSE) {
				foreach ($user_cards->result() as $uc) {
                                    array_push($info['cards'], $uc);
                                    array_push($info['user_cards'], $uc->id);
				}
			}
			$info['cat_id'] = $_SESSION['current_category_id'];
			$info['cat_name'] = $_SESSION['current_category_name'];
                        //get category contents (img, audio, vid, game)
                        $this->load->helper('directory');
                        $i=0;
                        foreach ($info['cards'] as $card){
                            $info['images'][$i] = $info['audios'][$i] = $info['videos'][$i] = $info['games'][$i] = FALSE;
                            $info['images'][$i] = (directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card->id.'/image/')!=FALSE ? TRUE : FALSE);
                            $info['audios'][$i] = (directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card->id.'/audio/')!=FALSE ? TRUE : FALSE);
                            $info['videos'][$i] = (directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card->id.'/video/')!=FALSE ? TRUE : FALSE);
                            //log_message('error','mo7eb card get_card_list_view $audios['.$i.']='.print_r(directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card->id.'/audio/'),TRUE));
                            $info['games'][$i] = $this->game_model->checkAnyGames($cat_id, $card->id);
                            $i++;
                        }
            //log_message('error','mo7eb card get_card_list_view $audios='.print_r($info['audios'],TRUE));
			// Load Card List View
			$this->load->view('ajax/card_list_view_ajax', $info);
		} else {
			echo 'No Cards';
		}

	}
	
	// Display user cards in a grid format given certain category
	function get_card_grid_view() {
            $this->load->library('account/authentication');
            if (!$this->authentication->is_signed_in() || !isset($_SESSION['fb_id'])) {
                echo -1;
                return;
            }
            // Get user ID and Categoty Info (ID, Name)
		$user_id = $_SESSION['user_id'];
		$cat_id = $this->input->post('cat_id');
		$cat_name = $this->input->post('cat_name');
                if($cat_id == '-1' && !empty($_SESSION['current_category_id'])) {
			$cat_id =  $_SESSION['current_category_id'];
			$cat_name = $_SESSION['current_category_name'];
		}
            // incase of playing user
                if(!is_numeric($cat_id) || $cat_id > 4 || $cat_id < 1){echo -1; return;}
            // Refresh session variables
                $_SESSION['current_category_id'] = $cat_id;
                $_SESSION['current_category_name'] = $cat_name;
//	
//		//set current card view
//		$_SESSION['card_view'] = 'grid';
//			
//		//Get category information form session or caller
//                $cat_id = $this->input->post('cat_id');
//                $cat_name = $this->input->post('cat_name');
//                if($cat_id == '-1' && !empty($_SESSION['current_category_id'])) {
//			$cat_id =  $_SESSION['current_category_id'];
//			$cat_name = $_SESSION['current_category_name'];
//			//Set that current view is list view
//			$_SESSION['card_view'] = 'list';
//		}
//                $_SESSION['current_category_id'] = $cat_id;
//                $_SESSION['current_category_name'] = $cat_name;
//		$user_id = $_SESSION['user_id'];
		
		// Set view parameters
		$info['cat_id'] = $cat_id;
		$info['cat_name'] = $cat_name;
		$this->load->model('card_model');
//		$info['cards'] = $this->card_model->get_cards_by_id($cat_id);
//                $info['cards'] = $this->card_model->get_available_cards($cat_id);
                //$info['new_cards'] = $this->card_model->get_not_interest_cards($user_id,$cat_id);
		
		// Checks if there are cards in category or not
//		if ($info['cards']) {
		// Get boolean array of cards been added to every category
            // This variable to be used to invoke user if new cards was added and in wich category
                //$this->load->helper('credit');
            // add new cards to user if found
                $this->load->helper('card');
                $info['new_cards'] = $new_cards = add_new_cards($user_id);
            // Get user's cards
                $user_cards = $this->card_model->get_user_cards_by_id($cat_id, $user_id);
//			$info['user_cards'] = array();
                $info['cards'] = array();
//                        if ($info['new_cards'] != FALSE){
//                            if($info['new_cards']->num_rows() > 0){
//                                foreach ($info['new_cards']->result() as $nc){
//                                    array_push($info['cards'],$nc);
//                                }
//                            }
//                        }
            // Prepare an array containing available cards first
                $info['user_points'] = get_credit();
                $user_cards = ($user_cards)?$user_cards->result_array():array();
                foreach ($user_cards as $uc) {
                    array_push($info['cards'], $uc);
                }
                log_message('error','mo7eb card get_card_grid_view $cat_id='.$cat_id.' $info[cards]='.  print_r($info['cards'],TRUE));
                //get category contents (img, audio, vid, game)
                $this->load->helper('directory');
                $i=0;
                foreach ($info['cards'] as $card){
                    $info['images'][$i] = $info['audios'][$i] = $info['videos'][$i] = $info['games'][$i] = FALSE;
                    $info['images'][$i] = (directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card['id'].'/image/')!=FALSE?TRUE:FALSE);
                    $info['audios'][$i] = (directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card['id'].'/audio/')!=FALSE?TRUE:FALSE);
                    $info['videos'][$i] = (directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card['id'].'/video/')!=FALSE?TRUE:FALSE);
                    $info['games'][$i] = $this->game_model->checkAnyGames($cat_id, $card['id']);
                    if(isset($_SESSION['user_id']) && $info['games'][$i]){
                        $game = $this->game_model->get_games($cat_id, $card['id']);
                        $game_id = $game->row(0)->game_id;
                        $info['score'][$i] = $this->game_model->is_played($game_id);
                    }
                    $i++;
                }
            // Get blocked cards
                $blocked_cards = $this->card_model->get_blocked_cards($cat_id);
                $info['blocked_cards'] = ($blocked_cards)?$blocked_cards->result_array():array();
                // Load Card Grid View
                $this->load->view('ajax/card_grid_view_ajax',$info);
//		} else
//			echo 'No Cards';
	}

	function hex2rgb($hex) {
            $hex = str_replace("#", "", $hex);
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
            $rgb = array($r, $g, $b);
            return $rgb; // returns an array with the rgb values
        }
        
	function get_cards_my_collection_view() {
            //Get category info (Name, ID) sent from view
		$cat_id = $this->input->post('cat_id');
		$info['category_name'] =  $this->input->post('cat_name');
            // Check if redirected from another view (Scoreboard, Market)
		if($cat_id == '-1') {
			$cat_id = $_SESSION['current_category_id'];
			$info['category_name'] = $_SESSION['current_category_name'];
		}
            // Get session variables
		$user_id = $_SESSION['user_id'];
            // Get category color hash from database
                $rgb = $this->hex2rgb($this->category_model->get_category_color_by_id($cat_id));
                $info['color'] = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',0.25)';
		$info['card_id'] = $this->input->post('card_id');
            //Set session variables
		$_SESSION['current_category_id'] = $cat_id;
		$_SESSION['current_category_name'] = $info['category_name'];
            //Get cards info from database
		$this->load->model('card_model');
		$info['cards'] = $this->card_model->get_user_cards_by_id($cat_id , $user_id);
            // Check if thier was no card_id sent then select first card_id
                if($info['cards'] && !$info['card_id']){
                    $info['card_id'] = $info['cards']->row(0)->card_id;
                }
            // Load My Collections Cards View
		$this->load->view('ajax/my_collection_list_of_cards_view_ajax',$info);
	}
	
	// Load initial cards when load my collections page
	function on_load_get_card_info() {
		// Get variables sent from view
		$cat_id = $this->input->post('cat_id');
		$name = $info['cat_name'] = $this->input->post('cat_name');
		// Check if redirected from another view (Scoreboard, Market)
		if($cat_id == '-1') {
			$cat_id = $info['cat_id'] =  $_SESSION['current_category_id'];
			$name = $info['cat_name'] = $_SESSION['current_category_name'];
		}
		// Get and Set some session variables
		$user_id = $info['user_id'] = $_SESSION['user_id'];
		$_SESSION['current_category_id'] = $cat_id;
		$_SESSION['current_category_name'] = $name;

		// Get user cards from database
		$this->load->model('card_model');
		$cards = $this->card_model->get_user_cards_by_id($cat_id , $user_id);
                log_message('error','mo7eb card on_load_get_card_info $cards='.  print_r($cards,TRUE));
		// Check if user has cards or not in current category
		if($cards) {
			// Get first card data to load in view
			$first_card = $cards->row();
			$card_id =$info['card_id'] = $first_card ->id;
			$info['card_name'] = $first_card->name;
			$info['card_price'] = $first_card->price;
			$info['card_score'] = $first_card->score;
			// Assign own_card to TRUE [[fakss]]
			$info['own_card'] = TRUE;
			//Load Directory helper to traverse media in each media item
			$this->load->helper('directory');
			$info['images'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/image/');
			$info['audios'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/audio/');
			$info['videos'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/video/');
			$info['games'] = $this->game_model->get_games($cat_id, $card_id);
			$info['stories'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/story/');
			
           	log_message('error','mo7eb card on_load_get_card_info $info='.print_r($info,TRUE));
			$this->load->view('ajax/my_collection_view_ajax', $info);

		}else { // User doesn't have any cards in the current category
			echo ' ';
		}
	}

	function get_card_info_mycollection() {
		// Get variables sent from view
		$card_id =$info['card_id'] = $this->input->post('card_id');
		$cat_id = $info['cat_id'] = $this->input->post('cat_id');
		$name = $info['cat_name'] = $this->input->post('cat_name');
		// Check if redirected from another view (Scoreboard, Market)
		if($cat_id == '-1') {
			$cat_id = $info['cat_id'] =  $_SESSION['current_category_id'];
			$name = $info['cat_name'] = $_SESSION['current_category_name'];
		}
		// Get and Set some session variables
		$info['user_id'] = $_SESSION['user_id'];
		$_SESSION['current_category_id'] = $cat_id;
		$_SESSION['current_category_name'] = $name;
		// Set view parameters 
		$info['card_id'] = $this->input->post('card_id');
		$info['card_name'] = $_SESSION['card_name'] = $this->input->post('card_name');
		$info['card_price'] = $this->input->post('card_price');
		$info['user_points'] = $this->input->post('user_points');
		$info['card_score'] = $this->input->post('card_score');
		// Check whether user owns this card or not ...
		$info['own_card'] = $this->card_model->own_card($cat_id , $card_id ,$info['user_id'] );
            //Load Directory helper to traverse media in each media item
		$this->load->helper('directory');
		$info['images'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/image/');
		$info['audios'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/audio/');
		$info['videos'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/video/');
		$info['games'] = $this->game_model->get_games($cat_id, $card_id);
		$info['stories'] = directory_map('./h7-assets/images/categories/'.$name.'/cards/'.$card_id.'/story/');
		//log_message('error','mo7eb card get_card_info_mycollection $cat_id='.$cat_id);
                //log_message('error','mo7eb card get_card_info_mycollection $card_id='.$card_id);
                //log_message('error','mo7eb card get_card_info_mycollection $info[own_card]='.$info['own_card']);
                
		$this->load->view('ajax/my_collection_view_ajax', $info);
	}
	
	function get_next_story_image(){
	// Get variables sent from caller
		$currentImagePos = $this->input->post('currentImage');
		$cat_name = $this->input->post('cat_name');
		$card_id =  $this->input->post('card_id');
		//log_message('error','mo7eb card get_next_story_image $currentImagePos='.$currentImagePos.'  $cat_name='.$cat_name.'  $card_id='.$card_id);
	//Load Directory helper to traverse media in each media item
		$this->load->helper('directory');
	// Get stories images
		$stories = directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card_id.'/story/');
		//log_message('error','mo7eb card get_next_story_image $stories='.print_r($stories,TRUE));
	// Return False if current image is last or return image fullname
		//log_message('error','mo7eb card get_next_story_image returning='.$stories[$currentImagePos + 1]);
		echo (count($stories) != ($currentImagePos + 1))?$stories[$currentImagePos + 1]:FALSE;
	}
	
	function get_previous_story_image(){
	// Get variables sent from caller
		$currentImagePos = $this->input->post('currentImage');
		$cat_name = $this->input->post('cat_name');
		$card_id =  $this->input->post('card_id');
		log_message('error','mo7eb card get_next_story_image $currentImagePos='.$currentImagePos.'  $cat_name='.$cat_name.'  $card_id='.$card_id);
	//Load Directory helper to traverse media in each media item
		$this->load->helper('directory');
	// Get stories images
		$stories = directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card_id.'/story/');
		log_message('error','mo7eb card get_previous_story_image $stories='.print_r($stories,TRUE));
	// Return False if current image is last or return image fullname
		//log_message('error','mo7eb card get_next_story_image returning='.$stories[$currentImagePos + 1]);
		echo (($currentImagePos - 1) != -1)?$stories[$currentImagePos - 1]:FALSE;
	}
        
        //
        function get_element_type($cat_id,$card_id,$next,$currentElement){
        // Get all elements from thier directories
            //Load Directory helper to traverse media in each media item
                $this->load->helper('directory');
            // Get category name
                $cat_name = $this->category_model->get_category_name_by_id($cat_id);
            $elements['images'] = ($result = directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card_id.'/image/'))?$result:array();
            $elements['audios'] = ($result = directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card_id.'/audio/'))?$result:array();
            $elements['videos'] = ($result = directory_map('./h7-assets/images/categories/'.$cat_name.'/cards/'.$card_id.'/video/'))?$result:array();
//            log_message('error','mo7eb card get_element_type before sort $elements='.print_r($elements,TRUE));
            sort($elements['images'], SORT_NATURAL | SORT_FLAG_CASE);
            sort($elements['audios'], SORT_NATURAL | SORT_FLAG_CASE);
            sort($elements['videos'], SORT_NATURAL | SORT_FLAG_CASE);
//            sort($elements['images']);
//            sort($elements['audios']);
//            sort($elements['videos']);
            log_message('error','mo7eb card get_element_type after sort $elements='.print_r($elements,TRUE));
            $elements['games'] = $this->game_model->get_games($cat_id, $card_id);
            log_message('error','mo7eb card get_element_type $elements[games]='.print_r(($elements['games'])?$elements['games']->result_array():'No Games',TRUE));
            $elem_type = 0; // type = 0 = NON
            if($next == -1){ // get first element type
            // Refresh/Set session variable
                $_SESSION['currentElement'] = $currentElement = 0;
                $elem_type = $this->check_type($_SESSION['currentElement'], $elements);
            } elseif (!$next){ // get prev element type
            // Refresh/Set session variable
                $_SESSION['currentElement'] = $currentElement-1;
                $elem_type = $this->check_type($_SESSION['currentElement'], $elements);
            } else { // get next element type
            // Refresh/Set session variable
                $_SESSION['currentElement'] = $currentElement+1;
                $elem_type = $this->check_type($_SESSION['currentElement'], $elements);
            }
            log_message('error','mo7eb card get_element_type $cat_id='.$cat_id.' $card_id='.$card_id.' $next='.$next);
            log_message('error','mo7eb card get_element_type $currentElement='.$_SESSION['currentElement'].' $elem_type='.$elem_type);
            log_message('error','mo7eb card get_element_type $elements='.print_r($elements,TRUE));
            $result['elements'] = $elements;
            $result['elem_type'] = $elem_type;
            return $result;
        }
        function check_type($currentElement, $elements){
                $elem_type = 0; // type = 0 = NON
                log_message('error','mo7eb card check_type $currentElement='.$currentElement);
                log_message('error','mo7eb card check_type $images='.count($elements['images']));
                log_message('error','mo7eb card check_type $audios='.count($elements['audios']));
                log_message('error','mo7eb card check_type $videos='.count($elements['videos']));
                //if($elements['games']){
                    log_message('error','mo7eb card check_type $games='.print_r(($elements['games'])?$elements['games']->result_array():'No Games',TRUE));
                //} else {
                //    log_message('error','mo7eb card get_element_type $games=0');
               // }
               $total_size = (count($elements['images']) + count($elements['audios']) + count($elements['videos']) + (($elements['games'])?$elements['games']->num_rows():0));
            // Check current element value to make sure it is in rang
                if($currentElement < 0) {
                    $_SESSION['currentElement'] = $currentElement = 0;
                } else if($currentElement >= $total_size) {
                    $_SESSION['currentElement'] = $currentElement = $total_size - 1;
                }
                if($elements['images'] && $currentElement < count($elements['images'])){
                    $elem_type = 1;
                } elseif ($elements['audios'] && $currentElement < count($elements['audios']) + count($elements['images']) ){
                    $elem_type = 2;
                } elseif ($elements['videos'] && $currentElement < count($elements['videos']) + count($elements['audios']) + count($elements['images']) ){
                    $elem_type = 3;
                } elseif ($elements['games'] && $currentElement < $elements['games']->num_rows() + count($elements['videos']) + count($elements['audios']) + count($elements['images'])){
                    $elem_type = 4;
                }
            return $elem_type;
        }
        function get_element_view(){
        // Get needed variables from post and session
            $data['cat_id'] = $cat_id = $this->input->post('cat_id');
            $data['card_id'] = $card_id = $this->input->post('card_id');
            $next = $this->input->post('next');
        // Check next flag ... -1,0,1 same,prev,next
            $currentElement = (isset($_SESSION['currentElement']) && $next!=-1 )?$_SESSION['currentElement']:0;
        // Get first,prev,next type and elements
            $result = $this->get_element_type($cat_id, $card_id, $next, $currentElement);
            $data['currentElement'] = $currentElement = $_SESSION['currentElement'];
            log_message('error','mo7eb card get_element_view $currentElement='.$currentElement.' $next='.$next);
            $data['type'] = $type = $result['elem_type'];
            $elements = $result['elements'];
        // Get elements from session
            $size = 0;
            //$elements = $_SESSION['elements'];
            if($type == 1){
                $data['element'] = $elements['images'][$currentElement];
            } elseif($type == 2) {
                $size = ($elements['images'])?count($elements['images']):0;
                $data['element'] = $elements['audios'][$currentElement - $size];
            } elseif($type == 3) {
                $size = (($elements['images'])?count($elements['images']):0) + (($elements['audios'])?count($elements['audios']):0);
                $data['element'] = $elements['videos'][$currentElement - $size];
            } elseif($type == 4) {
                $size = (($elements['images'])?count($elements['images']):0) + (($elements['audios'])?count($elements['audios']):0) + (($elements['videos'])?count($elements['videos']):0);
                $data['element'] = $elements['games']->row($currentElement - $size);
            }
            $data['cat_name'] = $this->category_model->get_category_name_by_id($cat_id);
            $data['card_name'] = $this->card_model->get_card_name_by_id($cat_id,$card_id)->row(0)->name;
            $data['size'] = $size = (($elements['images'])?count($elements['images']):0) + (($elements['audios'])?count($elements['audios']):0) + (($elements['videos'])?count($elements['videos']):0) + (($elements['games'])?$elements['games']->num_rows():0);
        // Tracing logs
            log_message('error','mo7eb card get_element_view $size='.$size);
            log_message('error','mo7eb card get_element_view $elements[games]='.print_r(($elements['games'])?$elements['games']->result_array():'No Games',TRUE));
            log_message('error','mo7eb card get_element_view $data='.print_r($data,TRUE));
        // Check if type = game or not
            if($type > 3){// is a game
            // Load needed helper
                $this->load->helper('game_helper');
                $_SESSION['size'] = $size;
                echo get_game_view($cat_id, $card_id, $data['element']->game_id, $data['element']->game_type);
            } elseif($type > 0){
                $this->load->view('ajax/mixed_popup_view_ajax',$data);
            } else {
                echo 'Sorry no contents try again later...';
            }
        }
}
<?php
class Game_center extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//Load models needed
		$this->load->model('game_model');
	}
	function update_score () {
		$score = $this->input->post('game_score');
		$score = intval($score);
                if(!isset($_SESSION['game_id'])){
                    echo -1;
                    return;
                }
		$game_id = $_SESSION['game_id'];
		log_message('error',' game_center update_score $game_id'. $game_id);
		$mx = $this->game_model->calc_score($game_id, $score);
		log_message('error',' game_center update_score $score'. $score .' $mx='.$mx);
		$total_score = $this->game_model->update_total_score($mx);
                if($total_score > -1){//score updated successfully
                    $this->post_on_fb($game_id);
                }
		echo $total_score;
	}
        function get_best_score(){
            $game_id = $_SESSION['game_id'];
            $user_id = $_SESSION['user_id'];
            if(!isset($_SESSION['game_id']) || !isset($_SESSION['user_id'])){
                echo -1;
                return;
            }
            echo $this->game_model->get_user_best_score($game_id,$user_id);
        }
        function post_on_fb($game_id){
            $category_id = $this->game_model->get_game_category($game_id);
            if($category_id != -1 && isset($_SESSION['user_id'])){
                $users_ids = array('1','2','9','22');
                if( !in_array($_SESSION['user_id'], $users_ids))
                {return;}
            	log_message('error', 'NOUR, cat id = ' . $category_id);
                if(isset($_SESSION['last_played_game']) && $_SESSION['last_played_game'] == $game_id){
                	log_message('error', 'NOUR, gwa el if bta3et el session');
                	return;
                }
                $_SESSION['last_played_game'] = $game_id;
            // load needed model
                $this->load->model('core_call');
            // Get user access token
                if(isset($_SESSION['user_id'])){
                    $this->core_call->get_user_access_token($_SESSION['user_id']);
                } else {
                    log_message('error','user_id not found in session');
                }
            	$this->load->helper('url');
            	if($category_id == 1){
            		log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
            		try{
	            	$response = $this->facebook->api(
	            			'me/hitsevenapp:play',
	            			'POST',
	            			array(
	            					'sally_syamak_game' => array(
	            							'og:url' => 'http://supersayem.com',
	            							'og:title' => 'سوبر صايم - سلي صيامك',
	            							'og:image' => base_url().'h7-assets/resources/img/categories/sally.png',
	            							'og:description' =>'كل يوم لعبة جديدة تجمع فيها الكلمات وتختبر تركيزك',
	            							'og:access_token' => '170161316509571|sKck_w5wqQCc5I2tFuFke4gosVM'
	            					)
	            			)
	            	);
            		}catch(FacebookApiException $e){
            			log_message('error', 'NOUR, gwa el catch ' . $e);
	            	}
					
					log_message('error', 'response: '.print_r($response, TRUE));
					$graphObject = $response->getGraphObject();
					log_message('error', 'NOUR response: '.print_r($graphObject, TRUE));
					
            	}elseif ($category_id == 2){
            		log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
	            	try{
	            	$response = $this->facebook->api(
	            			'me/hitsevenapp:solve',
	            			'POST',
	            			array(
	            					'moslsalat_quiz' => array(
	            							'og:url' => 'http://supersayem.com',
	            							'og:title' => 'سوبر صايم - مسلسلات',
	            							'og:image' => base_url().'h7-assets/resources/img/categories/mosalsalat.png',
	            							'og:description' =>'كل يوم اسئلة عن مسلسل جديد وشوف إنت فاكر قد إيه منه',
	            							'og:access_token' => '170161316509571|sKck_w5wqQCc5I2tFuFke4gosVM'
	            					)
	            			)
	            	);
	            	}catch(FacebookApiException $e){
	            		log_message('error', 'NOUR, gwa el catch ' . $e);
	            	}
					log_message('error', 'response: '.print_r($response, TRUE));
					$graphObject = $response->getGraphObject();
					log_message('error', 'NOUR response: '.print_r($graphObject, TRUE));
					
            	}elseif ($category_id == 3){
            		log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
	            	try{
	            	$response = $this->facebook->api(
	            			'me/hitsevenapp:find',
	            			'POST',
	            			array(
	            					'new_weapon' => array(
	            							'og:url' => 'http://supersayem.com',
	            							'og:title' => 'سوبر صايم - فين السلاح؟',
	            							'og:image' => base_url().'h7-assets/resources/img/categories/qatel.png',
	            							'og:description' =>'كل يوم جريمة جديدة تساعد فيها المقدم نور الدين يقفش المجرم لما تطلع السلاح من مكان الجريمة',
	            							'og:access_token' => '170161316509571|sKck_w5wqQCc5I2tFuFke4gosVM'
	            					)
	            			)
	            	);
	            	}catch(FacebookApiException $e){
	            		log_message('error', 'NOUR, gwa el catch ' . $e);
	            	}
					log_message('error', 'response: '.print_r($response, TRUE));
					$graphObject = $response->getGraphObject();
					log_message('error', 'NOUR response: '.print_r($graphObject, TRUE));
					
            	}elseif ($category_id == 4){
            		log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
	            	try{
	            	$response = $this->facebook->api(
	            			'me/hitsevenapp:enjoy',
	            			'POST',
	            			array(
	            					'shahryar_comic' => array(
	            							'og:url' => 'http://supersayem.com',
	            							'og:title' => 'سوبر صايم - ألف ليلة وليلة (٣٠ زوجة لشهريار)',
	            							'og:image' => base_url().'h7-assets/resources/img/categories/alfleila.png',
	            							'og:description' => 'كل يوم حلقة كومكس جديدة نشوف فيها الزوجة هتعمل اه وندور مع شهريار على عصير الخروب',
	            							'og:access_token' => '170161316509571|sKck_w5wqQCc5I2tFuFke4gosVM'
	            					)
	            			)
	            	);
	            	}catch(FacebookApiException $e){
	            		log_message('error', 'NOUR, gwa el catch ' . $e);
	            	}
					log_message('error', 'response: '.print_r($response, TRUE));
					$graphObject = $response->getGraphObject();
					log_message('error', 'NOUR response: '.print_r($graphObject, TRUE));
					
            	}
            }else{
            	log_message('error', 'NOUR cat id = -1');
            }
        }
        function share_of_fb(){
        // Ready needed variables ... message and user_id
            $message = $this->input->post('message');
            if(isset($_SESSION['user_id'])){
            // Load needed model
            	log_message('error', 'NOUR, el message' . $message . " el account_id " . $_SESSION['user_id']);
                $this->load->model('core_call');
                $this->core_call->post4me($_SESSION['user_id'], $message);
                log_message('error','game_center share_of_fb $user_id='.$_SESSION['user_id'].' $message'.$message);
            } else {
                echo -1;
                return;
            }
        }
}

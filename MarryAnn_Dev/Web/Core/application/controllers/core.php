<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		$this->load->library(array('account/authentication', 'account/authorization', 'account/facebook_lib'));
		//$this->load->model(array('account/account_model', 'account/account_facebook_model'));
		$this->load->model(array('account/account_model', 'account/account_details_model', 'account/account_facebook_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}



	//Loading competition pictures
	public function load_competitions($account_id) {
		$this->load->model('home_model');
		$query['site_info'] = $this->home_model->get_competitions(); //getting current competitions information
		$query['user_id'] = $account_id;
		$this->load->view('home_view' , $query);
	}

	// This method should get the code from platform, and evaluate it to a URL from the HitSeven Database ...
	function getSiteUrl($sitecode)
	{
		if($sitecode == '1')
			return 'http://gloryette.co/heba';
	}

	function get_login_url() {
		// Set the redirect URL which facebook will return to after logging in ...
		// base_url (is the URL of the CORE -> send you to Core.php.index())
		$redirect_uri = base_url();
		// get the login url from facebook with the configured return uri
		return $loginurl = $this->facebook->getLoginUrl(array('redirect_uri' => "$redirect_uri", 'scope' => 'email,read_friendlists'));
	}

	function set_competitions_array($sites , $user_competitions) {
		//given all the competitions and competitions a certain user is enrolled in
		//it returns an array with competitions the user is enrolled in set to true
		//all other competitions are set to false
		foreach ($sites->result() as $site) {
			$tmp[$site->id] = false;
		}
		if($user_competitions!= FALSE) {
			foreach ($user_competitions as $comp) {
				//set the competitions the user is registered in to true,others are false
				$tmp[$comp->competition_id] = true;
			}
		}
		return $tmp;
	}

	function set_data_array($tmp , $user_name , $sites) {
		//prepares data array to be sent to view
		$data['check'] = $tmp;
		$data['username'] = $user_name;
		$data['site_info'] = $sites;
		return $data;
	}


	// The sign-in supported index method ...
	// Core is called via : http://www.colors-studios.com/core"
	function index() {
			
		maintain_ssl(TRUE);
		
//                $_SESSION['language'] = 'arabic';
		$cnt = 0;
		//Start session if it is not already started

			if (session_id() == '')
				session_start();

			// Sidecode is a numerical value that represent the site primary ID in Database
			// Replacing encryption of the HTTP URL with a numerical value to avoid creating invalid characters in URL ...
			$sitecode = $this -> input -> get('sitecode');
                        $admin_page = $this -> input -> get('admin_page');
                        if($admin_page){
                            $this->session->set_userdata('admin_page', $admin_page);
                        }
			$mode = $this -> input -> get('mode');
                        if($mode){
                            $this->session->set_userdata('mode', $mode);
                        }
			$accountid = $this -> input -> get('accountid');
			$code = $this -> input -> get('code');
			$cfbid = $this -> input -> get('cfbid');

			if ($cfbid)// -> coming from the canvas ...
			{

				$data = json_decode(base64_decode($cfbid));

				//echo $cfbid;
				log_message('error', 'coreeee 4Jul : ' . print_r($data, TRUE));
				//log_message('error', 'coreeee 4Jul : bdddd '. print_r($data->dateofbirth->date, TRUE));
				$user_id = $this -> account_facebook_model -> get_by_facebook_id($data -> fb_id);

				//echo print_r($user_id->account_id, TRUE);
				if ($user_id)// this is an old user coming from canvas ...
				{
					log_message('error', 'coreeee 4Jul $user_id : ' . print_r($user_id, TRUE));
					if ($user_id -> account_id) {
						log_message('error', 'coreeee 4Jul : $user_id->account_id' . $user_id -> account_id);
						$accountid = $user_id -> account_id;
						$this -> authentication -> sign_in($accountid);
					}
					
				} else {/// This is a new user coming from Canvas  ...

					// Create user and giving him credit from default competition credit*/
					if (!$data -> dateofbirth)
						$birthday = '1983-02-16 00:00:00';
					else
						$birthday = $data -> dateofbirth -> date;
					$user_id = $this -> account_model -> create($data -> fullname, $data -> fb_id.'@canvasdefault.com', $birthday);
					//, $competition->start_credit);

					$details['firstname'] = $data -> firstname;
					$details['lastname'] = $data -> lastname;
					$details['fullname'] = $data -> fullname;
					$details['dateofbirth'] = $birthday;
					$details['gender'] = $data -> gender;
					$details['picture'] = 'http://graph.facebook.com/'.$data -> fb_id.'/picture';

					$this -> account_details_model -> update($user_id, $details);

					$this -> account_facebook_model -> insert($user_id, $data -> fb_id, $data -> token);

					// Run sign in routine
					$this -> authentication -> sign_in($user_id);
				}
			}
		// Load fb utils ...
// This is a call from redirect_fb
		if($accountid)
		{
			log_message('error', 'redirect_fb sent back to Core account id = ' .$accountid);
//			if(!$sitecode)
//				$sitecode = 6;
			$provider = $this->session->userdata('provider');
                        if($provider == 'facebook'){
                            $mode = '1';
                        } elseif($provider == 'twitter'){
                            $mode = '2';
                        } elseif($provider == 'google'){
                            $mode = '3';
                        }
			// Redirect to Platform with account ID parameter ...
			$redirect_url =  (($sitecode)?$this->getSiteUrl($sitecode):$this->session->userdata('admin_page')). '?accountid='.$accountid.'&mode='.$mode;
			log_message('error', 'SAFARIIIIII 111 reditecttt toooo ->> ' . $redirect_url);
			redirect($redirect_url);
		}


		// Platform sends a mode parameter = "signin" ...
		// As now we only support Facebook Login, this code redirects to check Facebook login ...
		if($mode == 'signin')
		{
			
			$cnt ++;
			log_message('error', 'core.php: mode ====== sign in : '.$mode);
			$_SESSION['sitecode'] = $sitecode;
			log_message('error', 'core 3 Jul :Added site code to session, redirecting to redirect_fb');
			
			// trying to check if user is logged in
			// 
			$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
			));

			log_message('error', 'core 3 Jul : defined facebook variable ...');

		//		log_message('error', 'redirect_fb: Site Code: ' . $_SESSION['sitecode']);

			// Try to get a logged in facebook user ID ...
			$fb_id = $facebook->getUser();
			
			log_message('error', 'core 3 Jul : called getUser ...');
			
			log_message('error', 'core 3 Jul: Check this Facebook ID ->>> : ' . $fb_id );
			log_message('error', 'core 3 Jul: Check this Session ->>> : ' . print_r($_SESSION, TRUE));
			// Load facebook redirect view
			redirect('account/redirect_fb');
		} else if($mode == 'google') {
                    $cnt ++;
                    log_message('error', 'core.php: mode ====== sign in : '.$mode);
                    $_SESSION['sitecode'] = $sitecode;
                    log_message('error', 'core 3 Jul :Added site code to session, redirecting to redirect_fb');

                    // trying to check if user is logged in
                    // 
//                    $facebook = new Facebook(array(
//                            'appId' => '170161316509571',
//                            'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
//                            'cookie' =>true
//                    ));

                    log_message('error', 'core 3 Jul : defined facebook variable ...');
                    // Try to get a logged in facebook user ID ...
//                    $fb_id = $facebook->getUser();

                    log_message('error', 'core 3 Jul : called getUser ...');

//                    log_message('error', 'core 3 Jul: Check this Facebook ID ->>> : ' . $fb_id );
                    log_message('error', 'core 3 Jul: Check this Session ->>> : ' . print_r($_SESSION, TRUE));
                    // Load facebook redirect view
                    redirect('account/connect_google');
                } else if($mode == 'twitter') {
                    $cnt ++;
                    log_message('error', 'core.php: mode ====== sign in : '.$mode);
                    $this->session->set_userdata('sitecode', $sitecode);
                    log_message('error', 'core 3 Jul :Added site code to session, redirecting to redirect_fb');

                    // trying to check if user is logged in
                    // 
//                    $facebook = new Facebook(array(
//                            'appId' => '170161316509571',
//                            'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
//                            'cookie' =>true
//                    ));

                    log_message('error', 'core 3 Jul : defined facebook variable ...');
                    // Try to get a logged in facebook user ID ...
//                    $fb_id = $facebook->getUser();

                    log_message('error', 'core 3 Jul : called getUser ...');

//                    log_message('error', 'core 3 Jul: Check this Facebook ID ->>> : ' . $fb_id );
                    log_message('error', 'core 3 Jul: Check this Session ->>> : ' . print_r($_SESSION, TRUE));
                    // Load facebook redirect view
                    redirect('account/connect_twitter');
                }

		// Handle a redirect coming from Facebook ...
		if($code){
			$cnt ++;
			log_message('error', 'Code parameter is here, this is a redirect from Facebook ...');
			log_message('error', 'Still have the site code !! ?? = ' .$_SESSION['sitecode']);

			// For an unknown reason, the redirection back to redirect_fb do not preserve FB login ...
			// Here loading the Facebook UID after redirection from Facebook for no good reason ...
			$facebook = new Facebook(array(
					'appId' => '170161316509571',
					'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
					'cookie' =>true
			));

			log_message('error', 'Trying to get facebook ID from core.php ...');

			// Try to get a logged in facebook user ID ...
			$session = $facebook->getUser();

			log_message('error', 'facebook user id from core.php : ' . $session);

			// Load facebook redirect view ... When we redirect here, the User ID is obtained successfully in redirect_fb
			redirect('account/redirect_fb');
		}

		// Handle a redirect from Core (create_connect, or else) ...
		if($this->authentication->is_signed_in()) {
			log_message('error', ' SIGNED IN: ');
			$cnt ++;
			if($this->session->userdata('account_id'))
			{
				log_message('error', 'connect_create sent back to Core account id = ' .$this->session->userdata('account_id'));
			}
			else
			{
				log_message('error', 'connect_create sent back to Core  and cannot get account ID');
			}
                    // Check user's created on date in order to give him competetion's default credit
                        $this->load->model('competition_model');
                        $this->load->model('credit_model');
                        if(!isset($_SESSION['sitecode'])){
                            $sitecode = 5;
                        } else {
                                $sitecode = $_SESSION['sitecode'];
                        }
                        $competition = ($sitecode)?$this->competition_model->get_current_competition($sitecode):0;
                        if($competition){
                            $this->credit_model->buy_credit($this->session->userdata('account_id'), $competition->start_credit);
                        }
                        $mode = $this->session->userdata('mode');
                        log_message('error', 'core index() inside signed in->> $mode=' . $mode);
                        if($mode == 'signin'){
                            $mode = '1';
                        } elseif($mode == 'twitter'){
                            $mode = '2';
                        } elseif($mode == 'google'){
                            $mode = '3';
                        }
                        
                    // Redirect to Platform with account ID parameter ...
			$redirect_url =  (($sitecode)?$this->authentication->getSiteUrl($sitecode):$this->session->userdata('admin_page')). '?accountid='.$this->session->userdata('account_id').'&mode='.$mode;
			log_message('error', 'SAFARIIIIII 222 reditecttt toooo ->> ' . $redirect_url);
			redirect($redirect_url);
		} else {
                    log_message('error', 'NOT SIGNED IN: ');
                }
		if ($cnt == 0){
			log_message('error', 'teeeeeet1 session = ' . print_r($_SESSION, TRUE));
			log_message('error', 'teeeeeet1 account id ellye fyl session' . print_r($this->session->userdata('account_id'), TRUE));
			$this->load_competitions($this->input->get('accountid'));
                } else {
                        log_message('error', 'teeeeeet session = ' . print_r($_SESSION, TRUE));
                        log_message('error', 'teeeeeet account id ellye fyl session' . print_r($this->session->userdata('account_id'), TRUE));
                }
	}
	

	function logout() {
		$this->auth->logout();
	}
        function submit_message(){
            $data = array(
                'name' =>  $this->input->post('name'),
                'email' => $this->input->post('email') ,
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message')
                    );
            $this->load->model('home_model');
            if($this->home_model->insert_message($data) == FALSE){
                echo -1;
            }
        }
        
//        function add_new_user(){ //($fb_id,$username,$fullname,$firstname,$lastname,$email,$birthday, $appCode){
//            $fb_id = 165184646846;
//            $username = 'usernamee';
//            $firstname = 'firstnamee';
//            $lastname = 'lastnamee';
//            $fullname = 'fullnamee';
//            $email = 'emaill@emaill.emaill';
//            $birthday = '17/10/1990';
//            $appCode = '4';
//            // Get competition credit
//            $this->load->model('competition_model');
//            $this->load->model('credit_model');
//            $this->load->model('account/account_details_model');
////            $this->load->model('credit_model');
//            $competition = $this->competition_model->get_current_competition($appCode);
//            // Create user and giving him credit from default competition credit
//            $user_id = $this->account_model->create($username, $email, $birthday, $competition->start_credit);
//            // Add user details
//            $data['fullname'] = $fullname;
//            $data['firstname'] = $firstname;
//            $data['lastname'] = $lastname;
//            //$data['email'] = $email;
//            $data['dateofbirth'] = $birthday;
//            $this->account_details_model->update($user_id, $data);
//            // Add user facebook information
//            $this->account_facebook_model->insert($user_id, $fb_id, -1);
//        }

}
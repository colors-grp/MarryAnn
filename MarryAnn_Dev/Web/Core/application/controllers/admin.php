<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Admin extends CI_Controller {
        protected  $crud;
	public function __construct(){
		parent::__construct();
		$this->load->database();
                $helper = array('url');
		$this->load->helper($helper);
                $library = array('account/authentication', 'account/authorization');
                $this->load->library($library);
                $model = array('account/account_model','competition_model');
		$this->load->model($model);
	}
        
	function index() {
        /*
            $accountid = $this->input->get('accountid');
            $mode = $this->input->get('mode');
//            if(!$this->session->userdata('language')){
//                $this->session->set_userdata('language', 'english');
//            }
            log_message('error', 'admin_page index() before if signed in account id = '. $accountid);
//            $this->authentication->sign_out();
//            if(!$accountid && $this->authentication->is_signed_in()){
//                $this->authentication->sign_out();
//            }
        // Check if user is signed in
            if($this->authentication->is_signed_in()){
            // Get and check if user is an admin
                $accountid = $this->session->userdata('account_id');
                log_message('error','admin_page index() user logged in $account_id='.$accountid);
//                $this->session->set_userdata('account_id', 1);
                if($this->core_call->getUserType($this->session->userdata('account_id')) == 'admin') {
                // Check all tables if exist and create if not
                    if($this->check_create_all_tables()){
                        redirect(site_url('admin_page/type'));
                    } else { // if tables already created then Get AND Check platform type
                        $temp = $this->platform_model->get_my_type();
                        $site_type = ( count($temp) )?$temp[0]['type']:0;
                        if($site_type){ // if platform type was selected
                            $result = $this->core_call->isCompetitionAdmin($accountid, $temp[0]['id']);
                            log_message('error','admin_page index() user logged in $result='. $result);
                            if($result == 1){
                                redirect(site_url('admin_page/category'));
                            } else {
                                $accountid = $this->session->userdata('account_id');
                                $this->authentication->sign_out();
                                echo $result.'<br /><br />';
                            }
                        } else { // if platform type was not selected
                            redirect(site_url('admin_page/type'));
                        }
                    }
                } else {
                    $accountid = $this->session->userdata('account_id');
                    $this->authentication->sign_out();
                    echo 'Go Home Man!!!'.'<br /><br />';
                    echo 'Your id='.$accountid.'<br /><br />';
                    echo 'Your type='.$this->core_call->getUserType($accountid).'<br /><br />';
//                    $this->authentication->sign_out();
//                    redirect(site_url('admin_page'));
                }
            }
        // This is true for redirections from Core ...
            if($accountid)
            {
                    $this->session->set_userdata('account_id', $accountid);
                    if($mode == 1){ // Facebook
			$fb = json_decode($this->core_call->fb_get_by_account_id($accountid));
                        log_message('error','admin_page index() $fb='.  print_r($fb,TRUE));
			$this->session->set_userdata('provider_id', $fb[0]->facebook_id);
			log_message('error', 'admin_page FB ID = ' . $fb[0]->facebook_id);
                        $me = $this->core_call->getMe($accountid);
                        log_message('error', 'admin_page FB $me= ' . print_r($me,1));
                        $this->session->set_userdata('username', $me->fullname);
                    } elseif ($mode == 2){ // Twitter
                        $tw = json_decode($this->core_call->tw_get_by_account_id($accountid));
                        log_message('error','admin_page index() $tw='.  print_r($tw,TRUE));
                        $this->session->set_userdata('provider_id', $tw[0]->twitter_id);
                        log_message('error', 'redirect 3la platform, TW ID = ' . $tw[0]->twitter_id);
                        $me = json_decode($this->core_call->get_by_id($accountid));
                        log_message('error', 'redirect 3la platform, TW from a3m_account $me= ' . print_r($me,1));
                        $this->session->set_userdata('username', $me->username);
                    }
                    $this->session->set_userdata('provider', $mode);
                    $this->session->set_userdata('admin', 1);
                    log_message('error', 'admin_page index() back from core !!! account id = '. $accountid .' mode='.$mode);
                    $this->authentication->sign_in($accountid);
            }
        // Load admin's home view
            $this->load->view('pages/admin/home_view');
         * 
         */
	}
        
        // Check and Load admin sign in process
        function sign_in(){
            $accountid = $this->input->get('accountid');
            $mode = $this->input->get('mode');
//            $this->session->set_userdata('admin_page', base_url(''));
            if($this->authentication->is_signed_in()){
                $user = $this->account_model->get_by_id($accountid);
                if($user && $user->type == 'admin'){
                    redirect('admin/home');
                } else {
                    $this->authentication->sign_out();
                }
            } elseif($accountid) { // This is true for redirections from Core ...
                    $this->session->set_userdata('account_id', $accountid);
                    $this->session->set_userdata('mode', $mode);
//                    $this->session->set_userdata('admin_page', base_url());
                    $this->authentication->sign_in($accountid);
            }
            $this->load->view('admin/signin_view');
        }
        
        // Initialize admin data and view
        function home(){
            if($this->authentication->is_signed_in()){
                $accountid = $this->session->userdata('account_id');
                $a_coms = $this->competition_model->get_admin_competitions($accountid);
                $site_info = array();
                foreach ($a_coms as $a_com){
                    $com = $this->competition_model->get_current_competition($a_com['site_code']);
                    array_push($site_info, $com);
                }
                $data['site_info'] = $site_info;
                $data['user_id'] = $accountid;
                $this->load->view('admin/home_view',$data);
            } else {
                redirect('admin/sign_in');
            }
        }
        
        // Sign out and go to base_url()
        function go_home(){
            if($this->authentication->is_signed_in()){
                $this->authentication->sign_out();
            }
            redirect(site_url());
        }
        
        // sign out and go to admin/sign in
        function sign_out(){
            if($this->authentication->is_signed_in()){
                    $this->authentication->sign_out();
            }
            redirect(site_url('admin/sign_in'));
        }
}
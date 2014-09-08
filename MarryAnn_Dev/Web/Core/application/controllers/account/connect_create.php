<?php
/*
 * Connect_create Controller
 */
class Connect_create extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		$this->load->library(array('account/authentication', 'account/authorization', 'form_validation'));
		$this->load->model(array('account/account_model', 'account/account_details_model', 'account/account_facebook_model', 'account/account_twitter_model', 'account/account_openid_model'));
		$this->load->language(array( 'account/connect_third_party'));
                $this->load->language('general','arabic');
	}

	/**
	 * Complete facebook's authentication process
	 *
	 * @access public
	 * @return void
	 */
	function index()
	{
		// Enable SSL?
		maintain_ssl(TRUE);

		// Redirect user to home if sign ups are disabled
		//if ( ! ($this->config->item("sign_up_enabled"))) redirect('');
                log_message('error','inside connect create CI_VERSION='.  print_r(CI_VERSION,1));
                log_message('error','inside connect create $this->session->userdata(connect_create)='.  print_r($this->session->userdata('connect_create'),1));
		// Redirect user to home if 'connect_create' session data doesn't exist
		if ( ! $this->session->userdata('connect_create')) redirect('');
                
		$data['connect_create'] = $this->session->userdata('connect_create');
                
                $this->session->set_userdata('provider', $data['connect_create'][0]['provider']);
                if($data['connect_create'][0]['provider'] == 'twitter'){
                    $MyData['username'] = $data['connect_create'][0]['username'];
                    $MyData['email'] = isset($data['connect_create'][0]['email'])?$data['connect_create'][0]['email']:'twitter_'.$data['connect_create'][0]['provider_id'].'@twitter.com';
                    $MyData['birthday'] = isset($data['connect_create'][1]['dateofbirth'])?$MyData['birthday'] = $data['connect_create'][1]['dateofbirth']:date('d-m-Y');
                } else {
                    $MyData['username'] = $data['connect_create'][0]['provider_UN'];
                    $MyData['email'] = $data['connect_create'][0]['provider_email'];
                    $MyData['birthday'] = $data['connect_create'][1]['dateofbirth'];
                }

		// Setup form validation
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		$this->form_validation->set_rules(array(array('field' => 'connect_create_username', 'label' => 'lang:connect_create_username', 'rules' => 'trim|required|min_length[2]'),
												array('field' => 'connect_create_email', 'label' => 'lang:connect_create_email', 'rules' => 'trim|required|valid_email|max_length[160]'),
												array('field' => 'connect_create_birthday', 'label' => 'lang:connect_create_birthday', 'rules' => 'trim|required|min_length[2]')));
                log_message('error','after setting $MyData= '.  print_r($MyData,1));
		// Run form validation
		if ($this->form_validation->run())
		{
//			// Check if username already exist
//			if ($this->username_check($this->input->post('connect_create_username', TRUE)) === TRUE)
//			{
//				$data['connect_create_username_error'] = lang('connect_create_username_taken');
//			}
//			// Check if email already exist
//			else 
                            if ($this->email_check($this->input->post('connect_create_email'), TRUE) === TRUE)
			{
				$data['connect_create_email_error'] = lang('connect_create_email_exist');
			}
			else
			{
				// Destroy 'connect_create' session data
				$this->session->unset_userdata('connect_create');
				// Create user
				$user_id = $this->account_model->create($this->input->post('connect_create_username', TRUE), $this->input->post('connect_create_email', TRUE), $this->input->post('connect_create_birthday', TRUE));
                                log_message('error','after user id ='.  print_r($user_id,1));
				// Add user details
				$this->account_details_model->update($user_id, $data['connect_create'][1]);
                                log_message('error','after $this->account_details_model->update');
				// Connect third party account to user
				switch ($data['connect_create'][0]['provider'])
				{
					case 'facebook':
						$this->account_facebook_model->insert($user_id, $data['connect_create'][0]['provider_id'], $data['connect_create'][0]['access_token']);
						break;
					case 'twitter':
						$this->account_twitter_model->insert($user_id, $data['connect_create'][0]['provider_id'], $data['connect_create'][0]['token'], $data['connect_create'][0]['secret']);
						break;
					case 'openid':
						$this->account_openid_model->insert($data['connect_create'][0]['provider_id'], $user_id);
						break;
				}
                                log_message('error','after inserting into DB');
				// Run sign in routine
				$this->authentication->sign_in($user_id);
                                log_message('error','before = $this->authentication->sign_in => '.  print_r($this->authentication->is_signed_in(),1));
			}
		}

		$this->load->view('account/connect_create', $MyData);
	}

	/**
	 * Check if a username exist
	 *
	 * @access public
	 * @param string
	 * @return bool
	 */
	function username_check($username)
	{
		return $this->account_model->get_by_username($username) ? TRUE : FALSE;
	}

	/**
	 * Check if an email exist
	 *
	 * @access public
	 * @param string
	 * @return bool
	 */
	function email_check($email)
	{
		return $this->account_model->get_by_email($email) ? TRUE : FALSE;
	}

}

/* End of file connect_create.php */
/* Location: ./application/account/controllers/connect_create.php */

<?php
/*
 * Connect_google Controller
 */
class Connect_google extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url', 'account/openid'));
		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array('account/account_model', 'account/account_openid_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}


	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));

		// Get OpenID store object
		//$store = new Auth_OpenID_FileStore($this->config->item("openid_file_store_path")); OLD CODE
		// Get OpenID consumer object
		//$consumer = new Auth_OpenID_Consumer($store); OLD CODE
                $code = $this->input->get('code');
		if ($code)
		{
                    if($code == '3'){// came back after asking for user info
                        
                    } else { // just came with user's acceptance for the permissions
                    // Asking google for users info with given code
                        $endPoint_link = 'https://accounts.google.com/o/oauth2/token?';
                        $data = array(
                            'redirect_uri' => 'http://dev.hitseven.net/MarryAnn/Web/Core/index.php?/account/connect_google/?code=3', // match the one at console.developers.google.com
                            'code' => $code,
                            'client_id' => '34557101070-qk44cqfavkbhetubbmmjgdb5t64le1ii.apps.googleusercontent.com',
                            'client_secret' => 'fndpGsHgrZpgaUWaX2DnOyCi',
                            'grant_type' => 'authorization_code'
                        );
                        $auth_request = $endPoint_link;
                        while (($attr = current($data)) !== FALSE) {
                            $key_name = key($data);
                            $auth_request .= $key_name . '=' . $data[$key_name];
                            next($data);
                            if(($attr = current($data)) !== FALSE){
                                $auth_request .= '&';
                            }
                        }
                        log_message('error','before Redirect to authorizate URL='.  print_r($auth_request,1));
                        // Redirect to authorizate URL
                        header("Location: ".$auth_request);
                    }
                    parse_str($_SERVER['QUERY_STRING'], $_GET);
                    log_message('error','connect_google after back from google -> get='.print_r($_GET,1));
                    $code = $this->input->get('code');
                    log_message('error','connect_google after back from google -> code='.print_r(urldecode($code),1));

			// Complete authentication process using server response
			$response = $consumer->complete(site_url('account/connect_google'));

			// Check the response status
			if ($response->status == Auth_OpenID_SUCCESS)
			{
				// Check if user has connect google to a3m
				if ($user = $this->account_openid_model->get_by_openid($response->getDisplayIdentifier()))
				{
					// Check if user is not signed in on a3m
					if ( ! $this->authentication->is_signed_in())
					{
						// Run sign in routine
						$this->authentication->sign_in($user->account_id);
					}
					$user->account_id === $this->session->userdata('account_id') ? $this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_this_account'), lang('connect_google'))) : $this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_another_account'), lang('connect_google')));
					redirect('account/account_linked');
				}
				// The user has not connect google to a3m
				else
				{
					// Check if user is signed in on a3m
					if ( ! $this->authentication->is_signed_in())
					{
						$openid_google = array();

						if ($ax_args = Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response))
						{
							$ax_args = $ax_args->data;
							if (isset($ax_args['http://axschema.org/namePerson/friendly'][0])) $openid_google['username'] = $ax_args['http://axschema.org/namePerson/friendly'][0];
							if (isset($ax_args['http://axschema.org/contact/email'][0])) $email = $ax_args['http://axschema.org/contact/email'][0];
							if (isset($ax_args['http://axschema.org/namePerson'][0])) $openid_google['fullname'] = $ax_args['http://axschema.org/namePerson'][0];
							if (isset($ax_args['http://axschema.org/birthDate'][0])) $openid_google['dateofbirth'] = $ax_args['http://axschema.org/birthDate'][0];
							if (isset($ax_args['http://axschema.org/person/gender'][0])) $openid_google['gender'] = $ax_args['http://axschema.org/person/gender'][0];
							if (isset($ax_args['http://axschema.org/contact/postalCode/home'][0])) $openid_google['postalcode'] = $ax_args['http://axschema.org/contact/postalCode/home'][0];
							if (isset($ax_args['http://axschema.org/contact/country/home'][0])) $openid_google['country'] = $ax_args['http://axschema.org/contact/country/home'][0];
							if (isset($ax_args['http://axschema.org/pref/language'][0])) $openid_google['language'] = $ax_args['http://axschema.org/pref/language'][0];
							if (isset($ax_args['http://axschema.org/pref/timezone'][0])) $openid_google['timezone'] = $ax_args['http://axschema.org/pref/timezone'][0];
							if (isset($ax_args['http://axschema.org/namePerson/first'][0])) $openid_google['firstname'] = $ax_args['http://axschema.org/namePerson/first'][0]; // google only
							if (isset($ax_args['http://axschema.org/namePerson/last'][0])) $openid_google['lastname'] = $ax_args['http://axschema.org/namePerson/last'][0]; // google only
						}

						// Store user's google data in session
						$this->session->set_userdata('connect_create', array(array('provider' => 'openid', 'provider_id' => $response->getDisplayIdentifier(), 'email' => isset($email) ? $email : NULL), $openid_google));

						// Create a3m account
						redirect('account/connect_create');
					}
					else
					{
						// Connect google to a3m
						$this->account_openid_model->insert($response->getDisplayIdentifier(), $this->session->userdata('account_id'));
						$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_google')));
						redirect('account/account_linked');
					}
				}
			}
			// Auth_OpenID_CANCEL or Auth_OpenID_FAILURE or anything else
			else
			{
                                //$this->session->set_userdata('connect_create', array(array('provider' => 'google', 'provider_id' => $twitter_info['id'], 'username' => $twitter_info['screen_name'], 'token' => $twitter_token->oauth_token, 'secret' => $twitter_token->oauth_token_secret), array('fullname' => $twitter_info['name'], 'picture' => $twitter_info['profile_image_url'])));
                                //log_message('error','after set user data into session='.  print_r($this->session->userdata('connect_create'),1));
				$this->authentication->is_signed_in() ? redirect('account/account_linked') : redirect('account/connect_create');
			}
		}
                log_message('error','before $auth_request=');
		// Begin OpenID authentication process
		/*$auth_request = $consumer->begin($this->config->item("openid_google_discovery_endpoint"));
                log_message('error','after $auth_request='.print_r($auth_request,1));

		// Create ax request (Attribute Exchange)
		$ax_request = new Auth_OpenID_AX_FetchRequest;
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/friendly', 1, TRUE, 'username'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/email', 1, TRUE, 'email'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson', 1, TRUE, 'fullname'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/birthDate', 1, TRUE, 'dateofbirth'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/person/gender', 1, TRUE, 'gender'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/postalCode/home', 1, TRUE, 'postalcode'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/country/home', 1, TRUE, 'country'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/pref/language', 1, TRUE, 'language'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/pref/timezone', 1, TRUE, 'timezone'));
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/first', 1, TRUE, 'firstname')); // google only
		$ax_request->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/last', 1, TRUE, 'lastname')); // google only
		$auth_request->addExtension($ax_request);*/
            
            // Asking google for authorization code about certain permissions
                $endPoint_link = 'https://accounts.google.com/o/oauth2/auth?'; // This link is used to get users permission code
                $data = array(
                    'response_type' => 'code',
                    'client_id' => '34557101070-qk44cqfavkbhetubbmmjgdb5t64le1ii.apps.googleusercontent.com',
                    'redirect_uri' => 'http://dev.hitseven.net/MarryAnn/Web/Core/index.php?/account/connect_google/?code=3', // match the one at console.developers.google.com
//                    'scope' => 'plus%20login%20me%20userinfo%20email',
                    'scope' => 'email%20profile',
                    'state' => 'thisStringComesBackFromGoogle',
                    'approval_prompt' => 'force',
                    'login_hint' => 'email'
                );
                $auth_request = $endPoint_link;
                while (($attr = current($data)) !== FALSE) {
                    $key_name = key($data);
                    $auth_request .= $key_name . '=' . $data[$key_name];
                    next($data);
                    if(($attr = current($data)) !== FALSE){
                        $auth_request .= '&';
                    }
                }

                /*
                 * example full link
                 * https://accounts.google.com/o/oauth2/auth?scope=email%20profile&state=security_token%3D138r5719ru3e1%26url%3Dhttps://oa2cb.example.com/myHome&redirect_uri=https%3A%2F%2Foauth2-login-demo.appspot.com%2Fcode&,response_type=code&client_id=812741506391.apps.googleusercontent.com&approval_prompt=force
                 */
                
                
                log_message('error','before Redirect to authorizate URL='.  print_r($auth_request,1));
                
		// Redirect to authorizate URL
		header("Location: ".$auth_request);
	}

}


/* End of file connect_google.php */
/* Location: ./application/account/controllers/connect_google.php */
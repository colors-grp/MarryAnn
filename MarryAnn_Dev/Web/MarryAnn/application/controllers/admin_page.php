<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Admin_page extends CI_Controller {
	public function __construct() {
		parent::__construct ();

		$this->load->database ();
		$this->load->helper ( 'url' );
		$this->load->model('game_model');
		$this->load->library ( 'grocery_CRUD' );
	}
	function index() {
		$_SESSION['user_id'] = $this->session->userdata('account_id');
		$output ['tables'] = array (
				'competition',
				'category',
				'card',
				'rank'
		);
		$tables = $output['tables'];
		$output['output'] = array();
		for($i = 0; $i < count ( $tables ); $i ++) {
			$table = $tables[$i];
			$crud = new grocery_CRUD ();
			$crud->set_table ( $table );
			$crud->set_subject ( $table );
			$output['output'][$i] = $crud->render ();
		}
		$this->load->model('core_call');
		$me = $this->core_call->getMe($this->session->userdata('account_id'));
		$output['name'] = $me->fullname;
		$output['fb_id'] = $_SESSION['fb_id'];
		$this->load->view ( 'pages/admin_view', $output );
	}
	function show_table() {
		$crud = new grocery_CRUD ();
		$name = $this->input->post ( 'table_name' );
		$crud->set_table ( $name );
		$crud->set_subject ( $name );
		$output = $crud->render ();
		$this->load->view ( 'ajax/show_tables_view_ajax', $output );
	}
	function add_mcq_question () {
		log_message('error', 'da5al el function aho');
		if (isset($_POST['question'])) {
			$question = array(
					'content' => $_POST['question'], 
					'answer1' => $_POST['answer1'], 
					'answer2' => $_POST['answer2'], 
					'answer3' => $_POST['answer3'],
					'answer4' => $_POST['answer4'],
					'correct_answer' => $_POST['correct_answer']);
			$this->game_model->add_mcq_question($question);
			echo 'Success';
		}
		else {
			echo 'Failed';
		}
	}
}
<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Admin_page extends CI_Controller {
        protected  $crud;
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->helper ( 'url' );
                $this->load->library('Grocery_CRUD');
		$this->load->model('game_model');
                $this->load->model('category_model');
                $this->load->model('card_model');
                $this->load->model('platform_model');
		$this->load->model( 'grocery_crud_model' );
	}
	function index() {
        // Get and check if user is an admin
            
    // Get and check all tables rows
        // Get site Type
            $this->set_site_type(1, 2);
            $data['type'] = $this->get_site_type();
        // Get all Categories
//            if($data['type']){
//                $cat_id = 1;
//                $card = array(
//                    array(
//                        'id' => 1,
//                        'name' => 'هااااا',
//                        'category_id' => 1,
//                        'start_date' => date('Y-m-d'),
//                        'end_date' => NULL,
//                        'status' => 'inactive',
//                        'price' => 0,
//                        'score' => 20,
//                        'type_id' => 5
//                    ), 
//                    array(
//                        'id' => 4,
//                        'name' => 'هااااا',
//                        'category_id' => 2,
//                        'start_date' => date('Y-m-d'),
//                        'end_date' => NULL,
//                        'status' => 'inactive',
//                        'price' => 0,
//                        'score' => 20,
//                        'type_id' => 5
//                    ),
//                    array(
//                        'id' => 3,
//                        'name' => 'هااااا',
//                        'category_id' => 3,
//                        'start_date' => date('Y-m-d'),
//                        'end_date' => NULL,
//                        'status' => 'inactive',
//                        'price' => 0,
//                        'score' => 20,
//                        'type_id' => 5
//                    ),
//                );
//                $data['card'] = $this->insert_update_cards($cat_id, $card);
////                $data['category'] = $this->get_category()->result_array();
//            }
//            echo print_r($data,1).'<br />';
            
            
            
            
            //$_SESSION['user_id'] = $this->session->userdata('account_id');
            $output ['tables'] = array (
                            'category',
                            'card'
            );
//            log_message('error','after tables array');
            $tables = $output['tables'];
            $output['output'] = array();
            for($i = 0; $i < count ( $tables ); $i ++) {
                    $table = $tables[$i];
                    $crud = new grocery_CRUD();
                    $crud->set_table( $table );
                    $crud->set_subject( $table );                    
                    $output['output'][$i] = $crud->render();
            }
            $this->load->model('core_call');
            $me = $this->core_call->getMe(1);
            $output['name'] = $me->fullname;
            $output['fb_id'] = 6543541878;
            $this->load->view ( 'pages/admin_view', $output );
	}
        
        function tables(){
            $output ['tables'] = array (
                            'category'
            );
//            log_message('error','after tables array');
            $tables = $output['tables'];
            $output['output'] = array();
            for($i = 0; $i < count ( $tables ); $i ++) {
                    $table = $tables[$i];
                    $crud = new grocery_CRUD();
                    $crud->set_table( $table );
                    $crud->set_subject( $table );
                    $crud->callback_after_insert(array($this, 'tables'));
                    $crud->callback_after_update(array($this, 'tables'));
                    $output['output'][$i] = $crud->render();
            }
            $this->load->model('core_call');
            $me = $this->core_call->getMe(1);
            $output['name'] = $me->fullname;
            $output['fb_id'] = 6543541878;
            $this->load->view ( 'pages/admin_view', $output );
        }
        
        // get site type and create new table with dummy row if not exists
        // Inputs: none.
        // Output: type.
        function get_site_type(){
//            $crud = new grocery_CRUD_Model();
            $table_name = 'platform_type';
            $this->grocery_crud_model->set_basic_table($table_name);
            if(!$this->grocery_crud_model->db_table_exists($table_name)){
                $fields = array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 1, 
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                        ),
                    'type' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '1',
                        ),
                );
                $keys = array(
                    'id'
                );
                $this->grocery_crud_model->db_create_table($table_name,$fields, $keys);
                $data = array ('id' => 1,'type' => 0);
                $this->grocery_crud_model->db_insert($data, $table_name);
            }
            return $this->grocery_crud_model->get_row($table_name)->type;
        }
        
        function set_site_type($id, $type){
            $this->platform_model->update($id,$type);
        }
        
        
        // get category and create new table if not exists
        // Inputs: none.
        // Output: all categories.
        function get_category(){
            $table_name = 'category';
            if(!$this->grocery_crud_model->db_table_exists($table_name)){
                $fields = array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        'auto_increment' => TRUE,
                        ),
                    'name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100'
                        ),
                    'created' => array(
                        'type' => 'date',
                        'null' => TRUE,
                        ),
                    'status' => array(
                        'type' => 'enum(\'active\',\'inactive\')',
                        'null' => TRUE,
                        ),
                    'start_date' => array(
                        'type' => 'date',
                        'null' => TRUE,
                        ),
                    'end_date' => array(
                        'type' => 'date',
                        'null' => TRUE,
                        ),
                    'total_score' => array(
                        'type' => 'INT',
                        'constraint' => '11'
                        ),
                    'num_of_cards' => array(
                        'type' => 'INT',
                        'constraint' => '11'
                        ),
                    'rank' => array(
                        'type' => 'INT',
                        'constraint' => '11'
                        ),
                    'color' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '7'
                        ),
                );
                $keys = array('id');
                $this->grocery_crud_model->db_create_table($table_name,$fields, $keys);
            }
            return $this->category_model->get_all_category();
        }
        
        
        // insert new category into DB OR update its information, Get all categories
        // Input: list data.
        // Outputs: list of categories
        function insert_update_category($cat_name, $status, $start_date, $end_date, $color, $created = 0, $num_of_cards=0, $total_score=0, $rank=NULL, $cat_id=0){
        // Check if category name not in the DB
            $category_by_name = $this->category_model->get_category_by_name($cat_name);
            $category_by_id = $this->category_model->get_category_by_id($cat_id);
            if($cat_id){
                if($category_by_id == FALSE){// if admin want to update a non inserted category
                    return 3;
                }
            }else{
                if(count($category_by_name)){// if category name already created
                    return 2;
                }
            }
        // Initialize insertion array
            $data = array(
                'name' => $cat_name,
                'created' => ($created)?$created:date('Y-m-d'),
                'status' => $status,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_score' => $total_score,
                'num_of_cards' => $num_of_cards,
                'rank' => ($rank=0)?NULL:$rank,
                'color' => $color,
            );
        // Check if admin want to add new category or update
            if($cat_id){
                $this->category_model->update_category($cat_id,$data);
            } else {
                $this->category_model->insert_new_category($data);
            }
            return $this->category_model->get_all_category();
        }
        
        // Change the category status into inactive
        // Input: category id.
        // Output: list of categories.
        function in_active_category($cat_id,$status){
            $category_by_id = $this->category_model->get_category_by_id($cat_id);
            if($cat_id){
                if($category_by_id == FALSE){// if admin want to update a non inserted category
                    return 2;
                }
            }
            $data = array(
                'status' => $status
            );
            $this->category_model->update_category($cat_id, $data);
            return $this->category_model->get_all_category();
        }
        
        
        // get category's cards and create new table if not exists
        // Inputs: none.
        // Output: all categories.
        function get_cards($cat_id){
            $table_name = 'card';
            if(!$this->grocery_crud_model->db_table_exists($table_name)){
                $fields = array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        'auto_increment' => TRUE,
                        ),
                    'name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '50',
                        'collation' => 'utf8_general_ci',
                        'unique' => TRUE
                        ),
                    'category_id' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        ),
                    'created' => array(
                        'type' => 'date',
                        'null' => TRUE,
                        ),
                    'start_date' => array(
                        'type' => 'date',
                        'null' => TRUE,
                        ),
                    'end_date' => array(
                        'type' => 'date',
                        'null' => TRUE,
                        ),
                    'status' => array(
                        'type' => 'enum(\'active\',\'inactive\')',
                        'null' => TRUE,
                        ),
                    'price' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        'null' => TRUE,
                        ),
                    'score' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        'null' => TRUE,
                        ),
                    'type_id' => array(
                        'type' => 'INT',
                        'constraint' => '11',
                        'default' => 0,
                        ),
                );
                $keys = array('id','category_id');
                $this->grocery_crud_model->db_create_table($table_name,$fields, $keys);
            }
            //echo 'after if condition'.'<br />';
            $cards = $this->card_model->get_cards_by_id($cat_id);
            return ($cards != FALSE)?$cards->result_array():array();
        }
        
        // insert new card into DB OR update its information, Get all categories
        // Input: list data.
        // Outputs: list of categories
        function insert_update_cards($cat_id, $card){
        // Check if category exists
            $category_by_id = $this->category_model->get_category_by_id($cat_id);
            if($cat_id){
                if($category_by_id == FALSE){// if admin want to update a non inserted category
                    return 2;
                }
            }
            echo 'category exists'.'<br />';
        // Check if all cards exist
            for($i=0; $i<count($card); $i++){
                if(isset($card[$i]['id'])){
                    if(count($this->card_model->get_card_by_name($card[$i]['name'])) == 0){
                        return 2;
                    }
                }
            }
            echo 'after for loop'.'<br />';
        // Update all cards
            for($i=0; $i<count($card); $i++){
                $data = array (
                    'name' => $card[$i]['name'],
                    'category_id' => $card[$i]['category_id'],
                    'created' => isset($card[$i]['created'])?$card['created']:date('Y-m-d'),
                    'start_date' => $card[$i]['start_date'],
                    'end_date' => $card[$i]['end_date'],
                    'status' => $card[$i]['status'],
                    'price' => $card[$i]['price'],
                    'score' => $card[$i]['score'],
                    'type_id' => $card[$i]['type_id']
                );
            // Check if admin want to update or insert then do it.
                if(isset($card[$i]['id'])){
                    $this->card_model->update_card($cat_id,$data);
                } else {
                    $this->card_model->insert_card($data);
                }
                echo $i.' after insert/update'.'<br />';
            }
        // Get all cards from given category
            $cards = $this->card_model->get_cards_by_id($cat_id);
            return ($cards != FALSE)?$cards->result_array():array();
        }
        
        function in_active_cards($cat_id, $cards){
            
        }
        
        function get_credit($platform_id=0){
            
        }
        
        function set_credit($ploatform_id, $credit){
            
        }
        
//	function show_table() {
//		$crud = new grocery_CRUD ();
//		$name = $this->input->post ( 'table_name' );
//		$crud->set_table ( $name );
//		$crud->set_subject ( $name );
//		$output = $crud->render ();
//		$this->load->view ( 'ajax/show_tables_view_ajax', $output );
//	}
//	function add_mcq_question () {
//		log_message('error', 'da5al el function aho');
//		if (isset($_POST['question'])) {
//			$question = array(
//					'content' => $_POST['question'], 
//					'answer1' => $_POST['answer1'], 
//					'answer2' => $_POST['answer2'], 
//					'answer3' => $_POST['answer3'],
//					'answer4' => $_POST['answer4'],
//					'correct_answer' => $_POST['correct_answer']);
//			$this->game_model->add_mcq_question($question);
//			echo 'Success';
//		}
//		else {
//			echo 'Failed';
//		}
//	}
}
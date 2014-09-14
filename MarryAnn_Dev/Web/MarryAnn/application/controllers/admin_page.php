<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Admin_page extends CI_Controller {
        protected  $crud;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
                $this->load->library('Grocery_CRUD');
		$this->load->model('game_model');
                $this->load->model('category_model');
                $this->load->model('card_model');
                $this->load->model('core_call');
                $this->load->model('platform_model');
                $this->load->model('pack_model');
		$this->load->model('grocery_crud_model');
//                $this->load->library('gc_dependent_select');
	}
	function index(){
        // Get and check if user is an admin
            
        // Check all tables if exist and create if not
            if($this->check_create_all_tables()){
                redirect(site_url('admin_page/type'));
            } else {
                redirect(site_url('admin_page/category'));
            }
	}
        
        // Check AND Create all tables.
        // Input: none.
        // Output: none.
        function check_create_all_tables(){
        // Check and import all tables if platform_table was not exist
            $table_name = 'platform_type';
            $this->grocery_crud_model->set_basic_table($table_name);
            if(!$this->grocery_crud_model->db_table_exists($table_name)){
                $this->createAllTables();
                return FALSE;
            } else {
                return TRUE;
            }
        }
        
        // Return a view.
        // Input: none.
        // Output: view.
        function type(){
            $output ['tables'] = array (
                            'platform_type'
            );
            $tables = $output['tables'];
            $output['output'] = array();
            for($i = 0; $i < count ( $tables ); $i ++) {
                    $table = $tables[$i];
                    $crud = new grocery_CRUD();
                    $crud->set_table( $table )
                    ->set_subject( $table )
                    ->unset_edit()
                    ->unset_delete()
                    ->unset_add();
//                    ->unset_print();
                    $output['output'][$i] = $crud->render();
            }
            $temp = $this->platform_model->get_my_type();
            $output['site_type'] = (count($temp))?$temp[0]['type']:0;
            $me = $this->core_call->getMe(1);
            $output['name'] = $me->fullname;
            $output['fb_id'] = 6543541878;
            $this->load->view ( 'ajax/admin/type_view', $output );
        }
        
        // Get only one row from platform_type table.
        // Inputs: none.
        // Output: type.
        function get_site_type(){
            $table_name = 'platform_type';
            return $this->grocery_crud_model->get_row($table_name);
        }
        
        // Update platform type
        function set_site_type($id=0,$type=0){
        // Get Input
            $type = $this->input->post('type');
            $name = $this->input->post('name');
            $start = $this->input->post('start');
            $end = $this->input->post('end');
            $round = $this->input->post('round');
            $credit = $this->input->post('credit');
            $data = array (
                    'url' => base_url(),
                    'name' => $name,
                    'type' => $type,
                    'start_date' => $start,
                    'end_date' => $end,
                    'round' => $round,
                    'start_credit' => $credit
                );
            $myId = $this->core_call->getNewSiteCode($data);
        // Update platform type
            if($myId != 'This site already has been registered'){
                $data['id'] = $myId;
                $this->platform_model->insert($data);
            // Go next into category view
                redirect(site_url('admin_page/category/'));
            } else {
                $data = array(
                  'error' => 1  
                );
                redirect(site_url('admin_page/type/error/'. $data['error']));
            }
        }
        
        // Return a view.
        // Input: none.
        // Output: view.
        function category(){
            $output ['tables'] = array (
                            'category'
            );
            $tables = $output['tables'];
            $output['output'] = array();
            for($i = 0; $i < count ( $tables ); $i ++) {
                    $table = $tables[$i];
                    $crud = new grocery_CRUD();
                    $crud->set_table( $table );
                    $crud->set_subject( $table )
//                    ->unset_edit()
                    ->unset_delete();
//                    ->unset_print();
                    $crud->required_fields('name','status','start_date','end_date','color');
                    $crud->fields('name','created','status','start_date','end_date','total_score','num_of_cards','rank','color');
                    $crud->unset_edit_fields('name','created','total_score','num_of_cards','rank');
                // invisible fields 
                    $crud->field_type('created', 'invisible');
                    $crud->field_type('total_score', 'invisible');
                    $crud->field_type('num_of_cards', 'invisible');
                    $crud->field_type('rank', 'invisible');
                // call back functions
                    $crud->callback_add_field('name',array($this,'category_name_add_field'));
                    $crud->callback_before_insert(array($this,'category_before_insert_callback'));
                    $crud->callback_edit_field('name',array($this,'category_name_edit_field'));
                // rules
                    $state = $crud->getState();
                    if($state == 'add'){
                        $crud->set_rules('name', 'name','callback_category_name_field_check');
                    }
                // unique fields
                    $crud->unique_fields('name');
                    $output['output'][$i] = $crud->render();
            }
            $table_name = 'platform_type';
            $output['site_type'] = $this->grocery_crud_model->get_row($table_name);
            $this->load->model('core_call');
            $me = $this->core_call->getMe(1);
            $output['name'] = $me->fullname;
            $output['fb_id'] = 6543541878;
            $this->load->view ( 'ajax/admin/category_view', $output );
        }
        
        function category_name_field_check($str){
            $str .= '_scoreboard';
            $fields = array('id'=>array('type' => 'INT'));
            $keys = array('id');
            log_message('error','inside category_name_field_check $str='.  print_r($str,1));
            if(!$this->session->userdata('tables_created')){
                if($this->grocery_crud_model->db_create_table($str, $fields, $keys)){
                    log_message('error','after db_create_table');
                    $this->grocery_crud_model->db_drop_table($str);
                    log_message('error','after db_drop_table');
                    $str = array($str, $str.'_1', $str.'_2');
                    $this->grocery_crud_model->db_copy_create_table($str,'temp_scoreboard');
    //                $this->grocery_crud_model->db_copy_create_table($str.'_1','temp_scoreboard');
    //                $this->grocery_crud_model->db_copy_create_table($str.'_2','temp_scoreboard');
                    log_message('error','after db_copy_create_table');
                    $this->session->set_userdata('tables_created', 'TRUE');
                    return TRUE;
                }
            } elseif ($this->session->userdata('tables_created') == 'TRUE') {
                $this->session->unset_userdata('tables_created');
                return TRUE;
            }
            $this->form_validation->set_message('category_name_field_check', 'The name already exists');
            return FALSE;
        }
        
        function category_before_insert_callback($post_array){
            $post_array['created'] = date('Y-m-d');
            $post_array['total_score'] = 0;
            $post_array['num_of_cards'] = 0;
            $post_array['rank'] = 0;
            return $post_array;
        }
        
        function category_name_add_field($value='',$primary_key){
            return '<input type="text" maxlength="50" value="'.$value.'" name="name" style="min-width: 270px;"> <B style="color: red;">*Unique field And Unchangeable.</B>';
        }
        
        function category_name_edit_field($value='',$primary_key){
            return '<input type="hidden" maxlength="50" value="'.$value.'" name="name" style="width:270px"> <B style="min-width: 270px; float: left;">'.$value.'</B><B style="color: red;">                *Category name unchangeable.</B>';
        }
        
        // Return a view
        // Input: none.
        // Output: view.
        function card(){
        // Get all categories from DB.
            $category = $this->category_model->get_all_category();
            $output['category'] = ($category != FALSE)?$category->result_array():array();
            $output['pack'] = $this->pack_model->get_all_packs();
        // Get input
            $cat_id = $this->input->post('category_id');
            $pack_id = $this->input->post('pack_id');
            $output['cat_id'] = $cat_id;
            $output['pack_id'] = $pack_id;
            $output ['tables'] = array (
                            'card'
            );
            $tables = $output['tables'];
            $output['output'] = array();
            for($i = 0; $i < count ( $tables ); $i ++) {
                $table = $tables[$i];
                $crud = new grocery_CRUD();
                $crud->set_table( $table );
                $crud->set_subject( $table );
                $crud->unset_delete();
            // Set relations with other tables
//                $crud->set_relation('category_id','category','id');
            // Set table view and fields rules
                $add_fields = array('name','category_id','pack_id','start_date','end_date','price','score','status');
                $crud->add_fields($add_fields);
                $crud->required_fields($add_fields);
                $crud->display_as('category_id','Category name')->display_as('pack_id','Pack name');
//                $crud->fields('name','start_date','end_date','price','score','status');
                $crud->columns('name','created','start_date','end_date','price','score','status');
                $crud->unset_edit_fields('name', 'category_id', 'created', 'pack_id');
            // call back functions
//                $crud->callback_before_insert(array($this,'card_before_insert_callback'));
                $crud->callback_after_insert(array($this, 'card_after_insert_callback'));
                $crud->callback_add_field('name',array($this,'card_name_add_field'));
                $crud->callback_add_field('category_id',array($this,'card_category_add_field'));
                $crud->callback_add_field('pack_id',array($this,'card_pack_add_field'));
                $crud->callback_edit_field('name',array($this,'card_name_edit_field'));
            //Check categories, set last selected category into session
                if( count($output['category']) ){
                    if($cat_id == 0 && $this->session->userdata('last_category') != 0){
                        log_message('error','card last_category='.print_r($this->session->userdata('last_category'),1));
                        $cat_id = $this->session->userdata('last_category');
                    } else if ($cat_id == 0){
                        log_message('error','card $output[category][0][id]='.print_r($output['category'][0]['id'],1));
                        $cat_id = $output['category'][0]['id'];
                    }
                    log_message('error','card $cat_id='.print_r($cat_id,1));
                    $this->session->set_userdata('last_category', $cat_id);
                    $output['cat_id'] = $cat_id;
                    $crud->where('category_id',$cat_id);
                } else {
                    $crud->unset_add();
                }
            // Get and check packs, set last selected pack into session
                if(count($output['pack'])){
                    if($pack_id == 0 && $this->session->userdata('last_pack') != 0){
                        log_message('error','card last_pack='.print_r($this->session->userdata('last_pack'),1));
                        $pack_id = $this->session->userdata('last_pack');
                    } else if ($pack_id == 0){
                        log_message('error','card $output[pack][0][id]='.print_r($output['pack'][0]['id'],1));
                        $pack_id = $output['pack'][0]['id'];
                    }
                    log_message('error','card $pack_id='.print_r($pack_id,1));
                    $this->session->set_userdata('last_pack', $pack_id);
                    $output['pack_id'] = $pack_id;
                    $crud->where('pack_id',$pack_id);
                } else {
                    $crud->unset_add();
                }
//                $crud->callback_edit_field('category_id',array($this,'card_edit_field_callback'));
//                $crud->field_type( 'category_id', 'integer', array( 1  => 1, 2 => 2, 3 => 3) );
//                ->unset_edit();
//                ->unset_delete()
//                ->unset_print();
                $output['output'][$i] = $crud->render();
            //DEPENDENT DROPDOWN SETUP
//                $dd_data = array(
//                //GET THE STATE OF THE CURRENT PAGE - E.G LIST | ADD
//                    'dd_state' =>  $crud->getState(),
//                //SETUP YOUR DROPDOWNS
//                //Parent field item always listed first in array, in this case countryID
//                //Child field items need to follow in order, e.g stateID then cityID
////                    'dd_dropdowns' => array('countryID','stateID','cityID'),
//                    'dd_dropdowns' => array('type_id','category_id'),
//                //SETUP URL POST FOR EACH CHILD
//                //List in order as per above
////                    'dd_url' => array('', site_url().'/examples/get_states/', site_url().'/examples/get_cities/'),
//                    'dd_url' => array(site_url('/admin_page/get_category_name'), site_url('admin_page/get_pack_name')),
//                    //LOADER THAT GETS DISPLAYED NEXT TO THE PARENT DROPDOWN WHILE THE CHILD LOADS
////                    'dd_ajax_loader' => base_url().'ajax-loader.gif'
//                );
//                $output->dropdown_setup = $dd_data;
            }
            $table_name = 'platform_type';
            $output['site_type'] = $this->grocery_crud_model->get_row($table_name);
            $this->load->model('core_call');
            $me = $this->core_call->getMe(1);
            $output['name'] = $me->fullname;
            $output['fb_id'] = 6543541878;
            $this->load->view ( 'ajax/admin/card_view', $output );
        }
        
        function card_name_add_field($value='',$primary_key){
            return '<input type="text" maxlength="50" value="'.$value.'" name="name" style="width:270px"> <B style="color: red;">*Unique field And Unchangeable.</B>';
        }
        
        function card_category_add_field($value='',$primary_key){
            $temp = $this->category_model->get_all_category();
            $categories = ($temp != FALSE)?$temp->result_array():array();
            $string = '<select name="category_id" style="width: 300px;">';
            foreach ($categories as $category){
                $string .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
            }
            $string .= '</select>';
            return $string;
        }
        
        function card_pack_add_field($value='',$primary_key){
            $packs = $this->pack_model->get_all_packs();
            $string = '<select name="pack_id" style="width: 300px;">';
            foreach ($packs as $pack){
                $string .= '<option value="'.$pack['id'].'">'.$pack['name'].'</option>';
            }
            $string .= '</select>';
            return $string;
        }
        
        function card_name_edit_field($value='',$primary_key){
            return '<input type="hidden" maxlength="50" value="'.$value.'" name="name" style="width:270px"> <B>'.$value.'</B><B style="color: red;">*Card name unchangeable.</B>';
        }
//        function card_before_insert_callback($post_array){
//            $post_array['created'] = date('Y-m-d');
//            log_message('error','card_before_insert_callback $post_array='.print_r($post_array,1));
//            $post_array['category_id'] = $this->session->userdata('last_category');
//            log_message('error','card_before_insert_callback $post_array='.print_r($post_array,1));
//            return $post_array;
//        }
        
        function card_after_insert_callback($post_array, $primary_key){
            log_message('error','card_after_insert_callback $post_array='.print_r($post_array,1));
            $post_array['start_date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post_array['start_date'])));
            $post_array['end_date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $post_array['end_date'])));
            $post_array['created'] = date("Y-m-d H:i:s");
            $this->card_model->update_card($primary_key,$post_array);
            log_message('error','card_after_insert_callback $post_array='.print_r($post_array,1));
            return TRUE;
        }
        
//        function card_edit_field_callback($value)
//        {
//            $string = '<select id="field-category_id" name="category_id" class="chosen-select chzn-done" data-placeholder="Select Category id" style="width: 300px; display: none;">';
//            $categories = $this->category_model->get_all_category();
//            log_message('error','card_edit_field_callback $categories='.print_r($categories->result_array(),1));
//            foreach($categories->result_array() as $category){
//                $string .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
//                //'.($category['id']==$value)?'selected="selected"':''.'
//            }
//            $string .= '</select>';
//            
//            $crud = new grocery_CRUD();
//            $crud->field_type('category_id','dropdown',
//            array('1' => 'active', '2' => 'private','3' => 'spam' , '4' => 'deleted'));
//            
//            
//            return $c;
//        }
        
        // Return a view
        // Input: none.
        // Output: view.
        function credit(){
            $output ['tables'] = array (
                            'platform_credit'
            );
            $tables = $output['tables'];
            $output['output'] = array();
            for($i = 0; $i < count ( $tables ); $i ++) {
                    $table = $tables[$i];
                    $crud = new grocery_CRUD();
                    $crud->set_table( $table );
                    $crud->set_subject( $table );
                    $crud->unset_delete();
                    $add_fields = array('name','day','daily_credit');
                    $crud->add_fields($add_fields);
                    $crud->edit_fields($add_fields);
                    $crud->required_fields($add_fields);
                    $crud->columns($add_fields);
                // call back functions
                    $crud->callback_add_field('name',array($this,'credit_platform_name_add_field'));
                    $crud->callback_edit_field('name',array($this,'credit_platform_name_edit_field'));
                    $crud->callback_edit_field('day',array($this,'credit_platform_day_edit_field'));
                    $crud->callback_update(array($this,'credit_update'));
                // rules
                    $this->session->set_userdata('state', $crud->getState());
                    $crud->set_rules('name', 'name', 'callback_credit_unique_day');
//                    ->unset_edit()
//                    ->unset_print();
                    $output['output'][$i] = $crud->render();
            }
            $this->load->model('core_call');
            $me = $this->core_call->getMe(1);
            $output['name'] = $me->fullname;
            $output['fb_id'] = 6543541878;
            $this->load->view ( 'ajax/admin/credit_view', $output );
        }
        
        function credit_platform_name_add_field($value, $primary_key){
            $names = $this->platform_model->get_all_platforms_names();
            $string = '<select name="name" style="width: 300px;">';
            foreach ($names as $name){
                $string .= '<option value="'.$name['name'].'">'.$name['name'].'</option>';
            }
            $string .= '</select>';
            return $string;
        }
        
        function credit_platform_name_edit_field($value='',$primary_key){
            return '<input type="hidden" maxlength="50" value="'.$value.'" name="name" style="width:270px"> <B style="min-width: 270px; float: left;">'.$value.'</B><B style="color: red;">*Platform name unchangeable.</B>';
        }
        
        function credit_platform_day_edit_field($value='',$primary_key){
            return '<input type="hidden" maxlength="50" value="'.$value.'" name="day" style="width:270px"> <B style="min-width: 270px; float: left;">'.$value.'</B><B style="color: red;">*Day unchangeable.</B>';
        }
        
        function credit_unique_day($name){
            if($this->session->userdata('state') == 'insert_validation'){
                $day = 1;//$this->input->post('day');
                $row = $this->platform_model->get_platform_by_name_day($name, $day);
                log_message('error','credit_unique_day $row'.print_r($row,1));
                if( count($row) ){
                    $this->form_validation->set_message('credit_unique_day', 'Day already exists for this platform, please edit it.');
                    return FALSE;
                }
            }
            return TRUE;
        }
        
        function credit_update($post_array, $primary_key) {
            log_message('error','credit_update $post_array='.print_r($post_array,1).' $primary_key='.print_r($primary_key,1));
            return $this->platform_model->update_platform_credit($primary_key, $post_array['day'], $post_array);
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
        function createAllTables(){
            $folder_name = 'database';
            $path = 'h7-assets';
            $this->load->helper('file');
            $this->load->helper('directory');
//            $files = directory_map('./h7-assets/database/');
            $file = 'hitsevey_db1.sql';
//            foreach ($files as $file){
            $file_restore = read_file('./'.$path.'/'.$folder_name.'/'.$file, true);
            $file_array = explode(';', $file_restore);
            foreach ($file_array as $query){
                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                $this->db->query($query);
                $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
            }
//            }
        }
}
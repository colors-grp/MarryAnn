<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Admin_page extends CI_Controller {
        protected  $crud;
	public function __construct(){
		parent::__construct();
		$this->load->database();
                $helper = array('url');
		$this->load->helper($helper);
                $library = array('account/authentication', 'account/authorization', 'Grocery_CRUD');
                $this->load->library($library);
                $model = array('game_model','category_model','card_model','pack_model','core_call','platform_model','grocery_crud_model');
		$this->load->model($model);
//                $this->load->library('gc_dependent_select');
	}
	function index(){
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
	}
        
        // Check AND Create all tables.
        // Input: none.
        // Output: boolean.
        function check_create_all_tables(){
        // Check and import all tables if platform_table was not exist
            $table_name = 'platform_type';
            $this->grocery_crud_model->set_basic_table($table_name);
            if(!$this->grocery_crud_model->db_table_exists($table_name)){
                $this->createAllTables();
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        // Return a view.
        // Input: none.
        // Output: view.
        function type(){
            if($this->authentication->is_signed_in()){
                $output ['tables'] = array (
                                'platform_type'
                );
                $tables = $output['tables'];
                $output['output'] = array();
                $temp = $this->platform_model->get_my_type();
                $output['site_type'] = ( count($temp) )?$temp[0]['type']:0;
                for($i = 0; $i < count ( $tables ); $i ++) {
                        $table = $tables[$i];
                        $crud = new grocery_CRUD();
                        $crud->set_table( $table )
                        ->set_subject( $table )
    //                    ->unset_edit()
                        ->unset_delete();
                        $add_fields = array('name','start_date','end_date','round','url','start_credit','type');
                        if($output['site_type'] == 0){
                            $crud->fields($add_fields);
                            $crud->required_fields($add_fields);
                        }
                        unset($add_fields[(count($add_fields)-1)]);
                        array_splice($add_fields, 0, 0, "id");
    //                    $add_fields[6] = 'id';
                        $crud->columns($add_fields);
                        $crud->edit_fields('name');
                        $crud->display_as('id','Site Code');
                    // invisible fields 
                        $crud->field_type('id', 'invisible');
                    // call back functions
                        $crud->callback_add_field('type',array($this,'platform_type_type_add_field'));
                        $crud->callback_add_field('url',array($this,'platform_type_url_add_field'));
                        $crud->callback_before_insert(array($this,'platform_type_before_insert_callback'));
                        $crud->callback_after_insert(array($this,'platform_type_after_insert_callback'));
                        $crud->callback_update(array($this,'platform_type_update'));
                    // fields rules
                        //$crud->set_rules('start_credit','Start credit','numeric');
                    // Check state and site type
                        $state = $crud->getState();
                        if(($state == 'list' || $state == 'success') && $output['site_type'] != 0){
                            $crud->unset_add();
                        }
                        $output['output'][$i] = $crud->render();
                }
                if($state == 'list' && $output['site_type'] == 0){
                    redirect(site_url('admin_page/type/add'));
                }
                $output['name'] = $this->session->userdata('username');
                $output['fb_id'] = $this->session->userdata('provider_id');
                $this->load->view ( 'pages/admin/type_view', $output );
            } else {
                redirect('admin_page');
            }
        }
        
        function platform_type_update($post_array, $primary_key){
            log_message('error','platform_type_update $post_array='.print_r($post_array,1));
            log_message('error','platform_type_update $primary_key='.print_r($primary_key,1));
            $flag = $this->core_call->updatePlatformName($primary_key,$post_array['name']);
            log_message('error','platform_type_update $flag='.print_r($flag,1));
            if( $flag == 1 ){
                $this->platform_model->update_platform($primary_key, $post_array);
                return $post_array;
            }
            return FALSE;
        }
        
        function platform_type_type_add_field($value='',$primary_key){
            $string = '<select name="type" style="width: 300px;">';
            $string .= '<option value="'. 1 .'">'.'competition'.'</option>';
            $string .= '<option value="'. 2 .'">'.'album'.'</option>';
            $string .= '</select>';
            return $string;
        }
        
        function platform_type_url_add_field($value='',$primary_key){
            return '<input type="hidden" maxlength="50" value="'.base_url().'" name="url" style="min-width: 270px;">'.base_url();
        }
        
        function platform_type_before_insert_callback($post_array){
            $post_array['start_date'] = date("Y/m/d H:i:s", strtotime(str_replace('/', '-', $post_array['start_date'])));
            $post_array['end_date'] = date("Y/m/d H:i:s", strtotime(str_replace('/', '-', $post_array['end_date'])));
            $post_array['accountid'] = $this->session->userdata('account_id');
            $temp = $this->core_call->getNewSiteCode($post_array);
            unset($post_array['accountid']);
            $temp[0]['start_date'] = date( "d/m/Y H:i:s", strtotime($temp[0]['start_date']) );
            $temp[0]['end_date'] = date( "d/m/Y H:i:s", strtotime($temp[0]['end_date']) );
            log_message('error','platform_type_before_insert_callback $temp='.print_r($temp,1));
        // Update platform type
            if($temp != 'This site already has been registered' && $temp != "No new Id was Created"){
                $post_array = $temp[0];
                $this->session->set_userdata('site_code', $temp[0]['id']);
            } else {
                $data = array(
                  'error' => 1  
                );
                redirect(site_url('admin_page/type/error/'. $data['error']));
                return FALSE;
            }
            return $post_array;
        }
        
        function platform_type_after_insert_callback($post_array,$primary_key){
            if($this->session->userdata('site_code')){
                $data = array(
                    'id' => $this->session->userdata('site_code')
                );
                $this->platform_model->update_platform($primary_key ,$data);
                $this->session->unset_userdata('site_code');
            }
            return true;
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
            $temp = $this->core_call->getNewSiteCode($data);
        // Update platform type
            if($temp != 'This site already has been registered'){
                $data = $temp;
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
            if($this->authentication->is_signed_in()){
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
                        $this->session->set_userdata('state',$state);
                        $crud->set_rules('name', 'name','callback_category_name_field_check');
                    // unique fields
                        $crud->unique_fields('name');
                        $output['output'][$i] = $crud->render();
                }
                $temp = $this->platform_model->get_my_type();
                $output['site_type'] = (count($temp))?$temp[0]['type']:0;
                $output['name'] = $this->session->userdata('username');
                $output['fb_id'] = $this->session->userdata('provider_id');
                $this->load->view ( 'pages/admin/category_view', $output );
            } else {
                redirect('admin_page');
            }
        }
        
        function category_name_field_check($table_name) {
            if($this->session->userdata('state') == 'insert_validation'){
                $table_scoreboard = $table_name.'_scoreboard';
                $fields = array('id'=>array('type' => 'INT'));
                $keys = array('id');
                log_message('error','inside category_name_field_check $table_name='.  print_r($table_name,1));
                log_message('error','inside category_name_field_check $table_scoreboard='.  print_r($table_scoreboard,1));
                if ( preg_match("~^[a-zA-Z0-9_]*$~", $table_name) ){
                    if($this->grocery_crud_model->db_create_table($table_scoreboard, $fields, $keys)){
                        log_message('error','after db_create_table');
                        $this->grocery_crud_model->db_drop_table($table_scoreboard);
                        log_message('error','after db_drop_table');
                        $str = array($table_scoreboard, $table_scoreboard.'_1', $table_scoreboard.'_2');
                        $this->grocery_crud_model->db_copy_create_table($str,'temp_scoreboard');
                        log_message('error','after db_copy_create_table');
                        $this->session->set_userdata('tables_created', 'TRUE');
                        log_message('error','after set_userdata');
                        $folder_path = 'h7-assets/images/categories/'.$table_name;
                        log_message('error','after $folder_path='.  print_r($folder_path,1));
                        if(!mkdir($folder_path, 0755, true)) {
                            log_message('error','mkdir Fail');
                        } else {
                            log_message('error','mkdir Success');
                        }
                        return TRUE;
                    }
                }
                $this->form_validation->set_message('category_name_field_check', 'Wrong category name, only character, numbers and underscores are allowed.');
                return FALSE;
            }
        }
        
        function category_before_insert_callback($post_array){
            $post_array['created'] = date('Y-m-d');
            $post_array['total_score'] = 0;
            $post_array['num_of_cards'] = 0;
            $post_array['rank'] = 0;
//            $this->update_updating_scoreboards_event();
            return $post_array;
        }
        
        function category_name_add_field($value='',$primary_key){
            return '<input type="text" maxlength="50" value="'.$value.'" name="name" style="min-width: 270px;"> <B style="color: red;">*Unique field And Unchangeable.</B>';
        }
        
        function category_name_edit_field($value='',$primary_key){
            return '<input type="hidden" maxlength="50" value="'.$value.'" name="name" style="width:270px"> <B style="min-width: 270px; float: left;">'.$value.'</B><B style="color: red;">                *Category name unchangeable.</B>';
        }
        
        // Drop and Re create update_scoreboards Event
        function update_updating_scoreboards_event(){
            $temp = $this->category_model->get_all_category();
            $categories = ($temp)?$temp->result_array:array();
            if(count($categories)){
                $this->grocery_crud_model->db_run_sql_query('DELIMITER $$');
            // Create event with if condition
                $sql = 'CREATE DEFINER=`hitsevey`@`localhost` EVENT `update_scoreboards` ON SCHEDULE EVERY 20 MINUTE STARTS \'2014-06-28 23:41:57\' ON COMPLETION NOT PRESERVE ENABLE DO IF (SELECT active_table FROM active_scoreboard WHERE category_id = 1) = 1  THEN \n';
            // Empty scoreboard main table to get usernames from it later
                $sql .= 'TRUNCATE TABLE '.$categories[0]['name'].'_scoreboard \n';
            // Copy names from in active scoreboard
                $sql .= 'INSERT INTO '.$categories[0]['name'].'_scoreboard (SELECT * FROM '.$categories[0]['name'].'_scoreboard_2); \n';
            // Empty all scoreboard tables
                foreach($categories as $c){
                    $sql .= 'TRUNCATE TABLE '.$c['name'].'_scoreboard_2 \n';
                }
                
                
                
            }
        }
        
        // Return a view
        // Input: none.
        // Output: view.
        function card(){
            if($this->authentication->is_signed_in()){
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
                $temp = $this->platform_model->get_my_type();
                $output['site_type'] = (count($temp))?$temp[0]['type']:0;
                $this->session->set_userdata('site_type', $output['site_type']);
                for($i = 0; $i < count ( $tables ); $i ++) {
                    $table = $tables[$i];
                    $crud = new grocery_CRUD();
                    $crud->set_table( $table );
                    $crud->set_subject( $table );
                    $crud->unset_delete();
                // Set relations with other tables
    //                $crud->set_relation('category_id','category','id');
                // Set table view and fields rules
                    $add_fields = array('name','category_id','start_date','end_date','price','score','status');
                    if( $output['site_type'] == 2 ){
                        array_splice($add_fields, 2, 0, "pack_id");
                    }
                    $crud->add_fields($add_fields);
                    $crud->required_fields($add_fields);
                    $crud->display_as('category_id','Category name')->display_as('pack_id','Pack Type');
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
                // set fields rules
                    $crud->set_rules('price','Card Price','numeric');
                    $crud->set_rules('score','Card Score','numeric');
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
    //                ->unset_edit();
    //                ->unset_delete()
    //                ->unset_print();
                    $output['output'][$i] = $crud->render();
                }
                $output['name'] = $this->session->userdata('username');
                $output['fb_id'] = $this->session->userdata('provider_id');
                $this->load->view ( 'pages/admin/card_view', $output );
            } else {
                redirect('admin_page');
            }
        }
        
        function card_name_add_field($value='',$primary_key){
            return '<input type="text" maxlength="50" value="'.$value.'" name="name" style="width:270px"> <B style="color: red;">*Unique field And Unchangeable.</B>';
        }
        
        function card_category_add_field($value='',$primary_key){
            $temp = $this->category_model->get_all_category();
            $categories = ($temp != FALSE)?$temp->result_array():array();
            $string = '<select name="category_id" style="width: 300px;">';
            foreach ($categories as $category){
                $string .= '<option value="'.$category['id'].'" '. (($this->session->userdata('last_category') == $category['id'])?'selected':'') .'>'.$category['name'].'</option>';
            }
            $string .= '</select>';
            return $string;
        }
        
        function card_pack_add_field($value='',$primary_key){
            $packs = $this->pack_model->get_all_packs();
            $string = '<select name="pack_id" style="width: 300px;">';
            foreach ($packs as $pack){
                $string .= '<option value="'.$pack['id'].'" '.(($this->session->userdata('last_pack') == $pack['id'])?'selected':'').'>'.$pack['name'].'</option>';
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
            if( $this->session->userdata('site_type') == 1){
                $post_array['pack_id'] = 1;
            }
            $total = $this->card_model->get_category_cards($post_array['category_id']);
            $post_array['id'] = $total;
            $this->card_model->update_card($primary_key, $post_array['category_id'], $post_array);
            log_message('error','card_after_insert_callback after update_card');
            $category = $this->category_model->get_category_by_id($post_array['category_id']);
            log_message('error','card_after_insert_callback after get_category_by_id');
            $category[0]['num_of_cards'] = $total;
            $this->category_model->update_category($post_array['category_id'],$category[0]);
            log_message('error','card_after_insert_callback after update_category');
            $created_path['main'] = 'h7-assets/images/categories/'.$category[0]['name'].'/cards/'.$total;
            $created_path['ui'] = 'h7-assets/images/categories/'.$category[0]['name'].'/cards/'.$total.'/ui';
            $created_path['image'] = 'h7-assets/images/categories/'.$category[0]['name'].'/cards/'.$total.'/image';
            $created_path['audio'] = 'h7-assets/images/categories/'.$category[0]['name'].'/cards/'.$total.'/audio';
            $created_path['video'] = 'h7-assets/images/categories/'.$category[0]['name'].'/cards/'.$total.'/video';
            $this->session->set_userdata('created_path', $created_path);
            mkdir($created_path['main'], 0755, true);
            mkdir($created_path['ui'], 0755, true);
            mkdir($created_path['image'], 0755, true);
            mkdir($created_path['audio'], 0755, true);
            mkdir($created_path['video'], 0755, true);
            log_message('error','card_after_insert_callback after mkdir');
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
            if($this->authentication->is_signed_in()){
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

    //                    $crud->callback_add_field('name',array($this,'credit_platform_name_add_field'));
    //                    $crud->callback_add_field('day',array($this,'credit_platform_day_add_field'));
                        $state = $crud->getState();
                        if($state == 'add'){
                            $name = 'web';
                            $total = count($this->platform_model->get_platform_by_name_day($name)) + 1;
                            $platform = $this->platform_model->get_all_platforms_names();
                            foreach($platform as $p){
                                $data = array(
                                    'id' => $p['id'],
                                    'name' => $p['name'],
                                    'day' => $total,
                                    'daily_credit' => 0
                                    );
                                $this->platform_model->insert_platform_credit($data);
                            }
                            redirect(site_url('admin_page/credit/success/'.$total*count($platform)));
                        }
                        $crud->callback_edit_field('name',array($this,'credit_platform_name_edit_field'));
                        $crud->callback_edit_field('day',array($this,'credit_platform_day_edit_field'));
                        $crud->callback_update(array($this,'credit_update'));
                    // rules
                        $crud->set_rules('day','Day','numeric');
                        $crud->set_rules('daily_credit','Daily Credit','numeric');
                        $this->session->set_userdata('state', $crud->getState());
                        $crud->set_rules('name', 'name', 'callback_credit_unique_day');
    //                    ->unset_edit()
    //                    ->unset_print();
                        $output['output'][$i] = $crud->render();
                }
                $temp = $this->platform_model->get_my_type();
                $output['site_type'] = (count($temp))?$temp[0]['type']:0;
                $output['name'] = $this->session->userdata('username');
                $output['fb_id'] = $this->session->userdata('provider_id');
                $this->load->view ( 'pages/admin/credit_view', $output );
            } else {
                redirect('admin_page');
            }
        }
        
//        function credit_platform_name_add_field(){
//            $names = $this->platform_model->get_all_platforms_names();
//            $string = '<select name="name" style="width: 300px;">';
//            foreach ($names as $name){
//                $string .= '<option value="'.$name['name'].'">'.$name['name'].'</option>';
//            }
//            $string .= '</select>';
//            return $string;
//        }
//        
//        function credit_platform_day_add_field(){
//            $name = 'web';
//            $total = count($this->platform_model->get_platform_by_name_day($name)) + 1;
//            return '<input type="hidden" maxlength="50" value="'.$total.'" name="day" style="width:270px"> <B style="min-width: 270px; float: left;">'.$total;
//        }
        
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

        // Return a view
        // Input: none.
        // Output: view.
        function pack(){
            if($this->authentication->is_signed_in()){
                $output ['tables'] = array (
                                'pack'
                );
                $tables = $output['tables'];
                $output['output'] = array();
                for($i = 0; $i < count ( $tables ); $i ++) {
                        $table = $tables[$i];
                        $crud = new grocery_CRUD();
                        $crud->set_table( $table );
                        $crud->set_subject( $table );
                        $crud->unset_delete();
                        $add_fields = array('name','start_date','end_date','price');
                        $crud->add_fields($add_fields); // fields to insert
                        $crud->edit_fields($add_fields); // fields to edit
                        $crud->required_fields($add_fields); // required when edit / insert
                        array_splice($add_fields, 1, 0, "cards_num");
                        $crud->columns($add_fields); // displayed in table
                        $crud->display_as('cards_num','Number of cards')->display_as('price','Pack price');
                        $crud->unique_fields('name');
                    // rules
                        $crud->set_rules('cards_num','Number of cards','numeric');
                        $crud->set_rules('price','Pack price','numeric');
                    // call back functions
    //                    $crud->callback_field('day',array($this,'credit_platform_day_edit_field'));
                        $crud->callback_before_insert(array($this,'pack_before_insert'));
                    // rules
    //                    $this->session->set_userdata('state', $crud->getState());
    //                    $crud->set_rules('name', 'name', 'callback_credit_unique_day');
    //                    ->unset_edit()
    //                    ->unset_print();
                        $output['output'][$i] = $crud->render();
                }
                $temp = $this->platform_model->get_my_type();
                $output['site_type'] = (count($temp))?$temp[0]['type']:0;
                $output['name'] = $this->session->userdata('username');
                $output['fb_id'] = $this->session->userdata('provider_id');
                $this->load->view ( 'pages/admin/pack_view', $output );
            } else {
                redirect('admin_page');
            }
        }
        
//	function show_table() {
//		$crud = new grocery_CRUD ();
//		$name = $this->input->post ( 'table_name' );
//		$crud->set_table ( $name );
//		$crud->set_subject ( $name );
//		$output = $crud->render ();
//		$this->load->view ( 'pages/show_tables_view_ajax', $output );
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
                $str = trim($query);
                if (!empty($str)){
                    $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                    $this->db->query($query);
                    $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                    log_message('error','createAllTables running $query='.print_r($query,1));
                    //$error = mysql_query($query) or die($query."<br/><br/>".mysql_error());
                    log_message('error','createAllTables running $error='.print_r(mysql_error(),1));
                }
                
            }
//            }
        }
}
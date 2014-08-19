<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class TestNewController extends CI_Controller {
    public function __construct() {
		parent::__construct ();
		// Load needed models
		$this->load->model('category_model');
		$this->load->model ( 'scoreboard_model' );

		//Load credit helper
		$this->load->helper('credit');
                $this->load->helper('account');
                

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));

		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array( 'session_model', 'core_call'));
	}
    function index(){
        $sql = "SELECT count(user_id) AS total_players FROM `sallySyamak_scoreboard_1`";
        $query = $this->db->query($sql)->result_array();
        $data['total_players'][0] = $query[0]['total_players'];
        
        
        $sql = "SELECT count(user_id) AS ddntPlayCount FROM `user_category` AS uc1 where category_id = 1 and score = 0 and user_id in (
                    SELECT user_id FROM `user_category` AS uc2 where category_id = 2 and score = 0 and user_id in (
                        SELECT user_id FROM `user_category` AS uc3 where category_id = 3 and score = 0 and user_id in(
                            SELECT user_id FROM `user_category` AS uc4 where category_id = 4 and score = 0
                            )
                        )
                    );";
        $query = $this->db->query($sql)->result_array();
        $data['ddntPlayCount'][0] = $query[0]['ddntPlayCount'];
        
        $sql = "SELECT count(user_id) AS playedAll FROM `user_category` AS uc1 where category_id = 1 and score > 0 and user_id in (
                    SELECT user_id FROM `user_category` AS uc2 where category_id = 2 and score > 0 and user_id in (
                        SELECT user_id FROM `user_category` AS uc3 where category_id = 3 and score > 0 and user_id in(
                            SELECT user_id FROM `user_category` AS uc4 where category_id = 4 and score > 0
                            )
                        )
                    );";
        $query = $this->db->query($sql)->result_array();
        $data['played'][0] = $query[0]['playedAll'];
        
        
        
        $sql = "SELECT active_table FROM `active_scoreboard` where category_id = 1;";
        $active_table = $this->db->query($sql)->row()->active_table;
        $sql = "SELECT count(user_id) AS total_players FROM `sallySyamak_scoreboard_".$active_table."`";
        $query = $this->db->query($sql)->result_array();
        $data['total_players'][1] = $query[0]['total_players'];
        
        $sql = "SELECT count(user_id) AS ddntPlayCount FROM `user_category` where category_id = 1 and score = 0;";
        $query = $this->db->query($sql)->result_array();
        $data['ddntPlayCount'][1] = $query[0]['ddntPlayCount'];
        
        $sql = "SELECT count(user_id) AS played FROM `user_category` where category_id = 1 and score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['played'][1] = $query[0]['played'];
        
        $sql = "select avg(score) as avg_score from sallySyamak_scoreboard_".$active_table." where score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['avg_score'][1] = $query[0]['avg_score'];
        
        
        
        
        
        $sql = "SELECT active_table FROM `active_scoreboard` where category_id = 2;";
        $active_table = $this->db->query($sql)->row()->active_table;
        $sql = "SELECT count(user_id) AS total_players FROM `mosalslat_scoreboard_".$active_table."`";
        $query = $this->db->query($sql)->result_array();
        $data['total_players'][2] = $query[0]['total_players'];
        
        $sql = "SELECT count(user_id) AS ddntPlayCount FROM `user_category` where category_id = 2 and score = 0;";
        $query = $this->db->query($sql)->result_array();
        $data['ddntPlayCount'][2] = $query[0]['ddntPlayCount'];
        
        $sql = "SELECT count(user_id) AS played FROM `user_category` where category_id = 2 and score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['played'][2] = $query[0]['played'];
        
        $sql = "select avg(score) as avg_score from mosalslat_scoreboard_".$active_table." where score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['avg_score'][2] = $query[0]['avg_score'];
        
        
        
        
        
        $sql = "SELECT active_table FROM `active_scoreboard` where category_id = 3;";
        $active_table = $this->db->query($sql)->row()->active_table;
        $sql = "SELECT count(user_id) AS total_players FROM `manElQatel_scoreboard_".$active_table."`";
        $query = $this->db->query($sql)->result_array();
        $data['total_players'][3] = $query[0]['total_players'];
        
        $sql = "SELECT count(user_id) AS ddntPlayCount FROM `user_category` where category_id = 3 and score = 0;";
        $query = $this->db->query($sql)->result_array();
        $data['ddntPlayCount'][3] = $query[0]['ddntPlayCount'];
        
        $sql = "SELECT count(user_id) AS played FROM `user_category` where category_id = 3 and score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['played'][3] = $query[0]['played'];
        
        $sql = "select avg(score) as avg_score from manElQatel_scoreboard_".$active_table." where score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['avg_score'][3] = $query[0]['avg_score'];
        
        
        
        
        
        $sql = "SELECT active_table FROM `active_scoreboard` where category_id = 4;";
        $active_table = $this->db->query($sql)->row()->active_table;
        $sql = "SELECT count(user_id) AS total_players FROM `shahryar_scoreboard_".$active_table."`";
        $query = $this->db->query($sql)->result_array();
        $data['total_players'][4] = $query[0]['total_players'];
        
        $sql = "SELECT count(user_id) AS ddntPlayCount FROM `user_category` where category_id = 4 and score = 0;";
        $query = $this->db->query($sql)->result_array();
        $data['ddntPlayCount'][4] = $query[0]['ddntPlayCount'];
        
        $sql = "SELECT count(user_id) AS played FROM `user_category` where category_id = 4 and score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['played'][4] = $query[0]['played'];
        
        $sql = "select avg(score) as avg_score from shahryar_scoreboard_".$active_table." where score > 0;";
        $query = $this->db->query($sql)->result_array();
        $data['avg_score'][4] = $query[0]['avg_score'];
        
        $data['cat_names'][1] = 'sallySyamak';
        $data['cat_names'][2] = 'mosalslat';
        $data['cat_names'][3] = 'manElQatel';
        $data['cat_names'][4] = 'shahryar';
        
        
        //Load view
        $this->load->view('pages/testNewView',$data);
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


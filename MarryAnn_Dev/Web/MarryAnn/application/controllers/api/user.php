<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class USER extends REST_Controller
{
    // Create new user into platform if where not exists.
    // Input: user id, user full name.
    // Output: success flag, # total flags.
    function checkUserRecords_get(){
    // Load needed models
        $this->load->model('user_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
    // Get inputs
        $user_id = $this->get('userId');
        $user_name = $this->get('userName');
    // Initialize count variable
        $data['success'] = 0;
    // Check then Add user records into user category table
        $temp = $this->category_model->get_category_interst_by_userID($user_id);
        $user_categories = (!$temp)?array():$temp->result_array();
        $categories = $this->category_model->get_all_category();
        if($categories != FALSE){
            $categories = $categories->result_array();
            while(count($categories) > count($user_categories)){
                foreach($categories as $c){
                    $found = 0;
                    foreach($user_categories as $uc){
                        if($c['id'] == $uc['category_id']){
                            $found = 1;
                            break;
                        }
                    }
                    if(!$found){
                        $this->category_model->insert_user_category($c['id'] , $user_id);
                    }
                }
                $temp = $this->category_model->get_category_interst_by_userID($user_id);
                $user_categories = (!$temp)?array():$temp->result_array();
            }
        }
    // Check then Add user records into user day table
        $user_day = count($this->user_model->get_user_info($user_id));
        while($user_day == 0){
            $user_day = $this->user_model->add_user($user_id);
        }
    // Change user's credit AND Get new credit
        $this->response($data, 200);
    }
}
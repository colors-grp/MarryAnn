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

class NOTIFICATION extends REST_Controller
{
    // Get all notifications from notification table
    // Input: none
    // Output: List of notifications
    function getAllNotifications_get(){
    // Load needed models
        $this->load->model('notification_model');
    // Change user's credit AND Get new credit
        $data['notification']['broadcast'] = $this->notification_model->get_current_broadcasts();
        $this->response($data, 200);
    }
}
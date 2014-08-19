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

class CREDIT extends REST_Controller
{
    // Add daily credit to user
    // Inputs: user id, platform id
    // Outputs: List of (success Flag (0 Faild, 1 success, 2 nothing changed))
    function addDailyCredit_get(){
    // Get inputs
        $user_id = $this->get('userId');
        $platform_id = $this->get('platformId');
    // Load needed models
        $this->load->model('user_model');
        $this->load->model('credit_model');
        $this->load->model('core_call');
    // Get and Check user las signed in day and daily coming
        $user = $this->user_mode->get_user_day($user_id);
        $date = date('Y-m-d');
        $difference = $date - $user[0]['lastsignedin'];
        if($difference == 1){
        // Get platform credit value
            $platform_credit = $this->credit_model->get_patform_credit($platform_id, $user[0]['day']+1);
        // Increment user's credit with platform credit AND get his new credit
            $temp = $this->core_call->buy_credit($user_id, $platform_credit);
            $data['success'] = $temp['invoke'];
            if($data['success']){
                $data['credit'] = $temp['data'];
            }
        } else {
            $data['success'] = 2;
        }
        $this->response($data, 200);
    }
    // Chenge user's credit with given value
    // Input: user id, value
    // Output: success flag (0 Faild, 1 success) AND new credit
    function updateUserCredit_get(){
    // Get inputs
        $user_id = $this->get('userId');
        $value = $this->get('value');
    // Load needed models
        $this->load->model('core_call');
    // Change user's credit AND Get new credit
        $temp = $this->core_call->buy_credit($user_id, $value);
        $data['success'] = $temp['invoke'];
        if($data['success']){
            $data['credit'] = $temp['data'];
        }
        $this->response($data, 200);
    }
    
    // Add new pack into user's pack and decrement his credit
    // Inputs: user id, pack id.
    // Outputs: success flag(0 faild, 1 success, 2 low credit), user's new packs and credit
    function buyNewPack_get(){
    // Get inputs
        $user_id = $this->get('userId');
        $pack_id = $this->get('packId');
    // Load needed models
        $this->load->model('core_call');
        $this->load->model('pack_model');
    // Get pack and extract it value
        $pack = $this->pack_model->get_pack($pack_id);
        $pack_price = $pack[0]['pack_price'];
    // Get then Check user's current credit
        $temp = $this->core_call->getUserCredit($user_id);
        $data['success'] = $temp['invoke'];
        if($data['success']){
            $user_credit = $temp['data'];
            if($user_credit >= $pack_price){
            // Decrement pack price from user's credit AND Get user's new credit
                $temp = $this->core_call->buy_credit($user_id, -1*$pack_price);
                $data['success'] = $temp['invoke'];
                if($data['success']){
                    $data['credit'] = $temp['data'];
                // Add new pack into user's packs
                    $data['success'] = $this->pack_model->update_user_packs($user_id, $pack_id, 1);
                // Return pack price into user's credit if faild to add pack into user's packs
                    if(!$data['success']){
                        do{
                            $temp = $this->core_call->buy_credit($user_id, $pack_price);
                        }while(!$temp['invoke']);
                    }
                }
            } else {
                $data['success'] = 2;
            }
        }
        $this->response($data,200);
    }
}
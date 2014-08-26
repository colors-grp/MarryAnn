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
        $user = $this->user_model->get_user_day($user_id);
        $date = date('Y-m-d 00:00:00');
        $user[0]['lastsignedin'] = date_format(date_create($user[0]['lastsignedin']), 'Y-m-d 00:00:00');
        $difference = strtotime($date)- strtotime($user[0]['lastsignedin']);
        if($difference == 86400){ // a day => 86400 seconds / 60 = 1440 minutes / 60 = 24 hours / 24 = 1 day
        // Get platform credit value
            $platform_day = $this->credit_model->get_platform_credit($platform_id, $user[0]['days']+1);
            if(count($platform_day)){
                $platform_credit = $platform_day[0]['daily_credit'];
            } else {
                $platform_day = $this->credit_model->get_platform_credit($platform_id, 1);
                $platform_credit = $platform_day[0]['daily_credit'];
            }
        // Increment user's credit with platform credit AND get his new credit
            $data['success'] = $this->core_call->buy_credit($user_id, $platform_credit);
            if($data['success']){
            // Change user days and lastsignedin
                $data['success'] = $this->user_model->change_user_day($user_id,$platform_day[0]['day']);
                if(!$data['success']){
                    do{
                        $success_temp = $this->core_call->buy_credit($user_id, -1*$platform_credit);
                    }while(!$success_temp);
                }
            }
        } else {
            $data['success'] = 2;
        }
        $data['credit'] = $this->core_call->getUserCredit($user_id);
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
        $data['success'] = $this->core_call->buy_credit($user_id, $value);
        if($data['success']){
            $data['credit'] = $this->core_call->getUserCredit($user_id);
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
        $data['success'] = $this->core_call->getUserCredit($user_id);
        if($data['success']){
            $user_credit = $data['success'];
            if($user_credit >= $pack_price){
            // Decrement pack price from user's credit AND Get user's new credit
                $data['success'] = $this->core_call->buy_credit($user_id, -1*$pack_price);
                if($data['success']){
                    $data['credit'] = $this->core_call->getUserCredit($user_id);
                // Add new pack into user's packs
                    $data['success'] = $this->pack_model->update_user_packs($user_id, $pack_id, 1);
                // Return pack price into user's credit if faild to add pack into user's packs
                    if(!$data['success']){
                        do{
                            $temp = $this->core_call->buy_credit($user_id, $pack_price);
                        }while(!$temp);
                    }
                }
            } else {
                $data['credit'] = $data['success'];
                $data['success'] = 2;
            }
        }
        $this->response($data,200);
    }
}
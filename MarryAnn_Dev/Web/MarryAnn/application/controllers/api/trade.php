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

class TRADE extends REST_Controller
{
	// Add request trade request into DB then return a success flag.
        // inputs: senderId, receiverId, offerdCardsSerials, demandedCardsSerials, message.
        // output: success flag.
	function addRequest_get()
	{
        // Get Inputs
            $sender_id = $this->get('senderId');
            $receiver_id = $this->get('receiverId');
            $offered_cards_serials[0] = $this->get('offeredSerial');//urldecode($this->get('offerdCardsSerials'));
            $demanded_cards_serials[0] = $this->get('demandedSerial');//urldecode($this->get('demandedCardsSerials'));
            $message = $this->get('message');
        //Load needed models
            $this->load->model('request_model');
            $this->load->model('card_model');
        // Get Cards & Check if both users still has the card
            $demanded = array(array());
            $offered = array(array());
            echo print_r($offered_cards_serials,1);
            echo '<br>'.print_r($demanded_cards_serials,1);
            for($i=0;$i<count($offered_cards_serials);$i++){
                $user_cards = $this->card_model->get_user_cards($sender_id,2,$offered_cards_serials[$i]);
                echo '<br>'.print_r($user_cards,1);
                if(count($user_cards) == 0){
                    $this->response(array('success' => '0'));
                } else {
                    $data = array(
                        'cat_id' => $user_cards[0]['category_id'],
                        'card_id' => $user_cards[0]['card_id'],
                    );
                    array_push($offered, $data);
                }
            }
            echo '<br>'.print_r($offered,1);
            for($i=0;$i<count($demanded_cards_serials);$i++){
                $user_cards = $this->card_model->get_user_cards($receiver_id,2,$demanded_cards_serials[$i]);
                if(count($user_cards) == 0){
                    $this->response(array('success' => '0'));
                } else {
                    $data = array(
                        'cat_id' => $user_cards[0]['category_id'],
                        'card_id' => $user_cards[0]['card_id'],
                    );
                    array_push($demanded, $data);
                }
            }
            echo '<br>'.print_r($demanded,1);
        // Get and Check cards values
            $demanded_value = $this->card_model->get_cards_score($demanded);
            $offered_value = $this->card_model->get_cards_score($offered);
            if($offered_value[0]['total'] >= $demanded_value[0]['total']){
            // Add Request into DB
                $data['success'] = $this->request_model->add_request($sender_id, $receiver_id, $demanded_cards_serials, $offered_cards_serials, $message, $demanded_value, $offered_value);
            } else {
                $data['success'] = 0;
            }
            $this->response($data, 200);
	}
        
        
        // cancle request from db if still on
        // inputs: request id.
        // output: success Flag AND List of receiver requests.
        function cancleRequest_get(){
        // Get Inputs
            $request_id = $this->get('requestId');
        // Load needed models
            $this->load->model('request_model');
        // Update request status if is still on (NOT DECLINED)
            $data['success'] = $this->request_model->update_status_msgs('5','',$request_id);
            $this->response($data, 200);
        }
        
        
        // cancle all other requests if this requets is still on,accept request if still on, swap cards if still in trade lists
        // inputs: requestId.
        // output: success Flag AND List of receiver requests.
        function acceptRequest_get(){
        // Get Inputs
            $request_id = $this->get('requestId');
        // Load needed models
            $this->load->model('request_model');
            $this->load->model('card_model');
        // Get request
            $request = $this->request_model->get_request_by_id($request_id);
        // Try locking sender's and receiver's request locks
            $lock['sender'] = $lock['receiver'] = $time_count = 0;
            do{
                $temp = $this->request_model->lock_user_request($request[0]['sender_id']);
                if($temp && !$lock['sender']){
                    $lock['sender'] = $temp;
                }
                $temp = $this->request_model->lock_user_request($request[0]['receiver_id']);
                if($temp && !$lock['receiver']){
                    $lock['receiver'] = $temp;
                }
                sleep(100);
                $time_count += 100;
            }while(!$lock['sender'] || !$lock['receiver'] && $time_count <= 2000);
            if(!$lock['sender'] || !$lock['receiver']){ // if any didnot succeed
            // re Unlock who was locked
                if($lock['sender']){
                    $this->request_model->lock_user_request($request[0]['sender_id'], 0);
                }
                if($lock['receiver']){
                    $this->request_model->lock_user_request($request[0]['receiver_id']);
                }
            } else {
                
            }
        // Check if request is still on (NOT DECLINED)
            if($request[0]['status'] != 1){
                $data['success'] = 0;
                $this->response($data, 200);
            } else {
            // Get Check then lock user's request lock
                $loop_count = 0;
                do{
                    $receiver_lock = $this->request_model->get_user_request_lock($request[0]['receiver_id']);
                    $sender_lock = $this->request_model->get_user_request_lock($request[0]['sender_id']);
                    $loop_count++;
                }while(($receiver_lock[0]['lock'] || $sender_lock[0]['lock']) && $loop_count < 2000);
                if($sender_lock[0]['lock'] || $receiver_lock[0]['lock']){
                    $data['success'] = 0;
                    $this->response($data, 200);
                } else {
                    
                }
            }
        }
}
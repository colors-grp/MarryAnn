<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage          Rest Server
 * @category            Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class TRADE extends REST_Controller
{
        // Get user's requests
        // Inputs: user id, user type flag (0 sender, 1 receiver)
        // Output: List of user's requests
        function getRequests_get(){
        // Get Inputs
            $user_id = $this->get('userId');
            $user_type = $this->get('userType');
        // Load needed models
            $this->load->model('request_model');
        // Get user's requests
            $data['request'] = $this->request_model->get_requests($user_id, $user_type);
            $this->response($data, 200);
        }
	// Add request trade request into DB then return a success flag.
        // inputs: senderId, receiverId, offerdCardsSerials, demandedCardsSerials, message.
        // output: success flag. (0 failed to insert into DB, 1 succeeded, 2 sender doesnot have a card, 3 receiver doesnot have a card, 4 demanded lower than offered) AND List of sender requests
	function addRequest_get()
	{
        // Get Inputs
            $sender_id = $this->get('senderId');
            $receiver_id = $this->get('receiverId');
            $offered_cards_serials = json_decode(urldecode($this->get('offerdCardsSerials')));
            $demanded_cards_serials = json_decode(urldecode($this->get('demandedCardsSerials')));
            $message = $this->get('message');
        //Load needed models
            $this->load->model('request_model');
            $this->load->model('card_model');
        // Get Cards & Check if both users still has the card THEN lock them
            $demanded = array();
            $offered = array();
            for($i=0;$i<count($offered_cards_serials);$i++){
                $user_cards = $this->card_model->get_user_cards($sender_id,2,$offered_cards_serials[$i]);
                if(count($user_cards) == 0){
                    $this->response(array('success' => '2'));
                } else {
                    $temp = array(
                        'cat_id' => $user_cards[0]['category_id'],
                        'card_id' => $user_cards[0]['card_id'],
                    );
                    array_push($offered, $temp);
                }
            }
            for($i=0;$i<count($demanded_cards_serials);$i++){
                $user_cards = $this->card_model->get_user_cards($receiver_id,2,$demanded_cards_serials[$i]);
                if(count($user_cards) == 0){
                    $this->response(array('success' => '3'));
                } else {
                    $temp = array(
                        'cat_id' => $user_cards[0]['category_id'],
                        'card_id' => $user_cards[0]['card_id'],
                    );
                    array_push($demanded, $temp);
                }
            }
        // Get and Check cards values
            $demanded_value = $this->card_model->get_cards_score($demanded);
            $offered_value = $this->card_model->get_cards_score($offered);
            if($offered_value[0]['total'] >= $demanded_value[0]['total']){
                $offered_cards_serials = json_encode($offered_cards_serials);
                $demanded_cards_serials = json_encode($demanded_cards_serials);
            // Add Request into DB
                $data['success'] = $this->request_model->add_request($sender_id, $receiver_id, $demanded_cards_serials, $offered_cards_serials, $message, $demanded_value, $offered_value);
                $data['demanded_value'] = $demanded_value;
                $data['offered_value'] = $offered_value;
            } else {
                $data['success'] = 5;
            }
            $data['requests'] = $this->request_model->get_requests($sender_id,0);
            $this->response($data, 200);
	}
        
        
        // cancle request from db if still on
        // inputs: request id, user id
        // output: success Flag (0 failed, 1 succeeded) AND List of user requests.
        function cancleRequest_get(){
        // Get Inputs
            $request_id = $this->get('requestId');
            $user_id = $this->get('userId');
        // Load needed models
            $this->load->model('request_model');
        // Update request status if is still on (NOT DECLINED)
            $data['success'] = $this->request_model->update_status_msgs('5','',$request_id);
        // Get user requests
            $data['requests'] = $this->request_model->get_requests($user_id,0);
            $this->response($data, 200);
        }
        
        
        // cancle all other requests if this requets is still on,accept request if still on, swap cards if still in trade lists
        // inputs: requestId, message.
        // output: success Flag AND List of receiver requests.
        function acceptRequest_get(){
        // Get Inputs
            $request_id = $this->get('requestId');
            $message = (!$this->get('message'))?'':$this->get('message');
        // Load needed models
            $this->load->model('request_model');
            $this->load->model('card_model');
        // Get request
            $request = $this->request_model->get_request_by_id($request_id);
        // Try locking sender's and receiver's request locks
            $lock['sender'] = $lock['receiver'] = $time_count = 0;
            do{
                $temp = $this->request_model->lock_user_request($request[0]['sender_id'],1);
                if($temp && !$lock['sender']){
                    $lock['sender'] = $temp;
                }
                $temp = $this->request_model->lock_user_request($request[0]['receiver_id'],1);
                if($temp && !$lock['receiver']){
                    $lock['receiver'] = $temp;
                }
                if($time_count){
                    sleep(100);
                }
                $time_count += 100;
            }while(!$lock['sender'] || !$lock['receiver'] && $time_count <= 2000);
            $data['success'] = 1;
            if(!$lock['sender'] || !$lock['receiver']){ // if any didnot succeed
                $data['success'] = 0;
            } else {
            // Check if request is still on (NOT DECLINED)
                if($request[0]['status'] == 1){ // Active
                // Try locking AND Swapping THEN Check swaping both players cards
                    $demand_card = json_decode($request[0]['request_demand']);
                    $offer_card = json_decode($request[0]['request_offer']);
                    $demanded_lock = $this->card_model->change_cards_state($request[0]['sender_id'],$request[0]['receiver_id'],$offer_card,2,4);
                    $offered_lock = $this->card_model->change_cards_state($request[0]['receiver_id'],$request[0]['sender_id'],$demand_card,2,4);
                    if(!$demanded_lock || !$offered_lock){// if not all locked
                        $this->card_model->change_cards_state($request[0]['sender_id'],$request[0]['receiver_id'],$offer_card,4,2);
                        $this->card_model->change_cards_state($request[0]['receiver_id'],$request[0]['sender_id'],$demand_card,4,2);
                    } else {// change user's cards state into 0 (As free) to confirm its swapping
                        $this->card_model->change_cards_state($request[0]['sender_id'],$request[0]['sender_id'],$demand_card,4,0);
                        $this->card_model->change_cards_state($request[0]['receiver_id'],$request[0]['receiver_id'],$offer_card,4,0);
                    // Auto Decline all other requests having common cards serials
                        $this->request_model->auto_decline($request[0]['request_id'],$demand_card);
                        $this->request_model->auto_decline($request[0]['request_id'],$offer_card);
                    // Change request status into accepted and update its message
                        $this->request_model->update_status_msgs(2, $message, $request_id);
                        $data['success'] = 1;
                    }
                }
            }
        // re Unlock who was locked
            if($lock['sender']){
                $this->request_model->lock_user_request($request[0]['sender_id'], 0);
            }
            if($lock['receiver']){
                $this->request_model->lock_user_request($request[0]['receiver_id'], 0);
            }
        // Get receiver's requests
            $data['request'] = $this->request_model->get_requests($request[0]['receiver_id'],1);
            $this->response($data, 200);
        }
        
        // reject request
        // Inputs: request id, message.
        // Outputs: List of receiver requests
        function rejectRequest_get(){
        // Get Inputs
            $request_id = $this->get('requestId');
            $message = (!$this->get('message'))?'':$this->get('message');
        // Load needed models
            $this->load->model('request_model');
            $this->load->model('card_model');
        // Get request
            $request = $this->request_model->get_request_by_id($request_id);
            $data['success'] = 0;
        // Check if request is still on (NOT DECLINED)
            if($request[0]['status'] == 1){ // Active
            // Change request status into accepted and update its message
                $this->request_model->update_status_msgs(3, $message, $request_id);
                $data['success'] = 1;
            }
        // Get receiver's requests
            $data['request'] = $this->request_model->get_requests($request[0]['receiver_id'],1);
            $this->response($data, 200);
        }
        
        function getURLDecoded_get(){
            $data['offer'] = urlencode(json_encode(array(1,2)));
            $data['demand'] = urlencode(json_encode(array(7)));
            $this->response($data,200);
        }
}
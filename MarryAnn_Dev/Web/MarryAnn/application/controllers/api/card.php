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

class CARD extends REST_Controller
{
	// return list of card for a specific user
	function openNewPack_get(){
        // load needed models
            $this->load->model('pack_model');
            $this->load->model('card_model');
        // get the input
            $user_id = $this->get('userId');
            $pack_id = $this->get('packId');
        // Get pack information from DB
            $pack = $this->pack_model->get_pack($pack_id);
        // Get List of cards having type = pack type
            $card = $this->card_model->get_card_by_type($pack[0]['pack_type']);
            

        //get number of cards in this pack type
            $num_of_cards = $this->pack_model->get_pack($pack_id)['cards_num'];

        //here we are gonna call random algorithm to generate the cards

        //output should be list of cards(card_id, cat_id)

        //add the generated cards to the user
        //$success = $this->card_model->insert_user_card($category_id , $card_id , $user_id, 0)

        //decrease the count of user's packs in this type
        //update the number of user's packs, if flag is 0 decrement the count, 1 increase the count
        //$added = $this->pack_model->update_user_packs($user_id, $pack_id, 0);
	}
	
	// return list of packs for a specific user
	function getUserPacks_get(){
		//load needed models
		$this->load->model('pack_model');

		//get the input, the user id
		$id = $this->get('user_id');
		
		//call the needed function from the model
		$packs_list = $this->pack_model->get_user_packs($id);
        if(count($packs_list) == 0){
        	$this->response(0, 200);
        }else{
			for ($i = 0; $i < count($packs_list); $i++) {
				$data['pack_id'][$i] = $packs_list[$i]['pack_id'];
				$data['count'][$i] = $packs_list[$i]['count'];
			}
			//return array contains pack_id and count
			$this->response($data, 200);
        }
	}
	
	//change the state of the user's card from free to album
	function putCardInAlbum_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input(userid, cardserial)
		$id = $this->get('user_id');
		$card_id = $this->get('card_id');
		$cat_id = $this->get('cat_id');
		
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift, 4 -> blocked}
		$success = $this->card_model->update_user_card($id, $id, $cat_id, $card_id, 0, 1);
		
		$this->response($success, 200);
	}
	
	//change the state of the user's card from free to trade
	function putCardInTradeList_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input(userid, cardserial)
		$id = $this->get('user_id');
		$card_id = $this->get('card_id');
		$cat_id = $this->get('cat_id');
		
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
		$success = $this->card_model->update_user_card($id, $id, $cat_id, $card_id, 0, 2);
		
		$this->response($success, 200);
	}
	
	//change the state of the user's card from trade to free
	function pullCardFromTradeList_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input(userid, cardserial)
		$id = $this->get('user_id');
		$card_id = $this->get('card_id');
		$cat_id = $this->get('cat_id');
		
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
		$success = $this->card_model->update_user_card($id, $id, $cat_id, $card_id, 2, 0);
		
		$this->response($success, 200);
	}
	
	//get the user's free cards
	function getUserFreeCards_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input, user id
		$id = $this->get('user_id');
		
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
		$free_cards = $this->card_model->get_user_cards($id, 0);
		if(count($free_cards) == 0){
			$this->response(0, 200);
		}else{
			for ($i = 0; $i < count($free_cards); $i++) {
				$data['card_serial'][$i] = $free_cards[$i]['card_serial'];
				$data['cat_id'][$i] = $free_cards[$i]['category_id'];
				$data['card_id'][$i] = $free_cards[$i]['card_id'];
			}
			
			$this->response($data, 200);
		}
	}
	
	//get the user's trade cards
	function getUserTradeCards_get(){
		//load needed models
		$this->load->model('card_model');
	
		//get the input, user id
		$id = $this->get('user_id');
	
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
		$trade_cards = $this->card_model->get_user_cards($id, 2);
		if(count($trade_cards) == 0){
			$this->response(0, 200);
		}else{
			for ($i = 0; $i < count($trade_cards); $i++) {
				$data['card_serial'][$i] = $trade_cards[$i]['card_serial'];
				$data['cat_id'][$i] = $trade_cards[$i]['category_id'];
				$data['card_id'][$i] = $trade_cards[$i]['card_id'];
			}
		
			$this->response($data, 200);
		}
	}
	
	//get the user's album cards
	function getUserAlbumCards_get(){
		//load needed models
		$this->load->model('card_model');
	
		//get the input, user id
		$id = $this->get('user_id');
	
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
		$album_cards = $this->card_model->get_user_cards($id, 1);
		if(count($album_cards) == 0){
			$this->response(0, 200);
		}else{
			for ($i = 0; $i < count($album_cards); $i++) {
				$data['card_serial'][$i] = $album_cards[$i]['card_serial'];
				$data['cat_id'][$i] = $album_cards[$i]['category_id'];
				$data['card_id'][$i] = $album_cards[$i]['card_id'];
			}
		
			$this->response($data, 200);
		}
	}
	
	//return the count of the cards in each state
	function getAllCardsCounts_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input, user id
		$id = $this->get('user_id');
		
		//call the needed function from the model
		//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
		$data['free_cards'] = $this->card_model->get_user_cards_count($id, 0);
		$data['album_cards'] = $this->card_model->get_user_cards_count($id, 1);
		$data['trade_cards'] = $this->card_model->get_user_cards_count($id, 2);
		
		$this->response($data, 200);
	}
	
	function SendGiftCard_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input
		$sender_id = $this->get('sender_id'); //sender_id is the user_id
		$receiver_id = $this->get('receiver_id'); 
		$cat_id = $this->get('cat_id');
		$card_id = $this->get('card_id');
		
		//add send gift request
		$added = $this->card_model->insert_gift_card($sender_id, $receiver_id, $cat_id, $card_id);
		
		if($added){
			//update the card state from free to gift
			//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
			$success = $this->card_model->update_user_card($sender_id, $sender_id, $cat_id, $card_id, 0, 3);
			
			//get number of gifts the user has sent today
			if($success){
				$cur_date = date('Y-m-d');
				$count = $this->card_model->count_user_gifts($sender_id, $cur_date);
				
				//check if he has sent 3 requests today
				if($count == 3){
					//do something
					echo "3 gifts";
				}else{
					$this->response($success, 200);
				}
			}else{
				$this->response($success, 200);
			}
		}else{
			$this->response($added, 200);
		}
	}
	
	function AcceptGiftCard_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input
		$sender_id = $this->get('sender_id');
		$receiver_id = $this->get('receiver_id'); //receiver_id is the user_id 
		$cat_id = $this->get('cat_id');
		$card_id = $this->get('card_id');
		$date = $this->get('date');
		
		//change the seen flag of the request
		$success = $this->card_model->update_user_gift($sender_id, $receiver_id, $cat_id, $card_id, $date);
		
		if($success){
			//add the gift card to the user's cards 
			$added = $this->card_model->insert_user_card($cat_id , $card_id , $receiver_id, 0);
			$this->response($added, 200);
		}else{
			$this->response($success, 200);
		}
	}
	
	//return 0 if the name of the card is wrong
	//else return list of users who have that card and number of users
	function getCardHolders_get(){
		//load needed models
		$this->load->model('card_model');
		
		//get the input
		$cardname = $this->get('cardname');
		
		$cards = $this->card_model->get_card_by_name($cardname);
		if(count($cards) == 0){
			$this->response(0, 200);
		}else{
			$cat_id = $cards[0]['category_id'];
			$card_id = $cards[0]['id'];
			
			//get users that have the card in their trade list
			//card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
			$card_holders = $this->card_model->get_card_holders($card_id, $cat_id, 2);
			if(count($card_holders) == 0){
				$data['num_of_users'] = count($card_holders);
				$this->response($data, 200);
			}else{
				for ($i = 0; $i < count($card_holders); $i++) {
					$data['users_ids'][$i] = $card_holders[$i]['user_id'];
				}
				$data['num_of_users'] = count($card_holders);
				
				$this->response($data, 200);
			}
		}
	}
	
}
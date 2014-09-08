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
    // generate random cards of specifice pack then assign 'em into user
    // Inputs: user id, pack id.
    // Outputs: success flag, List of new cards, list of user packs
    function openNewPack_get(){
    // load needed models
        $this->load->model('pack_model');
        $this->load->model('card_model');
    // get the input
        $user_id = $this->get('userId');
        $pack_id = $this->get('packId');
    // Check if user can open this pack
        $user_pack = $this->pack_model->get_user_packs($user_id, $pack_id);
        if(count($user_pack) && $user_pack[0]['count'] > 0){
        // Get pack information from DB
            $pack = $this->pack_model->get_pack($pack_id);
        // Get List of cards having type = pack type
            $card = $this->card_model->get_card_by_type_and_opened($pack[0]['pack_type']);
            if(count($card)){
            // Calculate frequescies and Set the randomization array
                $date = date('Y-m-d 00:00:00');
                $total_domain = array();
                for($i=0; $i<count($card); $i++){
                    $start_date = date_format(date_create($card[$i]['start_date']), 'Y-m-d 00:00:00');
                    $difference = (strtotime($date)- strtotime($start_date)) / 60 / 60 / 24;
                    while($difference > 0){
                        $difference--;
                        $temp = array(
                            0 => $card[$i]['category_id'],
                            1 => $card[$i]['id']
                            );
                        array_push($total_domain, $temp);
                    }
                }
            // Generate cards randomly and make sure they are not dubplicated
                if(count($card) < $pack[0]['cards_num']){
                    $data['success'] = 2;
                } else {
                    unset($card);
                    $card = array();
                    while(count($card) < $pack[0]['cards_num']){
                    // Get random number
                        $num = rand (0,count($total_domain));
                    // insert card if not exists in the card array
                        $flag = 1;
                        foreach($card as $o){
                            if($o[0] == $total_domain[$num][0] && $o[1] == $total_domain[$num][1]){
                                $flag = 0;
                            }
                        }
                        if($flag){
                            array_push($card, $total_domain[$num]);
                        }
                    }
                //add the generated cards to the user
                    for($i=0;$i<count($card);$i++){
                        $data['success'] = $this->card_model->insert_user_card($card[$i][0] , $card[$i][1] , $user_id);
                        $data['card'][$i]['cat_id'] = $card[$i][0];
                        $data['card'][$i]['card_id'] = $card[$i][1];
                    }
                //decrease the count of user's packs in this type
                    $data['pack_update'] = $this->pack_model->update_user_packs($user_id, $pack_id, 0);
                }
            } else {
                $data['success'] = 4;
            }
        } else {
            $data['success'] = 3;
        }
    // Get user's packs
        $data['pack'] = $this->pack_model->get_user_packs($user_id);
        $this->response($data, 200);
    }

    // return list of packs for a specific user
    // Inputs: user id.
    // Outputs: List of Packs.
    function getUserPacks_get(){
    //load needed models
        $this->load->model('pack_model');
    //get the input, the user id
        $id = $this->get('userId');
    //call the needed function from the model
        $data['pack'] = $this->pack_model->get_user_packs($id);
        $this->response($data, 200);
    }

    // Change the state of the user's card from free to album
    // Inputs: user id, card id, category id.
    // Outputs: Success Flag.
    function putCardInAlbum_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input(userid, cardserial)
            $id = $this->get('userId');
            $card_id = $this->get('cardId');
            $cat_id = $this->get('catId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift, 4 -> blocked}
            $data['success'] = $this->card_model->update_user_card($id, $id, $cat_id, $card_id, 0, 1);
            $this->response($data, 200);
    }

    // Change the state of the user's card from free to trade
    // Inputs: user id, card id, category id.
    // Outputs: Success Flag.
    function putCardInTradeList_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input(userid, cardserial)
            $id = $this->get('userId');
            $card_id = $this->get('cardId');
            $cat_id = $this->get('catId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift, 4 -> locked}
            $data['success'] = $this->card_model->update_user_card($id, $id, $cat_id, $card_id, 0, 2);
            $this->response($data, 200);
    }

    //change the state of the user's card from trade to free
    // Inputs: user id, card id, category id.
    // Outputs: Success Flag.
    function pullCardFromTradeList_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input(userid, cardserial)
            $id = $this->get('userId');
            $card_id = $this->get('cardId');
            $cat_id = $this->get('catId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift, 4 -> locked}
            $data['success'] = $this->card_model->update_user_card($id, $id, $cat_id, $card_id, 2, 0);
            $this->response($data, 200);
    }

    //get the user's free cards
    // Inputs: user id.
    // Outputs: List of cards.
    function getUserFreeCards_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input, user id
            $id = $this->get('userId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift, 4 -> locked}
            $free_cards = $this->card_model->get_user_cards($id, 0);
            $data = array();
            if(count($free_cards)){
                    for ($i = 0; $i < count($free_cards); $i++) {
                            $data[$i]['card_serial'] = $free_cards[$i]['card_serial'];
                            $data[$i]['cat_id'] = $free_cards[$i]['category_id'];
                            $data[$i]['card_id'] = $free_cards[$i]['card_id'];
                    }
            }
            $this->response($data, 200);
    }

    //get the user's trade cards
    // Inputs: user id.
    // Outputs: List of cards.
    function getUserTradeCards_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input, user id
            $id = $this->get('userId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
            $trade_cards = $this->card_model->get_user_cards($id, 2);
            $data = array();
            if(count($trade_cards)){
                for ($i = 0; $i < count($trade_cards); $i++) {
                        $data[$i]['card_serial'] = $trade_cards[$i]['card_serial'];
                        $data[$i]['cat_id'] = $trade_cards[$i]['category_id'];
                        $data[$i]['card_id'] = $trade_cards[$i]['card_id'];
                }
            }
            $this->response($data, 200);
    }

    // get the user's album cards
    // Inputs: user id.
    // Outputs: List of cards.
    function getUserAlbumCards_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input, user id
            $id = $this->get('userId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
            $album_cards = $this->card_model->get_user_cards($id, 1);
            $data = array();
            for ($i = 0; $i < count($album_cards); $i++) {
                    $data[$i]['card_serial'] = $album_cards[$i]['card_serial'];
                    $data[$i]['cat_id'] = $album_cards[$i]['category_id'];
                    $data[$i]['card_id'] = $album_cards[$i]['card_id'];
            }
            $this->response($data, 200);
    }

    //return the count of the cards in each state
    // Inputs: user id.
    // Outputs: List of number of cards in each place (free, album, or trade).
    function getAllCardsCounts_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input, user id
            $id = $this->get('userId');
            //call the needed function from the model
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
            $data['free_cards'] = $this->card_model->get_user_cards_count($id, 0);
            $data['album_cards'] = $this->card_model->get_user_cards_count($id, 1);
            $data['trade_cards'] = $this->card_model->get_user_cards_count($id, 2);
            $this->response($data, 200);
    }

    // Send a gift card from sender to receiver
    // Inputs: sender id, receiver id, category id, card id.
    // Outputs: success flag, request added into DB, count of user sent gifts.
    function SendGiftCard_get(){
        // Load needed models
            $this->load->model('card_model');
        // Get the input
            $sender_id = $this->get('senderId'); //sender_id is the user_id
            $receiver_id = $this->get('receiverId'); 
            $cat_id = $this->get('catId');
            $card_id = $this->get('cardId');
        // Get then Check if user can send another gift
            $cur_date = date('Y-m-d');
            $data['success'] = $data['added'] = 0;
            $data['count'] = $count = $this->card_model->count_user_gifts($sender_id, $cur_date);
            if($count == 3){
            //update the card state from free to gift
            //card states{0 -> free, 1 -> album, 2 -> trade, 3 -> gift}
                $data['success'] = $success = $this->card_model->update_user_card($sender_id, $sender_id, $cat_id, $card_id, 0, 3);
                if($success){
                // Add send gift request
                    $data['added'] = $added = $this->card_model->insert_gift_card($sender_id, $receiver_id, $cat_id, $card_id);
                // If could not insert into DB keep trying change back the card state
                    while(!$added){
                        $added = $this->card_model->update_user_card($sender_id, $sender_id, $cat_id, $card_id, 0, 0);
                        $data['success'] = 0;
                    }
                }
            }
            $this->response($data, 200);
    }

    // Accept received gift in certain date time
    // Inputs: sender id, receiver id, category id, card id, date.
    // Outputs: success flag, List of user's free cards, List of user's new gifts
    function AcceptGiftCard_get(){
            //load needed models
            $this->load->model('card_model');
            //get the input
            $sender_id = $this->get('senderId');
            $receiver_id = $this->get('receiverId'); //receiver_id is the user_id 
            $cat_id = $this->get('catId');
            $card_id = $this->get('cardId');
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
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('add_new_cards'))
{
	function add_new_cards($user_id){
		$CI =& get_instance();
		$new_cards = array();
                $cats = $CI->category_model->get_all_category()->result_array();
            // Make user have all available cards
                $i = 0;
                foreach($cats as $cat){
                    $new_cards[$i] =  FALSE;
                // Get category's available cards according to start_date
                    $cards = $CI->card_model->get_available_cards($cat['id']);
                    $cards = ($cards)?$cards->result_array():array();
                // Get user's cards
                    $user_cards = $CI->card_model->get_user_cards_by_id($cat['id'],$user_id);
                    $user_cards = ($user_cards)?$user_cards->result_array():array();
                // Add not Added cards to user's cards
                    foreach($cards as $card){
                        if(!in_array_field($card['id'], 'id', $user_cards)){
                            $CI->card_model->insert_user_card($cat['id'] , $card['id'] , $user_id);
                            $new_cards[$i] =  TRUE;
                        }
                        $i++;
                    }
                }
		return $new_cards;
	}
}
if(!function_exists('in_array_field'))
{
        // Takes value key and array , return true if value exist in array given key
        function in_array_field($value, $key, $array){
            foreach($array as $arr){
                if($value == $arr[$key]){
                    return TRUE;
                }
            }
            return FALSE;
        }
}
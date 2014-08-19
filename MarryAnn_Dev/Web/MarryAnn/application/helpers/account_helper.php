<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_fb_friends'))
{
    function get_fb_friends($user_id) 
    {
        $CI =& get_instance();
        // Invoke the core to get user's friends from facebook
        $friends = $CI->core_call->getFacebookFriends($user_id);
        log_message('error','mo7eb get_fb_friends userid='.$user_id);
        return $friends;
    }
}
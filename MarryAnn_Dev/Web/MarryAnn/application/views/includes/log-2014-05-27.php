<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 2014-05-27 11:34:46 --> The Core URL -> http://hitseven.net/index.php?/api/h7fb/
ERROR - 2014-05-27 11:34:46 --> mo7eb scoreboard get_top_three_players $cat_id=4 $cat_name=orange
ERROR - 2014-05-27 11:34:46 --> mo7eb scoreboard get_top_three_players $top_three=Array
(
    [top] => CI_DB_mysql_result Object
        (
            [conn_id] => Resource id #33
            [result_id] => Resource id #66
            [result_array] => Array
                (
                )

            [result_object] => Array
                (
                )

            [custom_result_object] => Array
                (
                )

            [current_row] => 0
            [num_rows] => 3
            [row_data] => 
        )

    [all] => CI_DB_mysql_result Object
        (
            [conn_id] => Resource id #33
            [result_id] => Resource id #67
            [result_array] => Array
                (
                )

            [result_object] => Array
                (
                )

            [custom_result_object] => Array
                (
                )

            [current_row] => 0
            [num_rows] => 3
            [row_data] => 
        )

    [top_users] => CI_DB_mysql_result Object
        (
            [conn_id] => Resource id #33
            [result_id] => Resource id #68
            [result_array] => Array
                (
                )

            [result_object] => Array
                (
                )

            [custom_result_object] => Array
                (
                )

            [current_row] => 0
            [num_rows] => 3
            [row_data] => 
        )

)

ERROR - 2014-05-27 11:34:46 --> Severity: Notice  --> Undefined property: CI_DB_mysql_result::$user_id /home/hitsevey/public_html/SS/application/controllers/scoreboard.php 303
ERROR - 2014-05-27 11:34:46 --> Severity: Notice  --> Undefined property: CI_DB_mysql_result::$user_id /home/hitsevey/public_html/SS/application/controllers/scoreboard.php 303
ERROR - 2014-05-27 11:34:46 --> Severity: Notice  --> Undefined property: CI_DB_mysql_result::$user_id /home/hitsevey/public_html/SS/application/controllers/scoreboard.php 303
ERROR - 2014-05-27 11:34:46 --> mo7eb scoreboard get_top_three_players $users_ids=Array
(
    [0] => 
    [1] => 
    [2] => 
)

ERROR - 2014-05-27 11:34:46 --> The method Name -> getFacebookIDs
ERROR - 2014-05-27 11:34:46 --> core call ->>>>>>
ERROR - 2014-05-27 11:34:46 --> FROM REST.PHP   params =   Array
(
    [users_ids] => W251bGwsbnVsbCxudWxsXQ%3D%3D
)

ERROR - 2014-05-27 11:34:46 --> key and value: users_ids   ->   W251bGwsbnVsbCxudWxsXQ%3D%3D    ====    
ERROR - 2014-05-27 11:34:46 --> FROM REST.PHP   uri =   getFacebookIDs/users_ids/W251bGwsbnVsbCxudWxsXQ%3D%3D/
ERROR - 2014-05-27 11:34:46 --> if 1
ERROR - 2014-05-27 11:34:46 --> _call response = {"data":[],"invoke":false,"error":"Unable to get User Facebook ID"}
ERROR - 2014-05-27 11:34:46 --> method = get
ERROR - 2014-05-27 11:34:46 --> params = 
ERROR - 2014-05-27 11:34:46 --> core_call getFacebookIDs Error calling H7 API, Method: getFacebookIDs, error message: Unable to get User Facebook ID

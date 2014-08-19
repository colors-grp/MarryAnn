<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Notifications extends REST_Controller {
        
        function notify_all_get() {
            $message = $this->get('message');
            $pass = intval($this->get('pass'));
            date_default_timezone_set('Africa/Cairo');
            $date = date('mdYh', time());
            echo 'password(expires every hour): '.$date.'<br>';
            $href = 'a';
            $this->load->model('account/account_facebook_model');
        //All Users
            $sql = "SELECT id AS ddntPlay FROM `a3m_account`";
            $query = $this->db->query($sql)->result_array();
            
            echo $message. ' <br>';
            echo count($query).' USERS.<br>';
            $i = 0;
            $size = count($query);
            $percent = ($size* 0.05);
            if($pass == $date){
                foreach ($query as $record){
                    $this->account_facebook_model->notify_facebook($record['ddntPlay'], $message, $href);
                    $i++;
                    if(($i % $percent) == 0){
                        echo $i . ' of '. $size . ' (DONE). => '. round($i / count($query) * 100) . '% <br>';
                    }
                }
            } else {
                echo 'wrog pass try again. <br>';
            }
        }
        
        function notify_playing_get(){
            $options = $this->get('options');
            $pass = intval($this->get('pass'));
            $user_id = $this->get('userId');
            $href = '';
            date_default_timezone_set('Africa/Cairo');
            $date = date('mdYh', time());
            echo 'password(expires every hour): '.$date.'<br>';
            $j = 1;
            while($options){
                if(strpos($options, '_') > 0){
                    $message = $this->get('message'.$j);
                    $j++;
//                    echo $options.'<br>';
                    $option = intval(substr($options, 0, strpos($options, '_')) );
//                    echo $option.'<br>';
                    $options = substr($options, strpos($options, '_')+1);
                } else if ( strlen($options) > 0) {
                    $message = $this->get('message'.$j);
                    $j++;
                    $option = intval($options);
                    $options = FALSE;
                } else {
                    break;
                }
                $sql = '';
                switch ($option){
                    case 1: // playing in cat 1
                        echo 'playing in cat1 <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 1 and score > 0';
                        break;
                    case 2: // playing in cat 2
                        echo 'playing in cat2 <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 2 and score > 0';
                        break;
                    case 3: // playing in cat 3
                        echo 'playing in cat3 <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 3 and score > 0';
                        break;
                    case 4: // playing in cat 4
                        echo 'playing in cat4 <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 4 and score > 0';
                        break;
                    case 5: // playing in any
                        echo 'playing in any <br>';
                        $sql = 'SELECT DISTINCT(user_id) AS playing FROM `hitsevey_db1`.`user_category` where score > 0';
                        break;
                    case 6: // playing in all
                        echo 'playing in all <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 1 and score > 0 and user_id in (
                                    SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 2 and score > 0 and user_id in (
                                        SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 3 and score > 0 and user_id in(
                                            SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 4 and score > 0
                                            )
                                        ) 
                                )';
                        break;
                    case 7: // didnot play any
                        echo 'didnot play any <br>';
                        $sql = 'SELECT DISTINCT(user_id) AS playing FROM `hitsevey_db1`.`user_category` WHERE score = 0 AND user_id NOT IN (SELECT DISTINCT(user_id) AS playing FROM `hitsevey_db1`.`user_category` where score > 0)';
                        break;
                    case 8: // played all but sally
                        echo 'played all but sally <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 1 and score = 0 and user_id not in (
                                 SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 2 and score > 0 and user_id not in (
                                  SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 3 and score > 0 and user_id not in(
                                   SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 4 and score > 0
                                  )
                                 )
                                )';
                        break;
                    case 9: // played all but mosalslat
                        echo 'played all but mosalslat <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 2 and score = 0 and user_id not in (
                                 SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 1 and score > 0 and user_id not in (
                                  SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 3 and score > 0 and user_id not in(
                                   SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 4 and score > 0
                                  )
                                 )
                                )';
                        break;
                    case 10: // played all but manElQatel
                        echo 'played all but manElQatel <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 3 and score = 0 and user_id not in (
                                 SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 2 and score > 0 and user_id not in (
                                  SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 1 and score > 0 and user_id not in(
                                   SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 4 and score > 0
                                  )
                                 )
                                )';
                        break;
                    case 11: // played all but shahryar
                        echo 'played all but shahryar <br>';
                        $sql = 'SELECT user_id AS playing FROM `hitsevey_db1`.`user_category` where category_id = 4 and score = 0 and user_id not in (
                                 SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 2 and score > 0 and user_id not in (
                                  SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 3 and score > 0 and user_id not in(
                                   SELECT user_id FROM `hitsevey_db1`.`user_category` where category_id = 1 and score > 0
                                  )
                                 )
                                )';
                        break;
                    default :
                        echo $option . ' not valid option. <br>';
                }
                if($sql != '' && $pass == $date){// right pass
                    $this->load->model('account/account_facebook_model');
                    $sql = 'SELECT id  FROM `a3m_account` where `lastsignedinon` > DATE_SUB(now(),INTERVAL 6 DAY) AND id in ( '.$sql.' );';
                    $query = $this->db->query($sql)->result_array();
                    echo count($query).' USERS.<br>';
                    $i = 0;
                    $size = count($query);
                    $percent = ($size* 0.05);
                    foreach ($query as $record){
                        $this->account_facebook_model->notify_facebook($record['playing'], $message, $href);
                        $i++;
                        if(($i % $percent) == 0){
                            echo $i . ' of '. $size . ' (DONE). => '. round($i / count($query) * 100) . '% <br>';
                        }
//                        echo $record['playing'].' Sent <br>';
                    }
                } else if($sql != ''){// wrong or empty pass -> then test message on userId
                    $sql = 'SELECT id  FROM `a3m_account` where `lastsignedinon` > DATE_SUB(now(),INTERVAL 6 DAY) AND id in ( '.$sql.' );';
                    $query = $this->db->query($sql)->result_array();
                    echo count($query).' USERS.<br>';
                    echo $message . ' <br>';
//                    foreach ($query as $record){
//                        echo $record['playing'].'<br>';
//                    }
//                    if(!$user_id){$user_id=1;}
//                    $this->load->model('account/account_facebook_model');
//                    if($message){$this->account_facebook_model->notify_facebook($user_id, $message, $href);}
                }
            }
        }
        function notify_me_get(){
            $message = $this->get('message');
            $pass = intval($this->get('pass'));
            $user_id = $this->get('userId');
            date_default_timezone_set('Africa/Cairo');
            $date = date('mdYh', time());
            echo 'password(expires every hour): '.$date.'<br>';
            $href = 'a';
            $this->load->model('account/account_facebook_model');
        //All Users
            $sql = "SELECT id AS ddntPlay FROM `a3m_account` WHERE id = ".$user_id.";";
            $query = $this->db->query($sql)->result_array();
            
            echo $message. ' <br>';
            echo count($query).' USERS.<br>';
            $i = 0;
            $size = count($query);
            $percent = ($size* 0.05);
            if($pass == $date){
                foreach ($query as $record){
                    $this->account_facebook_model->notify_facebook($record['ddntPlay'], $message, $href);
                    $i++;
                    if(($i % $percent) == 0){
                        echo $i . ' of '. $size . ' (DONE). => '. round($i / count($query) * 100) . '% <br>';
                    }
                }
            } else {
                echo 'wrog pass try again. <br>';
            }
        }
}
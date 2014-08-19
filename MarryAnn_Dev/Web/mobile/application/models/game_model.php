<?php
class Game_model extends CI_Model {
    function is_played($game_id,$user_id) {
            $this->db->select('*');
            $this->db->where('user_id', $user_id);
            $this->db->where ('game_id', $game_id);
            $this->db->where ('max_score', 'yes');
            $query = $this->db->get('user_game');
            if ($query->num_rows() > 0){
                    return $query->row()->score;
            }
            return '-1';
    }
    
    function get_user_score($game_id,$user_id){
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->where ('game_id', $game_id);
        $this->db->where ('max_score', 'yes');
        $query = $this->db->get('user_game');
        return ($query -> num_rows()>0)?$query->row()->score:0;
    }
}

<?php
class Platform_model extends CI_Model{
    //Update platform type
    // Inputs: id, type.
    // Output: success flag.
    function update($id, $type) {
        $this->db->where('id',$id);
        $data = array( 
            'type' => $type
        );
        $this->db->update('platform_type', $data);
        return $this->db->affected_rows();
    }
}
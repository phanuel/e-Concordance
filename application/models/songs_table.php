<?php

class Songs_table extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function getSongInfos($hymn_book_name, $song_number) {
        $query = $this->db->get_where('songs_v', array('hymn_book_name' => $hymn_book_name, 'song_number' => $song_number));

        if ($query->num_rows() == 0) {
            throw new Exception("Ce cantique n'existe pas.");
        }

        return $query->result();
    }

}

?>

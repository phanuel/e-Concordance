<?php

class Bible_books extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getTestamentBooks($nt) {
        $query = $this->db->get_where('bible_books_v', array('is_new_testament' => $nt));
        return $query->result();
    }

    public function getBibleBook($book_identifier) {
        $query = $this->db->get_where('bible_books_v', array('identifier' => $book_identifier));

        if ($query->num_rows() == 0) {
            throw new Exception("Book not found");
        }
        
        return $query->row();
    }

}

?>

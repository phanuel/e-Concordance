<?php

class Bible_verses extends CI_Model {

    public function __construct() {
        $this->load->database();

        $this->load->model('verbs_flections');
    }

    public function getChapter($book, $chapter) {
        $query = $this->db->get_where('bible_verses_v', array('bible_book_id' => $book, 'chapter' => $chapter));

        if ($query->num_rows() == 0) {
            throw new Exception("Ce chapitre n'existe pas.");
        }

        return $query->result();
    }

    public function query($input, $mode, $case_sensitive, $accents_sensitive, $page) {
        $this->load->helper('text');

        if ($input != "") {
            $table = "bible_verses_v";
            $queryfield = "text_strict";

            $resultfields = Array("text", "chapter", "verse", "bible_book_id", "book_abbreviation", "book_identifier");
            $order_by = Array("global_book_id ASC", "chapter ASC", "verse ASC");
            $limit = 25;
            $limit_from = ($page - 1) * $limit;
            
            $params = Array("_input" => $input,
                            "_table" => $table,
                            "_queryfield" => $queryfield,
                            "_resultfields" => $resultfields,
                            "_order_by" => $order_by,
                            "_limit" => $limit,
                            "_limit_from" => $limit_from,
                            "_mode" => $mode,
                            "_case_sensitive" => $case_sensitive,
                            "_accents_sensitive" => $accents_sensitive);
            $this->load->library('query', $params);
            return $this->query->run_query();
        }

        return null;
    }

}
?>

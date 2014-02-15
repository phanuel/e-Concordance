<?php

class Song_verses extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function getSongs($hymn_book_name, $language = "FR") {
        $sql = "SELECT * "
              ."FROM song_verses_v "
              ."WHERE "
                ."hymn_book_name = ? "
                ."AND language_abbreviation = ? "
              ."ORDER BY "
                ."song_number, "
                ."CASE "
                    ."WHEN verse = 0 THEN 1.5 " // place refrain between first and second verse
                    ."ELSE verse "
                ."END";

        $params = Array($hymn_book_name, $language);
        $results = $this->db->query($sql, $params)->result();

        if (count($results) == 0) {
            throw new Exception("Aucun cantique trouvé.");
        }

        return $results;
    }
    
    public function getSong($hymn_book_name, $song_number, $language = "FR") {
        $this->load->library("exceptions/SongNotFoundException");
        
        $sql = "SELECT * "
              ."FROM song_verses_v "
              ."WHERE "
                ."hymn_book_name = ? "
                ."AND song_number = ? "
                ."AND language_abbreviation = ? "
              ."ORDER BY "
                ."CASE "
                    ."WHEN verse = 0 THEN 1.5 " // place refrain between first and second verse
                    ."ELSE verse "
                ."END";

        $params = Array($hymn_book_name, $song_number, $language);
        $results = $this->db->query($sql, $params)->result();

        if (count($results) == 0) {
            throw new SongNotFoundException("Ce cantique n'existe pas.");
        }

        return $results;
    }
    
    public function query($hymn_book_name, $input, $mode, $case_sensitive, $accents_sensitive, $page) {
        $this->load->helper('text');

        if ($input != "") {
            $table = "song_verses_v";
            $queryfield = "text";

            $resultfields = Array("text", "song_number", "verse");
            $where = "hymn_book_name = ? AND language_abbreviation = ?";
            $params = Array($hymn_book_name, "FR");
            $order_by = Array("song_number ASC", "verse ASC");
            $limit = 10;
            $limit_from = ($page - 1) * $limit;
            
            $params = Array("_input" => $input,
                            "_table" => $table,
                            "_queryfield" => $queryfield,
                            "_resultfields" => $resultfields,
                            "_where" => $where,
                            "_order_by" => $order_by,
                            "_limit" => $limit,
                            "_limit_from" => $limit_from,
                            "_mode" => $mode,
                            "_case_sensitive" => $case_sensitive,
                            "_accents_sensitive" => $accents_sensitive,
                            "_params" => $params);
            $this->load->library('query', $params);
            return $this->query->run_query();
        }

        return null;
    }

}

?>

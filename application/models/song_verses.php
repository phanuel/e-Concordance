<?php

class Song_verses extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function getSong($hymn_book_name, $song_number, $language = "FR") {
        $query = $this->db->get_where('song_verses_v', array('hymn_book_name' => $hymn_book_name, 'song_number' => $song_number, 'language_abbreviation' => $language));

        if ($query->num_rows() == 0) {
            throw new Exception("Ce cantique n'existe pas.");
        }

        return $query->result();
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
//        $field = "text";
//
//        $input = trim($input); // removing spaces arround input string
//        $input = preg_replace('/\s+/', ' ', $input); // replacing multiple consecutive spaces by single spaces
//
//        if ($input != "") {
//            if ($case_sensitive == false) {
//                $field = "LOWER(" . $field . ")";
//            }
//            
//            $this->load->helper('text');
//            $input = clean_query_text($input, $case_sensitive);
//
//            $words = explode(" ", $input);
//            
//            if ($mode == "verb") {
//                $ci =& get_instance();
//                $ci->load->model('verbs_flections');
//                // get all flections related to the given infinitive verb (needs to be executed before building the main query so that the two active record sessions do not overlap)
//                $flections = $ci->verbs_flections->getFlections($words[0]);
//            }
//
//            $this->db->select('text, song_number, verse');
//            $this->db->from('song_verses_v');
//            $this->db->where("hymn_book_name", $hymn_book_name);
//            $this->db->where("language_abbreviation", "FR");
//
//            switch ($mode) {
//                case "and":
//                    foreach ($words as $word) {
//                        $this->db->where($field . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)'");
//                    }
//
//                    break;
//
//                case "or":
//                    $i = 0;
//                    $n = count($words);
//                    foreach ($words as $word) {
//                        if ($n == 1) {
//                            $this->db->where($field . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)'");
//                        }else {
//                            if ($i == 0) {
//                                $this->db->where("(".$field . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)'"); // first: opening bracket
//                            }else if ($i == $n -1) {
//                                $this->db->or_where($field . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)')"); // last: closing bracket
//                            }else {
//                                $this->db->or_where($field . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)'");
//                            }
//                        }
//                        
//                        $i++;
//                    }
//
//                    break;
//
//                case "literal":
//                    $input_cleaned = str_replace("'", "''", $input);
//                    $this->db->like($field, $input_cleaned);
//
//                    break;
//
//                case "wildcard":
//                    $this->db->where($field . " REGEXP '([[:<:]]" . $input . ".*[[:>:]])'");
//
//                    break;
//
//                case "verb":
//                    // check that input is only one word and exists as an infinitive verb
//                    if (count($words) > 1) {
//                        throw new Exception("Ce mode de recherche n'accepte qu'un seul terme à la fois.");
//                    }
//
//                    $i = 0;
//                    $n = count($flections->result());
//                    foreach ($flections->result() as $flection) {
//                        if ($i == 0) {
//                            $this->db->where("(".$field . " REGEXP '(^.*([[:<:]]" . $flection->stem.$flection->ending . "[[:>:]]).*$)'"); // first: opening bracket
//                        }else if ($i == $n - 1) {
//                            $this->db->or_where($field . " REGEXP '(^.*([[:<:]]" . $flection->stem.$flection->ending . "[[:>:]]).*$)')"); // last: closing bracket
//                        }else {
//                            $this->db->or_where($field . " REGEXP '(^.*([[:<:]]" . $flection->stem.$flection->ending . "[[:>:]]).*$)'");
//                        }
//                        
//                        $i++;
//                    }
//
//                    break;
//
//                default:
//                    // TODO: fix this
//                    break;
//            }
//
//            if ($count) {
//                return $this->db->count_all_results();
//            } else {
//                $this->db->order_by('song_number ASC, verse ASC');
//                $limit_from = ($page - 1) * 10;
//                $this->db->limit(10, $limit_from);
//
//                return $this->db->get();
//            }
//        }
//
//        return null;
    }

}

?>

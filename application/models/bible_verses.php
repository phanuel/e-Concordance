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

    public function query($input, $mode, $case_sensitive, $page, $count) {
        $field = "text_strict";

        $input = trim($input); // removing spaces arround input string
        $input = preg_replace('/\s+/', ' ', $input); // replacing multiple consecutive spaces by single spaces

        if ($input != "") {
            if ($case_sensitive == false) {
                $field = "LOWER(" . $field . ")";
            }
            
            $this->load->helper('text');
            $input = clean_query_text($input, $case_sensitive);

            $words = explode(" ", $input);
            
            if ($mode == "verb") {
                $ci =& get_instance();
                $ci->load->model('verbs_flections');
                // get all flections related to the given infinitive verb (needs to be executed before building the main query so that the two active record sessions do not overlap)
                $flections = $ci->verbs_flections->getFlections($words[0]);
            }

            $this->db->select('text, chapter, verse, bible_book_id, book_abbreviation, book_identifier');
            $this->db->from('bible_verses_v');

            switch ($mode) {
                case "and":
                    foreach ($words as $word) {
                        $word = str_replace("e", "[eéèê]", $word); // TODO: change all accented characters to the basic character before that step
                        $this->db->where("CONVERT(".$field." USING latin1)" . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)'");
                    }

                    break;

                case "or":
                    foreach ($words as $word) {
                        $this->db->or_where($field . " REGEXP '(^.*([[:<:]]" . $word . "[[:>:]]).*$)'");
                    }

                    break;

                case "literal":
                    // TODO: find a way to escape quotes properly (at this point only searches without quotes work)
                    $this->db->_protect_identifiers = false; // disabling CI quotes escaping
                    $input_cleaned = str_replace("'", "''", $input);
                    $this->db->like($field, $input_cleaned);
                    $this->db->_protect_identifiers = true; // re-enabling CI quotes escaping

                    break;

                case "wildcard":
                    $this->db->where($field . " REGEXP '([[:<:]]" . $input . ".*[[:>:]])'");

                    break;

                case "verb":
                    // check that input is only one word and exists as an infinitive verb
                    if (count($words) > 1) {
                        throw new Exception("Ce mode de recherche n'accepte qu'un seul terme à la fois.");
                    }
                    
                    foreach ($flections->result() as $flection) {
                        $this->db->or_where($field . " REGEXP '(^.*([[:<:]]" . $flection->stem.$flection->ending . "[[:>:]]).*$)'");
                    }
                    
                    break;

                default:
                    // TODO: fix this
                    break;
            }

            if ($count) {
                return $this->db->count_all_results();
            } else {
                $this->db->order_by('global_book_id ASC, chapter ASC, verse ASC');
                $limit_from = ($page - 1) * 25;
                $this->db->limit(25, $limit_from);

                return $this->db->get();
            }
        }

        return null;
    }

}
?>

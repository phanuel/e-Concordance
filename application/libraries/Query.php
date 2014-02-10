<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query {
    var $_input;
    var $_table;
    var $_queryfield;
    var $_resultfields;
    var $_where;
    var $_order_by;
    var $_limit;
    var $_limit_from;
    var $_mode;
    var $_query;
    var $_case_sensitive;
    var $_accents_sensitive;
    var $_params;
    var $_CI;
    
    public function __construct($params = Array())
    {
        foreach($params as $key => $value) {
            $this->$key = $value;
        }
        
        $this->_CI =& get_instance();
        $this->_CI->load->helper("text");
    }

    public function run_query()
    {
        $this->build_query(); // build query
        
        // run query and return results
        $results = $this->_CI->db->query($this->_query, $this->_params)->result();
        $count = $this->_CI->db->query("SELECT FOUND_ROWS() as count")->result();
        return Array("results" => $results, "count" => $count[0]->count);
    }
    
    private function build_query() {
        // select
        $this->_query = "SELECT SQL_CALC_FOUND_ROWS ";
        
        // resultfields
        $separator = "";
        foreach ($this->_resultfields as $resultfield) {
            $this->_query .= $separator . $resultfield;
            $separator = ", ";
        }
        
        // from
        $this->_query .= " FROM " . $this->_table;
        
        // where 1
        $this->_query .= " WHERE";
        if ($this->_where != null) {
            $this->_query .= " ".$this->_where." AND";
        }
        
        // where 2
        $this->_query .= " (";
        switch ($this->_mode) {
            case "and":
                $this->_query .= $this->query_words();
                break;
            case "literal":
                $this->_query .= $this->query_literal();
                break;
            case "verb":
                $this->_query .= $this->query_verb();
                break;
        }
        $this->_query .= ")";
        
        
        
        // order by
        $this->_query .= " ORDER BY ";
        $separator = "";
        foreach ($this->_order_by as $order_by) {
            $this->_query .= $separator . $order_by;
            $separator = ", ";
        }
        
        // limit
        $this->_query .= " LIMIT " . $this->_limit_from . ", " . $this->_limit;
    }
    
    private function query_words($operator = "AND") {
        $input = clean_query_text($this->_input, $this->_case_sensitive);
        
        if ($this->_accents_sensitive == false) {
            $input = accents_insensitive_pattern($input);
        }
        
        $words = explode(" ", $input);
        
        $queryfield = $this->_queryfield;
        if ($this->_case_sensitive == false) {
            $queryfield = "LOWER(".$queryfield.")"; // case insensitive search => using mysql lower() function before to compare
        }
        
        $charset = "latin1";
        if ($this->_accents_sensitive == false) {
            $queryfield = "CONVERT(".$queryfield." USING ".$charset.")"; // accents insensitive search => converting data in latin1 charset before to compare
            if ($this->_case_sensitive == true) {
                $queryfield .= " COLLATE latin1_general_cs"; // search is accents insensitive but case sensitive => using a case sensitive collation of the latin1 charset
            }
        }else {
            $queryfield = $queryfield;
        }
        
        $query_and = "";
        $separator = "";
        foreach ($words as $word) {
            $query_and .= $separator . $queryfield." REGEXP CONCAT('^.*([[:<:]]', ?, '[[:>:]].*$)')";
            $this->_params[] = $word;
            $separator = " ".$operator." ";
        }
        
        return $query_and;
    }
    
    private function query_literal() {
        $input = "%".$this->_input."%";
        
        $queryfield = $this->_queryfield;
        if ($this->_case_sensitive == false) {
            $queryfield = "LOWER(".$queryfield.")"; // case insensitive search => using mysql lower() function before to compare
        }
        
        $charset = "latin1";
        if ($this->_accents_sensitive == false) {
            $queryfield = "CONVERT(".$queryfield." USING ".$charset.")"; // accents insensitive search => converting data in latin1 charset before to compare
            if ($this->_case_sensitive == true) {
                $queryfield .= " COLLATE latin1_general_cs"; // search is accents insensitive but case sensitive => using a case sensitive collation of the latin1 charset
                // TODO: that use case does not work
                throw new Exception("Ce mode de recherche ne supporte pas cette combinaison d'options.");
            }
        }else {
            $queryfield = $queryfield;
        }
        
        $query_literal = $queryfield." LIKE ?";
        $this->_params[] = $input;
                
        return $query_literal;
    }
    
    private function query_verb() {
        $this->_CI->load->model('verbs_flections');
        
        $input = clean_query_text($this->_input, $this->_case_sensitive);
        
        if (strpos($input, " ") > 0) {
            throw new Exception("Ce mode de recherche n'accepte qu'un seul terme à la fois.");
        }
        
        // TODO: accents insensitive search of the infinitive form of the verb...
        // get all flections related to the given infinitive verb
        $flections = $this->_CI->verbs_flections->getFlections($input);
        
        $this->_accents_sensitive = true; // no need to check all accented permutations of the verb's flections, only the infinitive form has to
        
        // replacing original input with flections found
        foreach ($flections->result() as $flection) {
            $this->_input .= " ".$flection->stem.$flection->ending;
        }
        
        // performing query in "OR" mode
        $query_verb = $this->query_words("OR");
        
        return $query_verb;
    }
}

?>

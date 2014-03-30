<?php

class News extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function getAllNews() {
        $sql = "SET lc_time_names = 'fr_FR'"; // changing time names locale, so that date_format() can be used to display dates in french
        $this->db->query($sql);
        
        $sql = "SELECT date, DATE_FORMAT(date, '%d %M %Y') AS date_fr, version, content "
                ."FROM news "
                ."ORDER BY date DESC";

        $results = $this->db->query($sql)->result();
        
        return $results;
    }

}

?>

<?php

class Verbs_flections extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getFlections($verb_infinitive) {
        $this->db->select("*");
        $this->db->from("verbs_flections_v");
        $this->db->where('verb', $verb_infinitive);
        $this->db->order_by('LENGTH(ending) DESC');
        
        $results = $this->db->get();

        if ($results->num_rows == 0) {
            throw new Exception("Verbe inconnu, impossible d'effectuer la recherche. Vérifiez que le verbe a été écrit dans sa forme infinitive.<br /><br />Si un verbe manque dans notre système, merci de nous le signaler via le <a href='".base_url()."index/contact'>formulaire de contact</a>.");
        }

        return $results;
    }

}

?>

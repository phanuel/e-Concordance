<?php

class Hymn_books extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function getHymnBook($hymn_book_identifier) {
        $this->load->library("exceptions/HymnBookNotFoundException");
        
        $this->db->from('hymn_books');
        $this->db->where('identifier', $hymn_book_identifier);
        
        $result = $this->db->get()->result();
        
        if (count($result) == 0) {
            throw new HymnBookNotFoundException("Ce recueil n'existe pas.");
        }
        
        return $result;
    }

    public function getHymnBookIndex($hymn_book_name, $first_letter, $language) {
        $first_letter = $first_letter."%";
        $first_letter_with_quote = "\"".$first_letter;
        $sql = "SELECT * "
              ."FROM song_verses_v "
              ."WHERE "
                ."hymn_book_name = ? "
                ."AND language_abbreviation = ? "
                ."AND verse != ? "
                ."AND ( "
                    ."LOWER(text) LIKE ? COLLATE utf8_general_ci " // collation changed in order to ignore accents
                    ."OR LOWER(text) LIKE ? COLLATE utf8_general_ci " // also retrieve verses beginning with double quotes (i.e: hetc 211 or 231)
                .") "
                ."ORDER BY REPLACE(REPLACE(REPLACE(REPLACE(text, ' ', ''), '\'', ''), '’', ''), '\"', '') COLLATE utf8_general_ci ASC"; // ignoring blanks and quotes, and also using collate to ignore accents in sorting

        $params = Array($hymn_book_name, $language, 0, $first_letter, $first_letter_with_quote);
        $results = $this->db->query($sql, $params)->result();
        
        // keeping only the first line of the verse
        foreach ($results as $result) {
            $pos = strpos($result->text, "\r\n");
            $result->text = substr($result->text, 0, $pos);
        }
        
        return $results;
    }
    
    public function getHymnBookLyricsAuthors($hymn_book_identifier) {
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        
        $this->db->from('lyrics_authors_v');
        $this->db->where('hymn_book_identifier', $hymn_book_identifier);
        $this->db->order_by('last_name COLLATE utf8_general_ci');
        $this->db->order_by('first_name COLLATE utf8_general_ci');

        $results = $this->db->get()->result();
        
        $authors = Array();
        
        // retrieving songs written by each author
        foreach ($results as $result) {
            $author['person_id'] = $result->person_id;
            $author['first_name'] = $result->first_name;
            $author['last_name'] = $result->last_name;
            
            $sql = "SELECT song_number "
                ."FROM songs "
                ."WHERE "
                  ."hymn_book_id = ? "
                  ."AND ( "
                      ."author_person_id = ? "
                      ."OR author_person2_id = ? "
                  .") ";

            $params = Array($hymn_book[0]->hymn_book_id, $author['person_id'], $author['person_id']);
            $songs_result = $this->db->query($sql, $params)->result();

            $songs_numbers = "";
            $separator = "";
            foreach ($songs_result as $song) {
                $songs_numbers .= $separator.$song->song_number;
                $separator = ", ";
            }
            
            $author['songs'] = $songs_numbers;
            
            array_push($authors, $author);
        }
        
        return $authors;
    }
    
    public function getHymnBookMelodiesAuthors($hymn_book_identifier) {
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);

        $this->db->from('melodies_authors_v');
        $this->db->where('hymn_book_identifier', $hymn_book_identifier);
        $this->db->order_by('last_name COLLATE utf8_general_ci');
        $this->db->order_by('first_name COLLATE utf8_general_ci');

        $results = $this->db->get()->result();
        
        $authors = Array();
        $prev_author_id = "";
        
        // retrieving songs using each melody
        foreach ($results as $result) {
            $author['person_id'] = $result->author_person_id;
            $author['first_name'] = $result->first_name;
            $author['last_name'] = $result->last_name;
            
            $this->db->select('song_number');
            $this->db->from('songs');
            $this->db->where('hymn_book_id', $hymn_book[0]->hymn_book_id);
            $this->db->where('song_melody_id', $result->song_melody_id);

            $songs_result = $this->db->get()->result();
            $songs_numbers = "";
            $separator = "";
            foreach ($songs_result as $song) {
                $songs_numbers .= $separator.$song->song_number;
                $separator = ", ";
            }
            
            if ($result->author_person_id == $prev_author_id) {
                array_pop($authors); // removing the last author from the array, because it's songs list has to be completed (one melody can be used in one or more songs)
                $author['songs'] .= ", ".$songs_numbers;
            }else {
                $author['songs'] = $songs_numbers;
            }
            
            array_push($authors, $author);
            
            $prev_author_id = $result->author_person_id;
        }
        
        return $authors;
    }
    
    public function getHymnBookMetersIndex($hymn_book_identifier, $digits) {
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        
        $this->db->from('song_meters_v');
        $this->db->where('hymn_book_identifier', $hymn_book_identifier);
        $this->db->where('digits', $digits);
        $this->db->order_by('meter COLLATE utf8_general_ci');

        $results = $this->db->get()->result();
        
        $meters = Array();
        
        // retrieving songs of each meter
        foreach ($results as $result) {
            $meter['song_meter_id'] = $result->song_meter_id;
            $meter['meter'] = $result->meter;
            $meter['digits'] = $result->digits;
            
            $this->db->select('song_number');
            $this->db->from('songs');
            $this->db->where('hymn_book_id', $hymn_book[0]->hymn_book_id);
            $this->db->where('song_meter_id', $meter['song_meter_id']);

            $songs_result = $this->db->get()->result();
            
            $meter['songs'] = $songs_result;
            
            array_push($meters, $meter);
        }
        
        return $meters;
    }
    
    public function getHymnBookMelodiesIndex($hymn_book_identifier, $letter) {
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        
        $this->db->from('song_melodies_v');
        $this->db->where('hymn_book_identifier', $hymn_book_identifier);
        $this->db->where("LOWER(name1) LIKE '".$letter."%' COLLATE utf8_general_ci"); // collation changed in order to ignore accents
        $this->db->_protect_identifiers = false; // disabling CI quotes escaping
        $this->db->order_by('REPLACE(name1, " ", "") COLLATE utf8_general_ci ASC', null, false); // ignoring blanks and also using collate to ignore accents in sorting
        $this->db->_protect_identifiers = true; // re-enabling CI quotes escaping

        $results = $this->db->get()->result();
        
        $melodies = Array();
        
        // retrieving songs using each melody
        foreach ($results as $result) {
            $melody['song_melody_id'] = $result->song_melody_id;
            $melody['name1'] = $result->name1;
            $melody['name2'] = $result->name2;
            
            $this->db->select('song_number');
            $this->db->from('songs');
            $this->db->where('hymn_book_id', $hymn_book[0]->hymn_book_id);
            $this->db->where('song_melody_id', $melody['song_melody_id']);

            $songs_result = $this->db->get()->result();
            
            $melody['songs'] = $songs_result;
            
            array_push($melodies, $melody);
        }
        
        return $melodies;
    }

}

?>

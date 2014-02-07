<?php

class Songs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('hymn_books');
        $this->load->model('songs_table');
        $this->load->model('song_verses');

        $this->load->library('pagination');
    }

    public function index($hymn_book_identifier, $letter = "a") {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        $layoutData['title'] = $hymn_book[0]->name;

        $data['hymn_book_identifier'] = $hymn_book_identifier;
        $data['hymn_book_name'] = $hymn_book[0]->name;
        $data['letter'] = $letter;
        $data['verses_data'] = $this->hymn_books->getHymnBookIndex($hymn_book[0]->name, $letter, "FR");
        $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);

        if ($letter == "a") { // if letter is "a", creating canonical link in head (avoids duplicate content)
            $layoutData['canonicalUrl'] = "songs/index/" . $hymn_book_identifier;
        }
        $layoutData['content'] = $this->load->view('songs/index', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function index_authors_lyrics($hymn_book_identifier, $author_id = null) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        $data['hymn_book_identifier'] = $hymn_book_identifier;
        $data['hymn_book_name'] = $hymn_book[0]->name;
        $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);

        $layoutData['title'] = $hymn_book[0]->name . " - auteurs des paroles";
        $data['title'] = $layoutData['title'];
        $data['authors_data'] = $this->hymn_books->getHymnBookLyricsAuthors($hymn_book_identifier);

        if (isset($author_id)) { // if author id is specified, creating canonical link in head (avoids duplicate content)
            $layoutData['canonicalUrl'] = "songs/index_authors_lyrics/" . $hymn_book_identifier;
        }
        $layoutData['content'] = $this->load->view('songs/index-authors', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function index_authors_melodies($hymn_book_identifier, $author_id = null) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        $data['hymn_book_identifier'] = $hymn_book_identifier;
        $data['hymn_book_name'] = $hymn_book[0]->name;
        $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);
        
        $layoutData['title'] = $hymn_book[0]->name . " - auteurs des mélodies";
        $data['title'] = $layoutData['title'];
        $data['authors_data'] = $this->hymn_books->getHymnBookMelodiesAuthors($hymn_book_identifier);

        if (isset($author_id)) { // if author id is specified, creating canonical link in head (avoids duplicate content)
            $layoutData['canonicalUrl'] = "songs/index_authors_melodies/" . $hymn_book_identifier;
        }
        $layoutData['content'] = $this->load->view('songs/index-authors', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function index_meters($hymn_book_identifier, $digits = 4, $meter_id = null) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        $data['hymn_book_identifier'] = $hymn_book_identifier;
        $data['hymn_book_name'] = $hymn_book[0]->name;
        $data['digits'] = $digits;
        $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);

        $layoutData['title'] = $hymn_book[0]->name . " - mètres";

        $data['meters_data'] = $this->hymn_books->getHymnBookMetersIndex($hymn_book_identifier, $digits);

        if (isset($meter_id)) { // if meter id is specified, creating canonical link in head (avoids duplicate content)
            if ($digits == 4) {
                $layoutData['canonicalUrl'] = "songs/index_meters/" . $hymn_book_identifier;
            }else {
                $layoutData['canonicalUrl'] = "songs/index_meters/" . $hymn_book_identifier . "/" . $digits;
            }
        }else {
            if ($digits == 4) {
                $layoutData['canonicalUrl'] = "songs/index_meters/" . $hymn_book_identifier;
            }
        }
        $layoutData['content'] = $this->load->view('songs/index-meters', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function index_melodies($hymn_book_identifier, $letter = "a", $melody_id = null) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
        $data['hymn_book_identifier'] = $hymn_book_identifier;
        $data['hymn_book_name'] = $hymn_book[0]->name;
        $data['letter'] = $letter;
        $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);

        $layoutData['title'] = $hymn_book[0]->name . " - mélodies";

        $data['melodies_data'] = $this->hymn_books->getHymnBookMelodiesIndex($hymn_book_identifier, $letter);

        if (isset($melody_id)) { // if melody id is specified, creating canonical link in head (avoids duplicate content)
            if ($letter == "a") {
                $layoutData['canonicalUrl'] = "songs/index_melodies/" . $hymn_book_identifier;
            }else {
                $layoutData['canonicalUrl'] = "songs/index_melodies/" . $hymn_book_identifier . "/" . $letter;
            }
        }else {
            if ($letter == "a") {
                $layoutData['canonicalUrl'] = "songs/index_melodies/" . $hymn_book_identifier;
            }
        }
        $layoutData['content'] = $this->load->view('songs/index-melodies', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function read($hymn_book_identifier, $song_number = 1, $verse_number = null) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        try {
            $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);

            $data['hymn_book_identifier'] = $hymn_book_identifier;
            $data['hymn_book_name'] = $hymn_book[0]->name;
            $data['song_number'] = $song_number;
            $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);
            $data['song'] = $this->songs_table->getSongInfos($hymn_book[0]->name, $song_number);
            $data['song_verses'] = $this->song_verses->getSong($hymn_book[0]->name, $song_number);
            
            // keeping only the first line of the first verse
            $pos = strpos($data['song_verses'][0]->text, "\r\n");
            $title = substr($data['song_verses'][0]->text, 0, $pos);

            $layoutData['title'] = $title." ...";

            $previous_tags = "";
            $curr_tags = "";
            $tags = '<div class="span8 paginationPagesNumbers"><form class="form-inline"><div class="input-append"><label class="control-label">Aller au cantique: <input id="goto_song_value" type="text" maxlength="3" class="input-mini" style="width:40px;" placeholder="n°" /></label><button class="btn btn-primary" type="submit" id="goto_song_submit">ok</button></div></form>';
            if ($song_number == 1) {
                $curr_tags = '<div class="span2"></div>' . $tags;
            }else {
                $previous_tags = $tags;
            }

            $config['base_url'] = base_url() . 'songs/read/' . $hymn_book_identifier;
            $config['total_rows'] = 271;
            $config['per_page'] = 1;
            $config['num_links'] = 271; // show all links
            $config['use_page_numbers'] = TRUE;
            $config['display_pages'] = FALSE; // do not display page numbers
            $config['uri_segment'] = 4; // the chapter is the 4th segment in url
            $config['full_tag_open'] = '<div class="row"><ul class="pager">'.$curr_tags;
            $config['full_tag_close'] = '</ul></div>';
            $config['prev_tag_open'] = '<div class="span2"><li class="previous">';
            $config['prev_tag_close'] = '</li></div>'.$previous_tags;
            $config['next_tag_open'] = '</div><div class="span2"><li class="next">';
            $config['next_tag_close'] = '</li></div>';
            $config['prev_link'] = 'Précédent';
            $config['next_link'] = 'Suivant';

            $this->pagination->initialize($config);

            $data["pagination"] = $this->pagination->create_links();
        } catch (Exception $e) {
            $data['exception'] = $e;
            $layoutData['title'] = "Erreur";
        }
        
        if (isset($verse_number)) { // if verse number is specified, creating canonical link in head (avoids duplicate content)
            if ($song_number == 1) {
                $layoutData['canonicalUrl'] = "songs/read/" . $hymn_book_identifier;
            }else {
                $layoutData['canonicalUrl'] = "songs/read/" . $hymn_book_identifier . "/" . $song_number;
            }
        }else {
            if ($song_number == 1) {
                $layoutData['canonicalUrl'] = "songs/read/" . $hymn_book_identifier;
            }
        }
        $layoutData['content'] = $this->load->view('songs/read', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function search($hymn_book_identifier) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }
        try {
            $hymn_book = $this->hymn_books->getHymnBook($hymn_book_identifier);
            
            $query = (isset($_GET['query'])) ? $_GET['query'] : "";
            $mode = (isset($_GET['mode'])) ? $_GET['mode'] : "and";
            $case_sensitive = (isset($_GET['cs'])) ? $_GET['cs'] : false;
            $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
            $page = ($page != "") ? $page : 1;
            
            if (is_numeric($query)) { // if a number was given, redirecting to the song having this number
                $this->load->helper('url');
                redirect('/songs/read/'.$hymn_book_identifier.'/'.$query);
                die();
            }

            $layoutData['title'] = $hymn_book[0]->name." - Recherche";

            $data['hymn_book_identifier'] = $hymn_book_identifier;
            $data['hymn_book_name'] = $hymn_book[0]->name;
            $data['query'] = $query;
            $data['mode'] = $mode;
            $data['indexes_menu'] = $this->load->view('songs/indexes-menu', $data, true);
            
            if ($mode == "verb") {
                $this->load->model('verbs_flections');
                $this->load->helper('text');
                $words = explode(" ", clean_query_text($query, $case_sensitive));
                $data['flections'] = $this->verbs_flections->getFlections($words[0]);
            }

            $data['results'] = $this->song_verses->query($hymn_book[0]->name, $query, $mode, $case_sensitive, $page, false);
            $data['count'] = $this->song_verses->query($hymn_book[0]->name, $query, $mode, $case_sensitive, $page, true);
            //echo $this->db->last_query();

            $previous_tags = "";
            $curr_tags = "";
            $tags = '<div class="visible-phone" style="clear:both;"></div><div class="span8 paginationPagesNumbers">';
            if ($page == 1) {
                $curr_tags = '<div class="span2"></div>' . $tags;
            } else {
                $previous_tags = $tags;
            }

            if ($data['results'] != null) {
                $n = $data['count'];
                $params = Array("query" => $query,
                    "mode" => $mode,
                    "cs" => $case_sensitive);
                $get_params = http_build_query($params);

                $config['base_url'] = base_url() . 'songs/search/'.$hymn_book_identifier.'?' . $get_params;
                $config['total_rows'] = $n;
                $config['per_page'] = 10;
                $config['num_links'] = ceil(round($n / 10)); // show all links
                $config['use_page_numbers'] = TRUE;
                $config['uri_segment'] = 4; // the chapter is the 4th segment in url
                $config['full_tag_open'] = '<div class="row"><ul class="pager">';
                $config['full_tag_close'] = '</ul></div>';
                $config['prev_tag_open'] = '<div class="span2"><li class="previous">';
                $config['prev_tag_close'] = '</li></div>' . $previous_tags;
                $config['next_tag_open'] = '</div><div class="span2"><li class="next">';
                $config['next_tag_close'] = '</li></div>';
                $config['prev_link'] = 'Précédent';
                $config['next_link'] = 'Suivant';
                $config['num_tag_open'] = ' ';
                $config['num_tag_close'] = ' |';
                $config['cur_tag_open'] = $curr_tags . ' <strong>';
                $config['cur_tag_close'] = '</strong> |';
                $config['page_query_string'] = TRUE;
                $config['query_string_segment'] = 'page';

                $this->pagination->initialize($config);

                $data["pagination"] = $this->pagination->create_links();
            }
        } catch (Exception $e) {
            $data['exception'] = $e;
            $layoutData['title'] = "Erreur";
        }

        $layoutData['content'] = $this->load->view('songs/search', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }

}

?>

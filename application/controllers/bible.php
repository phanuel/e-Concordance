<?php

class Bible extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bible_books');
        $this->load->model('bible_verses');

        $this->load->library('pagination');
    }

    public function index() {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $layoutData['title'] = "La Bible";

        $data['books_nt'] = $this->bible_books->getTestamentBooks(true);
        $data['books_at'] = $this->bible_books->getTestamentBooks(false);
        $data['indexes_menu'] = $this->load->view('bible/indexes-menu', null, true);

        $layoutData['content'] = $this->load->view('bible/index', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }

    public function read($book_identifier = "genese", $chapter = 1, $verse = null) {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        try {
            $data['book'] = $this->bible_books->getBibleBook($book_identifier);
            $data['chapter'] = $chapter;
            $data['verses'] = $this->bible_verses->getChapter($data['book']->bible_book_id, $chapter);
            $data['indexes_menu'] = $this->load->view('bible/indexes-menu', null, true);

            $layoutData['title'] = $data['book']->name . " " . $chapter;

            if ($data['book']->name == "Psaumes") {
                $chapter_text = "Psaume";
            } else {
                $chapter_text = "chapitre";
            }

            $previous_tags = "";
            $curr_tags = "";
            $tags = '<div class="visible-phone" style="clear:both;"></div><div class="span8 paginationChaptersNumbers"><span style="margin-right:5px;">Aller au ' . $chapter_text . ':</span> ';
            if ($chapter == 1) {
                $curr_tags = '<div class="span2"></div>' . $tags;
            } else {
                $previous_tags = $tags;
            }

            $config['base_url'] = base_url() . 'bible/read/' . $data['book']->identifier;
            $config['total_rows'] = $data['book']->chapters;
            $config['per_page'] = 1;
            $config['num_links'] = $data['book']->chapters; // show all links
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

            $this->pagination->initialize($config);

            $data["pagination"] = $this->pagination->create_links();
        } catch (Exception $e) {
            $data['exception'] = $e;
            $layoutData['title'] = "Erreur";
        }

        if (isset($verse)) { // if verse is specified, creating canonical link in head (avoids duplicate content)
            if ($book_identifier == "genese" && $chapter == 1) {
                $layoutData['canonicalUrl'] = "bible/read";
            }else {
                $layoutData['canonicalUrl'] = "bible/read/" . $book_identifier . "/" . $chapter;
            }
        }else {
            if ($book_identifier == "genese" && $chapter == 1) {
                $layoutData['canonicalUrl'] = "bible/read";
            }
        }
        $layoutData['content'] = $this->load->view('bible/read', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }

    public function search() {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }
        try {
            $query = (isset($_GET['query'])) ? $_GET['query'] : "";
            $mode = (isset($_GET['mode'])) ? $_GET['mode'] : "and";
            $case_sensitive = (isset($_GET['cs'])) ? $_GET['cs'] : false;
            $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
            $page = ($page != "") ? $page : 1;

            $layoutData['title'] = "Rechercher dans la Bible";

            $data['query'] = $query;
            $data['mode'] = $mode;
            
            if ($mode == "verb") {
                $this->load->model('verbs_flections');
                $this->load->helper('text');
                $words = explode(" ", clean_query_text($query, $case_sensitive));
                $data['flections'] = $this->verbs_flections->getFlections($words[0]);
            }

            $data['results'] = $this->bible_verses->query($query, $mode, $case_sensitive, $page, false);
            $data['count'] = $this->bible_verses->query($query, $mode, $case_sensitive, $page, true);
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

                $config['base_url'] = base_url() . 'bible/search?' . $get_params;
                $config['total_rows'] = $n;
                $config['per_page'] = 25;
                $config['num_links'] = ceil(round($n / 25)); // show all links
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
        
        $data['indexes_menu'] = $this->load->view('bible/indexes-menu', null, true);

        $layoutData['content'] = $this->load->view('bible/search', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }

}

?>

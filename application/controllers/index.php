<?php

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $data['title'] = "e-Concordance";
        $data['content'] = $this->load->view('index/index', null, true);
        $data['home'] = true;
        
        $this->load->view('layouts/layout', $data);
    }
    
    public function contact() {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }
        $sendEmailTo = "webmaster@e-concordance.org";
        $subject = "[e-Concordance] Message d'un internaute";
                
        $data['title'] = "Contact";
        $data['content'] = $this->load->view('index/contact', null, true);

        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_rules('firstname', 'nom', 'trim');
        $this->form_validation->set_rules('lastname', 'prénom', 'trim');
        $this->form_validation->set_rules('email', 'e-mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('email2', 'confirmation de l\'e-mail', 'required|matches[email]');
        $this->form_validation->set_rules('message', 'message', 'trim|required|xss_clean');
        
        $this->form_validation->set_message('required', '<span class="label label-important">Erreur</span> Le champ "%s" est requis.');
        $this->form_validation->set_message('valid_email', '<span class="label label-important">Erreur</span> Le champ "%s" doit contenir une adresse e-mail valide.');
        $this->form_validation->set_message('matches', '<span class="label label-important">Erreur</span> La confirmation du champ "%s" n\'est pas correcte.');

        if($this->form_validation->run() == FALSE) {
            $data['success'] = false;
        }else {
            $config = Array( 
                'protocol' => 'smtp',
                'smtp_host' => 'mail.e-concordance.org',
                'smtp_port' => 2626,
                'smtp_user' => 'webmaster@e-concordance.org',
                'smtp_pass' => 'cosworth220',
                'newline' => '\r\n'
            );
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->from($this->input->post('email'), $this->input->post('name'));
            $this->email->to($sendEmailTo);
            $this->email->subject($subject);
            $this->email->message($this->input->post('message'));
            $this->email->send();
            
            $data['success'] = true;
        }

        $layoutData['content'] = $this->load->view('index/contact', $data, true);

        $this->load->view('layouts/layout', $layoutData);
    }
    
    public function notfound() {
        if (ENVIRONMENT == 'development') {
            $this->output->enable_profiler(TRUE); // in dev: enabling profiling
        }else {
            $this->output->cache(10080); // in prod: enabling caching, with a duration of one week (10080 minutes)
        }
        $data['title'] = "Page inconnue";
        $data['content'] = $this->load->view('index/notfound', null, true);
        
        $this->output->set_status_header('404');
        
        $this->load->view('layouts/layout', $data);
    }

}

?>

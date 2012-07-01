<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    private $profesor;
    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'profesor'))) {
            $this->session->set_flashdata('flashError', 'Потребно е да сте најавени со валиден професорски акаунт за пристап до оваа секција!');
            $this->user_model->redirect_by_level();
        } else {
            $this->load->model('profesor_model');
            $this->profesor = $this->profesor_model->GetProfesors(array('profesorUserId' => $this->session->userdata['userId']));
            
            $this->session->set_userdata('userFirstName', $this->profesor->profesorFirstName);
            $this->session->set_userdata('userLastName', $this->profesor->profesorLastName);
            //test if commit works!
        }
    }

    public function index() {
        $this->load->model('predmet_model');
        
        $subjects = $this->predmet_model->GetPredmeti(array('predmetProfesorId'=>  $this->profesor->profesorId));
        $predmeti = array();
        foreach($subjects as $predmet){
            $predmeti[$predmet->predmetId] = $predmet->predmetName;
        }
        
        $data['predmeti'] = $predmeti;
        
        $data['page'] = 'dashboard';
        $data['modul'] = 'profesor/moduls/home';
        $this->load->view('profesor/template', $data);
    }

}

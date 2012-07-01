<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Predmet extends CI_Controller {

    private $_tableName;
    private $profesor;
    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'profesor'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid predmet account to access this section.');
            redirect('login');
        } else {
            $this->load->model('predmet_model');
            $this->load->model('profesor_model');
            $profesor = $this->profesor_model->GetProfesors(array('profesorUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $profesor->profesorFirstName);
            $this->session->set_userdata('userLastName', $profesor->profesorLastName);
            $this->_tableName = 'predmet';
            $this->profesor = $profesor;
        }
    }

    public function overview($predmetId = 0) {
        $data['predmet'] = $this->predmet_model->GetPredmet(array('predmetId' => $predmetId));

        $data['modul'] = 'profesor/moduls/predmet/predmet_overview';
        $this->load->view('profesor/template', $data);
    }

    // Create
    function add() {
        // Validate form
        $this->form_validation->set_rules('predmetName', 'Име', 'trim|required');

        $this->form_validation->set_message('required', "Полето %s е задолжително");

        if ($this->form_validation->run()) {
            // Validation passes
            
           $predmetId = $this->predmet_model->AddPredmet($_POST);
                if ($predmetId) {
                    $this->session->set_flashdata('flashConfirm', 'Успешно е додаден нов предмет');
                    redirect('profesor/predmet');
                } else {
                    $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                    redirect('profesor/predmet');
                }
        
        }
        $this->load->model('fakultet_model');
        $faks = $this->fakultet_model->getFakulteti();
        $fakulteti=array();
        foreach($faks as $fak){
            $fakulteti[$fak->fakultetId] = $fak->fakultetName;
        }
        
        $data['fakulteti'] = $fakulteti;
        $data['id'] = $this->profesor->profesorId;
        $data['modul'] = 'profesor/moduls/predmet/predmet_add_form';

        $this->load->view('profesor/template', $data);
    }

    // Retrieve
    function index($offset = 0) {

        if (isset($_GET['json'])) {
            $this->load->library('datatables');
            $this->datatables->select('predmetId, predmetName, predmetStatus')->from('predmet')->where('predmetStatus != \'deleted\'')->where('predmetProfesorId', $this->profesor->profesorId);
            $actions = '<a class="button small no-padding blue" style="line-height:0 !important; padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'profesor/predmet/edit/$1">Измени</a> | <a class="button small no-padding red" style="line-height:0 !important;padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'profesor/predmet/delete/$1">Избриши</a>';
            $this->datatables->add_column('actions', $actions, 'predmetId');
            $this->datatables->unset_column('predmetId');
            echo $this->datatables->generate();
            die();
        }
        
     
        $data['modul'] = 'profesor/moduls/predmet/predmet_index';

        $this->load->view('profesor/template', $data);
    }
    
    // Update
    function edit($predmetId = 0) {
        
        if (!$predmetId)
            redirect('profesor/predmet');

        $data['predmet'] = $this->predmet_model->GetPredmet(array('predmetId' => $predmetId));


        if (!$data['predmet'])
            redirect('profesor/predmet');

        // Validate form

       $this->form_validation->set_rules('predmetName', 'Име', 'trim|required');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s"); // Mos ke bide koristeno vo maks lenght

        
        if ($this->form_validation->run()) {
            $_POST['predmetId'] = $predmetId;
            $this->predmet_model->UpdatePredmet($_POST);
            
            $this->session->set_flashdata('flashConfirm', 'Информациите за предметот се успешно запишани!');
            
            redirect('profesor/predmet');


        }
        
        $data['modul'] = 'profesor/moduls/predmet/predmet_edit_form';
        $this->load->view('profesor/template', $data);
    }

    // Delete
    function delete($predmetId) {
        $data['predmet'] = $this->predmet_model->GetPredmet(array('predmetId' => $predmetId));
        
        if (!$data['predmet'])
            redirect('predmet/users');

        $this->predmet_model->UpdatePredmet(array(
             'predmetId' => $predmetId,
            'predmetStatus' => 'deleted'
        ));



        $this->session->set_flashdata('flashConfirm', 'Предметот е успешно избришен!');
        redirect('profesor/predmet');
    }

    function _remap($method) {
        $param_offset = 2;

        // Default to index
        if (!method_exists($this, $method)) {
            // We need one more param
            $param_offset = 1;
            $method = 'index';
        }

        // Since all we get is $method, load up everything else in the URI
        $params = array_slice($this->uri->rsegment_array(), $param_offset);

        // Call the determined method with all params
        call_user_func_array(array($this, $method), $params);
    }

}

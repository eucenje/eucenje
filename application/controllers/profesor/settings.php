<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'profesor'))) {
            $this->session->set_flashdata('flashError', 'Потребно е да сте најавени со валиден професорски акаунт за простап до оваа секција.');
            $this->user_model->redirect_by_level();
        } else {

            $this->load->model('profesor_model');
           
        }
    }

    public function index() {
        $data['page'] = '';
        $data['modul'] = 'profesor/moduls/settings_index';
        $this->load->view('profesor/template', $data);
    }

    public function edit_personal_info() {
        $data['profesor'] = $this->profesor_model->GetProfesors(array('profesorUserId' => $this->session->userdata['userId']));

        $this->form_validation->set_rules('profesorFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('profesorLastName', 'Презиме', 'trim|required');
         $this->form_validation->set_rules('profesorEmail', 'Емаил', 'trim|valid_email');
         
        if ($this->form_validation->run()) {
            $_POST['profesorId'] = $data['profesor']->profesorId;
            $this->profesor_model->UpdateProfesor($_POST);
            $this->session->set_userdata('profesorFirstName', $_POST['profesorFirstName']);
            $this->session->set_userdata('profesorLastName', $_POST['profesorLastName']);
            redirect('profesor/dashboard');
        }

        $data['modul'] = 'profesor/moduls/settings_edit_personal_info';
        $this->load->view('profesor/template', $data);
    }

    public function edit_account_info() {
        $data['user'] = $this->user_model->GetUsers(array('userId'=> $this->session->userdata['userId']));
        
        $this->form_validation->set_rules('userName', 'Username', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'Password', 'trim');

        
        
        if ($this->form_validation->run()) {
            $_POST['userId'] = $data['user']->userId;
            $this->user_model->UpdateUser($_POST);
             $this->session->set_userdata('userName', $_POST['userName']);
            redirect('profesor/dashboard');
        }

        $data['modul'] = 'profesor/moduls/settings_edit_account_info';
        $this->load->view('profesor/template', $data);
    }

}
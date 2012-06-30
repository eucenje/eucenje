<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid admin account to access this section.');
            $this->user_model->redirect_by_level();
        } else {

            $this->load->model('admin_model');
           
        }
    }

    public function index() {
        $data['page'] = '';
        $data['modul'] = 'admin/moduls/settings_index';
        $this->load->view('admin/template', $data);
    }

    public function edit_personal_info() {
        $data['admin'] = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));

        $this->form_validation->set_rules('adminFirstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('adminLastName', 'Last Name', 'trim|required');
         $this->form_validation->set_rules('adminEmail', 'email', 'trim|valid_email');
         
        if ($this->form_validation->run()) {
            $_POST['adminId'] = $data['admin']->adminId;
            $this->admin_model->UpdateAdmin($_POST);
            $this->session->set_userdata('adminFirstName', $_POST['adminFirstName']);
            $this->session->set_userdata('adminLastName', $_POST['adminLastName']);
            redirect('admin/dashboard');
        }

        $data['modul'] = 'admin/moduls/settings_edit_personal_info';
        $this->load->view('admin/template', $data);
    }

    public function edit_account_info() {
        $data['user'] = $this->user_model->GetUsers(array('userId'=> $this->session->userdata['userId']));
        
        $this->form_validation->set_rules('userName', 'Username', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'Password', 'trim');

        
        
        if ($this->form_validation->run()) {
            $_POST['userId'] = $data['user']->userId;
            $this->user_model->UpdateUser($_POST);
             $this->session->set_userdata('userName', $_POST['userName']);
            redirect('admin/dashboard');
        }

        $data['modul'] = 'admin/moduls/settings_edit_account_info';
        $this->load->view('admin/template', $data);
    }

}
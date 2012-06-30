<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid admin account to access this section.');
            $this->user_model->redirect_by_level();
        } else {
            $this->load->model('admin_model');
            $admin = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $admin->adminFirstName);
            $this->session->set_userdata('userLastName', $admin->adminLastName);
        }
    }

    public function index() {
        $data['page'] = 'dashboard';
        $data['modul'] = 'admin/moduls/home';
        $this->load->view('admin/template', $data);
    }

}

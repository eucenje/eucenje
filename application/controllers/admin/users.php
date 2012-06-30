<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid admin account to access this section.');
            redirect('login');
        }
        
      
    }

    // Create
    function add() {
        // Validate form
        $this->form_validation->set_rules('userName', 'username', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'password', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('userType', 'type', 'trim|required');
        $this->form_validation->set_rules('userStatus', 'status', 'trim|required');

        if ($this->form_validation->run()) {
            // Validation passes
            $userId = $this->user_model->AddUser($_POST);

            if ($userId) {
                $this->session->set_flashdata('flashConfirm', 'The user has been successfully added.');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your administrator.');
                redirect('admin/users');
            }
        }
        $data['modul'] = 'admin/moduls/users/users_add_form';
        $this->load->view('admin/template', $data);
    }

    // Retrieve
    function index($offset = 0) {
        // Just testing
        if(isset($_GET['json'])){
            $this->load->library('datatables');
            $this->datatables->select('adminFirstName, adminLastName, adminEmail, adminStatus')->from('admins');
            
            echo  $this->datatables->generate();
            die();
        }
//        $this->load->library('pagination');
        $perpage = 1;
//
//        $config['base_url'] = base_url() . 'admin/users/index/';
//        $config['total_rows'] = $this->user_model->GetUsers(array('count' => true ));
//        $config['per_page'] = $perpage;
//        $config['uri_segment'] = 3;
//        
//        
//        $this->pagination->initialize($config);
//
//        $data['pagination'] = $this->pagination->create_links();
//        
        $data['users'] = $this->user_model->GetUsers(array('limit' => $perpage, 'offset' => $offset));

        $data['modul'] = 'admin/moduls/users/users_index';
        $this->load->view('admin/template', $data);
    }

    // Update
    function edit($userId = 0) {
        
        if (!$userId)
            redirect('admin/users');
        $data['user'] = $this->user_model->GetUsers(array('userId' => $userId));
       
        if (!$data['user'])
            redirect('admin/users');
       
        
        // Validate form
        $this->form_validation->set_rules('userName', 'username', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'password', 'trim|min_length[3]');
        $this->form_validation->set_rules('userType', 'type', 'trim|required');
        $this->form_validation->set_rules('userStatus', 'status', 'trim|required');

        if ($this->form_validation->run()) {
            // Validation passes
            $_POST['userId'] = $userId;
            if (empty($_POST['userPassword']))
                unset($_POST['userPassword']);

            if ($this->user_model->UpdateUser($_POST)) {
                $this->session->set_flashdata('flashConfirm', 'The user has been successfully updated.');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your administrator.');
                redirect('admin/users');
            }
        }
        $data['modul'] = 'admin/moduls/users/users_edit_form';
        $this->load->view('admin/template', $data);
    }

    // Delete
    function delete($userId) {
        $data['user'] = $this->user_model->GetUsers(array('userId' => $userId));
        if (!$data['user'])
            redirect('admin/users');

        $this->user_model->UpdateUser(array(
            'userId' => $userId,
            'userStatus' => 'deleted'
        ));

        $this->session->set_flashdata('flashConfirm', 'The user has been successfully deleted.');
        redirect('admin/users');
    }

}

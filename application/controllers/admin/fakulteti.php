<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fakulteti extends CI_Controller {

    private $_tableName;

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid fakultet account to access this section.');
            redirect('login');
        } else {
            $this->load->model('fakultet_model');
            $this->load->model('admin_model');
            $admin = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $admin->adminFirstName);
            $this->session->set_userdata('userLastName', $admin->adminLastName);
            $this->_tableName = 'fakulteti';
        }
    }

    public function overview($id = 0) {

        if ($id != 0 && preg_match('/^[0-9]+$/', $id)) {
            $data['fakultet'] = $this->fakultet_model->GetFakulteti(array('fakultetId' => $id));
            $data['modul'] = 'fakultet/moduls/fakultets/fakultets_overview.php';
            $this->load->view('fakultet/template', $data);
            //print_r($data['fakultet']);
        } else
            redirect('fakultet/fakultets');
    }

    // Create
    function add() {
        // Validate form
        $this->form_validation->set_rules('fakultetName', 'Име', 'trim|required');
        $this->form_validation->set_rules('fakultetType', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('fakultetYears', 'години на студирање', 'trim|required');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s"); // Mos ke bide koristeno vo maks lenght

        if ($this->form_validation->run()) {
            // Validation passes
           $fakultetId = $this->fakultet_model->AddFakultet($_POST);
                if ($fakultetId) {
                    $this->session->set_flashdata('flashConfirm', 'Успешно е додаден нов факултет');
                    redirect('admin/fakulteti');
                } else {
                    $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                    redirect('admin/fakulteti');
                }
        
        }
        $data['modul'] = 'admin/moduls/fakulteti/fakulteti_add_form';

        $this->load->view('admin/template', $data);
    }

    // Retrieve
    function index($offset = 0) {
        
        if (isset($_GET['json'])) {
            $this->load->library('datatables');
            $this->datatables->select('fakultetId, fakultetName, fakultetType, fakultetYears, fakultetStatus')->from('fakulteti')->where('fakultetStatus != \'deleted\'');
            $actions = '<a class="button small no-padding blue" style="line-height:0 !important; padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/fakulteti/edit/$1">Измени</a> | <a class="button small no-padding red" style="line-height:0 !important;padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/fakulteti/delete/$1">Избриши</a>';
            $this->datatables->add_column('actions', $actions, 'fakultetId');
            $this->datatables->unset_column('fakultetId');
            echo $this->datatables->generate();
            die();
        }
        
     
        $data['modul'] = 'admin/moduls/fakulteti/fakulteti_index';

        $this->load->view('admin/template', $data);
    }

    // Update
    function edit($fakultetId = 0) {

        if (!$fakultetId)
            redirect('admin/fakulteti');

        $data['fakultet'] = $this->fakultet_model->GetFakulteti(array('fakultetId' => $fakultetId));


        if (!$data['fakultet'])
            redirect('admin/fakulteti');

        // Validate form

       $this->form_validation->set_rules('fakultetName', 'Име', 'trim|required');
        $this->form_validation->set_rules('fakultetType', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('fakultetYears', 'години на студирање', 'trim|required');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s"); // Mos ke bide koristeno vo maks lenght

        
        if ($this->form_validation->run()) {
            $_POST['fakultetId'] = $fakultetId;
            
            $this->fakultet_model->UpdateFakultet($_POST);
            $this->session->set_flashdata('flashConfirm', 'Информациите за факултетот се успешно запишани!');
            
            redirect('admin/fakulteti');


            //            if ($this->user_model->UpdateUser($_POST) && $this->fakultet_model->UpdateFakultet($_POST)) {
            //                    $this->session->set_flashdata('flashConfirm', 'The user has been successfully updated.');
            //                    redirect('fakultet/Fakulteti');
            //            } else {
            //                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your fakultetistrator USER.');
            //                redirect('fakultet/Fakulteti');
            //            }
        }
        
        $data['modul'] = 'admin/moduls/fakulteti/fakulteti_edit_form';
        $this->load->view('admin/template', $data);
    }

    // Delete
    function delete($fakultetId) {
        $data['fakultet'] = $this->fakultet_model->GetFakulteti(array('fakultetId' => $fakultetId));
        
        if (!$data['fakultet'])
            redirect('fakultet/users');

        $this->fakultet_model->UpdateFakultet(array(
             'fakultetId' => $fakultetId,
            'fakultetStatus' => 'deleted'
        ));



        $this->session->set_flashdata('flashConfirm', 'Факултетот е успешно избришен!');
        redirect('admin/fakulteti');
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

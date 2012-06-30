<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profesors extends CI_Controller {

    private $_tableName;

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid admin account to access this section.');
            redirect('login');
        } else {
            $this->load->model('profesor_model');
            $this->load->model('admin_model');
            $admin = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $admin->adminFirstName);
            $this->session->set_userdata('userLastName', $admin->adminLastName);
            $this->_tableName = 'admins';
        }
    }

    public function overview($id = 0) {

        if ($id != 0 && preg_match('/^[0-9]+$/', $id)) {
            $data['profesor'] = $this->profesor_model->GetProfesors(array('profesorId' => $id));
            $data['modul'] = 'profesor/moduls/profesors/profesors_overview.php';
            $this->load->view('profesor/template', $data);
            //print_r($data['profesor']);
        } else
            redirect('profesor/profesors');
    }

    // Create
    function add() {
        // Validate form
        $this->form_validation->set_rules('profesorFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('profesorLastName', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('userName', 'лозинка', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'лозинка', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('profesorEmail', 'емаил', 'trim|valid_email');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('valid_email', "Мора да внесете валидна емаил адреса");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s");

        if ($this->form_validation->run()) {
            // Validation passes
            $_POST['userType'] = 'profesor';
            $_POST['userStatus'] = $_POST['profesorStatus'];

            $userId = $this->user_model->AddUser($_POST);

            if ($userId) {
                $_POST['profesorUserId'] = $userId;

                $profesorId = $this->profesor_model->AddProfesor($_POST);
                if ($profesorId) {
                    $this->session->set_flashdata('flashConfirm', 'Успешно е додаден нов професор');
                    redirect('admin/users#nice2');
                } else {
                    $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                    redirect('admin/users#nice2');
                }
            } else {
                $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                redirect('admin/users#nice2');
            }
        }

        $data['page'] = 'profesors';
        $data['subPage'] = 'add';
        $data['modul'] = 'admin/moduls/profesors/profesors_add_form';

        $this->load->view('admin/template', $data);
    }

    // Retrieve
    function index($offset = 0) {
        if (isset($_GET['json'])) {
     
            $this->load->library('datatables');
            $this->datatables->select('profesorId, profesorFirstName, profesorLastName, profesorEmail, profesorStatus')->from('profesors')->where('profesorStatus != \'deleted\'');
            $actions = '<a class="button small no-padding blue" style="line-height:0 !important; padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/profesors/edit/$1">Измени</a> | <a class="button small no-padding red" style="line-height:0 !important;padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/profesors/delete/$1">Избриши</a>';
            $this->datatables->add_column('actions', $actions, 'profesorId');
            $this->datatables->unset_column('profesorId');
            echo $this->datatables->generate();
            die();
        } else
            redirect(base_url() . 'profesor/users');
    }

    // Update
    function edit($profesorId = 0) {

        if (!$profesorId)
            redirect('admin/profesors');

        $data['profesor'] = $this->profesor_model->GetProfesors(array('profesorId' => $profesorId));


        if (!$data['profesor'])
            redirect('profesor/profesors');

        // Validate form

        $this->form_validation->set_rules('profesorFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('profesorLastName', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('userName', 'лозинка', 'trim|required');
        $this->form_validation->set_rules('profesorEmail', 'емаил', 'trim|valid_email');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('valid_email', "Мора да внесете валидна емаил адреса");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s");

        if ($this->form_validation->run()) {
            $_POST['userId'] = $data['profesor']->profesorUserId;
            $_POST['profesorId'] = $profesorId;
            $_POST['userStatus'] = $_POST['profesorStatus'];
            $_POST['userType'] = 'profesor';
            // Validation passes
            if (empty($_POST['userPassword']))
                unset($_POST['userPassword']);
            //die(print_r($_POST));
            $this->user_model->UpdateUser($_POST);
            $this->profesor_model->UpdateProfesor($_POST);
            $this->session->set_flashdata('flashConfirm', 'Информациите за професорот се успешно запишани!');
            
            redirect('admin/users#nice2');


            //            if ($this->user_model->UpdateUser($_POST) && $this->profesor_model->UpdateProfesor($_POST)) {
            //                    $this->session->set_flashdata('flashConfirm', 'The user has been successfully updated.');
            //                    redirect('profesor/Profesors');
            //            } else {
            //                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your profesoristrator USER.');
            //                redirect('profesor/Profesors');
            //            }
        }
        
        $data['modul'] = 'admin/moduls/profesors/profesors_edit_form';
        $this->load->view('admin/template', $data);
    }

    // Delete
    function delete($profesorId) {
        $data['profesor'] = $this->profesor_model->GetProfesors(array('profesorId' => $profesorId));
        $data['user'] = $this->user_model->GetUsers(array('userId' => $data['profesor']->profesorUserId));

        if (!$data['profesor'])
            redirect('admin/users#nice2');

        $this->profesor_model->UpdateProfesor(array(
            'profesorId' => $data['profesor']->profesorId,
            'profesorStatus' => 'deleted'
        ));

        $this->user_model->UpdateUser(array(
            'userId' => $data['user']->userId,
            'userStatus' => 'deleted'
        ));
        


        $this->session->set_flashdata('flashConfirm', 'Професорот е успешно избришен!');
        redirect('admin/users#nice2');
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

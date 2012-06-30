<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admins extends CI_Controller {

    private $_tableName;

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid admin account to access this section.');
            redirect('login');
        } else {
            $this->load->model('admin_model');
            $admin = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $admin->adminFirstName);
            $this->session->set_userdata('userLastName', $admin->adminLastName);
            $this->_tableName = 'admins';
        }
    }

    public function overview($id = 0) {

        if ($id != 0 && preg_match('/^[0-9]+$/', $id)) {
            $data['admin'] = $this->admin_model->GetAdmins(array('adminId' => $id));
            $data['modul'] = 'admin/moduls/admins/admins_overview.php';
            $this->load->view('admin/template', $data);
            //print_r($data['admin']);
        } else
            redirect('admin/admins');
    }

    // Create
    function add() {
        // Validate form
        $this->form_validation->set_rules('adminFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('adminLastName', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('userName', 'лозинка', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'лозинка', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('adminEmail', 'емаил', 'trim|valid_email');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('valid_email', "Мора да внесете валидна емаил адреса");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s");

        if ($this->form_validation->run()) {
            // Validation passes
            $_POST['userType'] = 'admin';
            $_POST['userStatus'] = $_POST['adminStatus'];

            $userId = $this->user_model->AddUser($_POST);

            if ($userId) {
                $_POST['adminUserId'] = $userId;

                $adminId = $this->admin_model->AddAdmin($_POST);
                if ($adminId) {
                    $this->session->set_flashdata('flashConfirm', 'Успешно е додаден нов администратор');
                    redirect('admin/users');
                } else {
                    $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                    redirect('admin/users');
                }
            } else {
                $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                redirect('admin/userss');
            }
        }

        $data['page'] = 'admins';
        $data['subPage'] = 'add';
        $data['modul'] = 'admin/moduls/admins/admins_add_form';

        $this->load->view('admin/template', $data);
    }

    // Retrieve
    function index($offset = 0) {
        if (isset($_GET['json'])) {
            $this->load->library('datatables');
            $this->datatables->select('adminId, adminFirstName, adminLastName, adminEmail, adminStatus')->from('admins')->where('adminStatus != \'deleted\'');
            $actions = '<a class="button small no-padding blue" style="line-height:0 !important; padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/admins/edit/$1">Измени</a> | <a class="button small no-padding red" style="line-height:0 !important;padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/admins/delete/$1">Избриши</a>';
            $this->datatables->add_column('actions', $actions, 'adminId');
            $this->datatables->unset_column('adminId');
            echo $this->datatables->generate();
            die();
        } else
            redirect(base_url() . 'admin/users');
    }

    // Update
    function edit($adminId = 0) {

        if (!$adminId)
            redirect('admin/admins');

        $data['admin'] = $this->admin_model->GetAdmins(array('adminId' => $adminId));


        if (!$data['admin'])
            redirect('admin/admins');

        // Validate form

        $this->form_validation->set_rules('adminFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('adminLastName', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('userName', 'лозинка', 'trim|required');
        $this->form_validation->set_rules('adminEmail', 'емаил', 'trim|valid_email');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('valid_email', "Мора да внесете валидна емаил адреса");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s");

        if ($this->form_validation->run()) {
            $_POST['userId'] = $data['admin']->adminUserId;
            $_POST['adminId'] = $adminId;
            $_POST['userStatus'] = $_POST['adminStatus'];

            // Validation passes
            if (empty($_POST['userPassword']))
                unset($_POST['userPassword']);
            //die(print_r($_POST));
            $this->user_model->UpdateUser($_POST);
            $this->admin_model->UpdateAdmin($_POST);
            $this->session->set_flashdata('flashConfirm', 'Информациите за администраторот се успешно запишани!');
            
            redirect('admin/users');


            //            if ($this->user_model->UpdateUser($_POST) && $this->admin_model->UpdateAdmin($_POST)) {
            //                    $this->session->set_flashdata('flashConfirm', 'The user has been successfully updated.');
            //                    redirect('admin/Admins');
            //            } else {
            //                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your administrator USER.');
            //                redirect('admin/Admins');
            //            }
        }
        
        $data['modul'] = 'admin/moduls/admins/admins_edit_form';
        $this->load->view('admin/template', $data);
    }

    // Delete
    function delete($adminId) {
        $data['admin'] = $this->admin_model->GetAdmins(array('adminId' => $adminId));
        $data['user'] = $this->user_model->GetUsers(array('userId' => $data['admin']->adminUserId));

        if (!$data['admin'])
            redirect('admin/users');

        $this->admin_model->UpdateAdmin(array(
            'adminId' => $data['admin']->adminId,
            'adminStatus' => 'deleted'
        ));

        $this->user_model->UpdateUser(array(
            'userId' => $data['user']->userId,
            'userStatus' => 'deleted'
        ));
        


        $this->session->set_flashdata('flashConfirm', 'Администраторот е успешно избришен!');
        redirect('admin/users');
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

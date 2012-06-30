<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Students extends CI_Controller {

    private $_tableName;

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid admin account to access this section.');
            redirect('login');
        } else {
            $this->load->model('student_model');
            $this->load->model('admin_model');
            $admin = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $admin->adminFirstName);
            $this->session->set_userdata('userLastName', $admin->adminLastName);
            $this->_tableName = 'admins';
        }
    }

    public function overview($id = 0) {

        if ($id != 0 && preg_match('/^[0-9]+$/', $id)) {
            $data['student'] = $this->student_model->GetStudents(array('studentId' => $id));
            $data['modul'] = 'student/moduls/students/students_overview.php';
            $this->load->view('student/template', $data);
            //print_r($data['student']);
        } else
            redirect('student/students');
    }

    // Create
    function add() {
        // Validate form
        $this->form_validation->set_rules('studentFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('studentLastName', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('userName', 'лозинка', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'лозинка', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('studentEmail', 'емаил', 'trim|valid_email');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('valid_email', "Мора да внесете валидна емаил адреса");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s");

        if ($this->form_validation->run()) {
            // Validation passes
            $_POST['userType'] = 'student';
            $_POST['userStatus'] = $_POST['studentStatus'];

            $userId = $this->user_model->AddUser($_POST);

            if ($userId) {
                $_POST['studentUserId'] = $userId;

                $studentId = $this->student_model->AddStudent($_POST);
                if ($studentId) {
                    $this->session->set_flashdata('flashConfirm', 'Успешно е додаден нов Студент!');
                    redirect('admin/users#nice3');
                } else {
                    $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                    redirect('admin/users#nice3');
                }
            } else {
                $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                redirect('admin/users#nice3');
            }
        }

        $data['page'] = 'students';
        $data['subPage'] = 'add';
        $data['modul'] = 'admin/moduls/students/students_add_form';

        $this->load->view('admin/template', $data);
    }

    // Retrieve
    function index($offset = 0) {
        if (isset($_GET['json'])) {
     
            $this->load->library('datatables');
            $this->datatables->select('studentId, studentFirstName, studentLastName, studentEmail, studentStatus')->from('students')->where('studentStatus != \'deleted\'');
            $actions = '<a class="button small no-padding blue" style="line-height:0 !important; padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/students/edit/$1">Измени</a> | <a class="button small no-padding red" style="line-height:0 !important;padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/students/delete/$1">Избриши</a>';
            $this->datatables->add_column('actions', $actions, 'studentId');
            $this->datatables->unset_column('studentId');
            echo $this->datatables->generate();
            die();
        } else
            redirect(base_url() . 'student/users');
    }

    // Update
    function edit($studentId = 0) {

        if (!$studentId)
            redirect('admin/students');

        $data['student'] = $this->student_model->GetStudents(array('studentId' => $studentId));


        if (!$data['student'])
            redirect('student/students');

        // Validate form

        $this->form_validation->set_rules('studentFirstName', 'Име', 'trim|required');
        $this->form_validation->set_rules('studentLastName', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('userName', 'лозинка', 'trim|required');
        $this->form_validation->set_rules('studentEmail', 'емаил', 'trim|valid_email');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('valid_email', "Мора да внесете валидна емаил адреса");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s");

        if ($this->form_validation->run()) {
            $_POST['userId'] = $data['student']->studentUserId;
            $_POST['studentId'] = $studentId;
            $_POST['userStatus'] = $_POST['studentStatus'];
            $_POST['userType'] = 'student';
            // Validation passes
            if (empty($_POST['userPassword']))
                unset($_POST['userPassword']);
            //die(print_r($_POST));
            $this->user_model->UpdateUser($_POST);
            $this->student_model->UpdateStudent($_POST);
            $this->session->set_flashdata('flashConfirm', 'Информациите за студентот се успешно запишани!');
            
            redirect('admin/users#nice2');


            //            if ($this->user_model->UpdateUser($_POST) && $this->student_model->UpdateStudent($_POST)) {
            //                    $this->session->set_flashdata('flashConfirm', 'The user has been successfully updated.');
            //                    redirect('student/Students');
            //            } else {
            //                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your studentistrator USER.');
            //                redirect('student/Students');
            //            }
        }
        
        $data['modul'] = 'admin/moduls/students/students_edit_form';
        $this->load->view('admin/template', $data);
    }

    // Delete
    function delete($studentId) {
        $data['student'] = $this->student_model->GetStudents(array('studentId' => $studentId));
        $data['user'] = $this->user_model->GetUsers(array('userId' => $data['student']->studentUserId));

        if (!$data['student'])
            redirect('admin/users#nice2');

        $this->student_model->UpdateStudent(array(
            'studentId' => $data['student']->studentId,
            'studentStatus' => 'deleted'
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

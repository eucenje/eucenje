<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Predmeti extends CI_Controller {

    private $_tableName;

    public function __construct() {
        parent::__construct();

        if (!$this->user_model->Secure(array('userType' => 'admin'))) {
            $this->session->set_flashdata('flashError', 'You must be logged into a valid predmet account to access this section.');
            redirect('login');
        } else {
            $this->load->model('predmet_model');
            $this->load->model('admin_model');
            $admin = $this->admin_model->GetAdmins(array('adminUserId' => $this->session->userdata['userId']));
            $this->session->set_userdata('userFirstName', $admin->adminFirstName);
            $this->session->set_userdata('userLastName', $admin->adminLastName);
            $this->_tableName = 'predmeti';
        }
    }

    public function overview($id = 0) {

        if ($id != 0 && preg_match('/^[0-9]+$/', $id)) {
            $data['predmet'] = $this->predmet_model->GetPredmeti(array('predmetId' => $id));
            $data['modul'] = 'predmet/moduls/predmets/predmets_overview.php';
            $this->load->view('predmet/template', $data);
            //print_r($data['predmet']);
        } else
            redirect('predmet/predmets');
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
                    redirect('admin/predmeti');
                } else {
                    $this->session->set_flashdata('flashError', 'Се појави грешка!! Контактирајте го тимот кој го развива проектот.');
                    redirect('admin/predmeti');
                }
        
        }
        $this->load->model('fakultet_model');
        $faks = $this->fakultet_model->getFakulteti();
        $fakulteti=array();
        foreach($faks as $fak){
            $fakulteti[$fak->fakultetId] = $fak->fakultetName;
        }
        
        $this->load->model('profesor_model');
        $profs = $this->profesor_model->getProfesors();
        $profesors=array();
        foreach($profs as $pro){
            $profesors[$pro->profesorId] = $pro->profesorFirstName.' '.$pro->profesorLastName ;
        }
        
        $data['profesors'] = $profesors;
        $data['fakulteti'] = $fakulteti;
        
        $data['modul'] = 'admin/moduls/predmeti/predmeti_add_form';

        $this->load->view('admin/template', $data);
    }

    // Retrieve
    function index($offset = 0) {
        
        if (isset($_GET['json'])) {
            $this->load->library('datatables');
            $this->datatables->select('predmetId, predmetName, predmetStatus')->from('predmeti')->where('predmetStatus != \'deleted\'');
            $actions = '<a class="button small no-padding blue" style="line-height:0 !important; padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/predmeti/edit/$1">Измени</a> | <a class="button small no-padding red" style="line-height:0 !important;padding-left: 5px;padding-right: 5px;" href="' . base_url() . 'admin/predmeti/delete/$1">Избриши</a>';
            $this->datatables->add_column('actions', $actions, 'predmetId');
            $this->datatables->unset_column('predmetId');
            echo $this->datatables->generate();
            die();
        }
        
     
        $data['modul'] = 'admin/moduls/predmeti/predmeti_index';

        $this->load->view('admin/template', $data);
    }

    // Update
    function edit($predmetId = 0) {

        if (!$predmetId)
            redirect('admin/predmeti');

        $data['predmet'] = $this->predmet_model->GetPredmeti(array('predmetId' => $predmetId));


        if (!$data['predmet'])
            redirect('admin/predmeti');

        // Validate form

       $this->form_validation->set_rules('predmetName', 'Име', 'trim|required');
        $this->form_validation->set_rules('predmetType', 'Презиме', 'trim|required');
        $this->form_validation->set_rules('predmetYears', 'лозинка', 'trim|required');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
        $this->form_validation->set_message('min_length', "Минимална должина за %s e %s"); // Mos ke bide koristeno vo maks lenght

        
        if ($this->form_validation->run()) {
            $_POST['predmetId'] = $predmetId;
            
            $this->predmet_model->UpdatePredmet($_POST);
            $this->session->set_flashdata('flashConfirm', 'Информациите за факултетот се успешно запишани!');
            
            redirect('admin/predmeti');


            //            if ($this->user_model->UpdateUser($_POST) && $this->predmet_model->UpdatePredmet($_POST)) {
            //                    $this->session->set_flashdata('flashConfirm', 'The user has been successfully updated.');
            //                    redirect('predmet/Predmeti');
            //            } else {
            //                $this->session->set_flashdata('flashError', 'A database error has occured, please contact your predmetistrator USER.');
            //                redirect('predmet/Predmeti');
            //            }
        }
        
        $data['modul'] = 'admin/moduls/predmeti/predmeti_edit_form';
        $this->load->view('admin/template', $data);
    }

    // Delete
    function delete($predmetId) {
        $data['predmet'] = $this->predmet_model->GetPredmeti(array('predmetId' => $predmetId));
        
        if (!$data['predmet'])
            redirect('predmet/users');

        $this->predmet_model->UpdatePredmet(array(
             'predmetId' => $predmetId,
            'predmetStatus' => 'deleted'
        ));



        $this->session->set_flashdata('flashConfirm', 'Факултетот е успешно избришен!');
        redirect('admin/predmeti');
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

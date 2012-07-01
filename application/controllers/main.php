<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

       public function __construct()
       {
            parent::__construct();
            $this->load->model('user_model');
       }
	function login()
	{	
            
		$this->form_validation->set_rules('userName', 'Корисничко име', 'trim|required|callback__check_login');
		$this->form_validation->set_rules('userPassword', 'Лозинка', 'trim|required');

        $this->form_validation->set_message('required', "Полето %s е задолжително");
		if($this->form_validation->run())
		{
			// the form has successfully validated
			if($this->user_model->Login(array('userName' => $this->input->post('userName'), 'userPassword' => $this->input->post('userPassword'))))
			{
                                
				$this->user_model->redirect_by_level();
			} redirect('login');
		}
		
		$this->load->view('login');
	}
	
	function logout()
	{
	    $this->session->sess_destroy();
	    redirect('login');
	}
	
	function index()
	{
		// if session is and user loged in redirect to his dashboard
		//print_r($this->session->userdata);
		
		$this->user_model->redirect_by_level();

		//$this->load->view('login');
	}
	
	function _check_login($userName)
	{
		if($this->input->post('userPassword'))
		{
			$user = $this->user_model->GetUsers(array('userName' => $userName, 'userPassword' => md5($this->input->post('userPassword'))));
			if($user) return true;
		}
		
		$this->form_validation->set_message('_check_login', 'Вашето корисничкото име или лозинка е неточно!');
		return false;
	}
}

/* End of file main.php */
/* Location: ./system/application/controllers/main.php */

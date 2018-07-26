<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CS_Controller 
{

	public function __construct()
	{		 
		parent::__construct();

		/* Load Modals */
		$this->load->model('Admin_model');		
	}

	public function index()
	{
		echo "Chhavi";
	}

	private function is_login()
	{
		return $this->session->is_admin;
	}

	public function login()
	{
		//$Data = $this->input->post();
	 	$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == FALSE)
        {
                $this->load->view('myform');
        }
        else
        {
                $this->Admin_model->login($Data);
        }		
		
	}

	private function generateSession( $Data )
	{
		$SessionSetup =  array(
			'user_id'	=> $Data['user_ID'],
			'firstname'	=> $Data['firstname'],
			'email'		=> $Data['email'],
			'is_admin' 	=> true
		);

		$this->session->set_userdata($SessionSetup);
	}
}

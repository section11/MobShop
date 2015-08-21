<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function login(){
	
	}	
		
	public function logout(){
		$this->auth_model->logout();
		redirect('auth/login');
	}
}

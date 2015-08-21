<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {
	
	
	public function is_logged(){
		//return ($this->session->userdata('logat') === TRUE);
		return true;
	}
	
	public function logout(){
		$this->session->sess_destroy();
	}
}

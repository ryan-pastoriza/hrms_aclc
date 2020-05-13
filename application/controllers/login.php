<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->login_page();
	}
	public function login_page(){
		$data['title'] = 'Daily Time Record with Payroll';
		$this->load->view('login',$data);
	}
	public function try_login(){
		$sec = new Securitys;
		$user = $sec->verify_login($this->input->post('username'),$this->input->post('password'));
		if($user){
			$sec->login($user);
			echo "<script>location.reload();</script>";
		}else{
			echo 'Invalid username or password.';
		}
	}
}

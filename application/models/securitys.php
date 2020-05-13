<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/

class Securitys extends MY_Model{
	public function __construct(){
		parent::__construct();
	}
	public function verify_login($username='',$password=''){

		
		$password = md5($password);
		$user = new Users;
		$search = $user->search(array('username' => $username,'password' => $password));
		if(count($search) > 0){
			return reset($search);
		}
		return false;
	}
	public function login($user = false){
		$array = array(
			'DP_USER_ID' => $user->employee_id,
			'DP_USER_PRIV' => $user->user_privilege,
		);
		$this->session->set_userdata( $array );
	}
	public function whose_logged(){
		if ($this->session->userdata('DP_USER_ID')) {
			$this->load->model('employee');
			$emp = new Employee;
			$emp->sqlQueries['join_type'] = "LEFT";
			$emp->toJoin = ['employment' => 'employee',
							'users' => 'employee',
							'department' => 'employment',
							'employee_est_classifications' => 'employee'];
			$emp->load($this->session->userdata('DP_USER_ID'));

			return $emp;
		}
		return false;
	}
	public function redirect_user(){
		if($this->whose_logged() &&  $this->session->userdata("DP_USER_PRIV") == "employee" && $this->uri->segment(1) != 'employee' && $this->uri->segment(2) != 'personnel_information'){
			redirect('/employee/dashboard','refresh');
		}else if($this->whose_logged() && $this->session->userdata("DP_USER_PRIV") == "admin" && $this->uri->segment(1) != "admin"){
			redirect('/admin/home','refresh');
		}
		else if(!$this->whose_logged() && ($this->uri->segment(1) == 'admin' || $this->uri->segment(1) == "employee")){
			redirect('/login','refresh');
		}
	}

	public function logout(){
		$this->session->unset_userdata('DP_USER_PRIV');
		$this->session->unset_userdata('DP_USER_ID');
		$this->redirect_user();
	}
	
}
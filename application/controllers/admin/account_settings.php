<?php
/**
 * @Author: khrey
 * @Date:   2015-10-16 16:31:38
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-27 15:37:47
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_settings extends MY_Controller {

	public function index()
	{
		$this->load->model('users');
		$this->load->model('attendance_rule');
		$userInfo = new Users;
		$user = $userInfo->search(array('employee_id' => $this->userInfo->employee_id));
		$user = reset($user);
		$rule = new Attendance_rule;
		$hasRule = $rule->get(1);
		$theRule = false;

		if (!$hasRule) {
			$newRule = new Attendance_rule;
			$newRule->late_hr_max = 0;
			$newRule->late_min_max = 0;
			$newRule->ut_hr_max = 0;
			$newRule->ut_min_max = 0;
			$newRule->save();
			$theRule = $newRule;
		}
		else{
			$theRule = reset($hasRule);
		}

		$header_data = array('title' => 'Account Settings', 'sub_title' => '');
		$settings_data = array('userInfo' => $user ,
								'att_rule' => $theRule);

		$this->load->view('admin/header');
		$this->load->view('admin/navigation');
		$this->load->view('admin/content_header',$header_data);
		$this->load->view('admin/settings',$settings_data);
	}
	public function change_username()
	{
		$toret = array();
		$this->load->model('users');
		$userInfo = new Users;
		$user = $userInfo->search(array('employee_id' => $this->userInfo->employee_id));
		$user = reset($user);
		$user->username = $this->input->post('username');
		$user->save();
		$toret['view'] = $this->load->view('shared/success', array('successMsg' => 'Username Changed'), TRUE);
		echo json_encode($toret);
	}
	public function change_password()
	{
		$toret = array();
		$this->load->model('users');
		$userInfo = new Users;
		$user = $userInfo->search(array('employee_id' => $this->userInfo->employee_id));
		$user = reset($user);
		$user->password = md5($this->input->post('newPass1'));
		$user->save();
		$toret['view'] = $this->load->view('shared/success', array('successMsg' => 'Password Changed'), TRUE);
		echo json_encode($toret);
	}
	function verify_password(){
		$this->load->model('users');
		$userInfo = new Users;
		$user = $userInfo->search(array('employee_id' => $this->userInfo->employee_id));
		$user = reset($user);
		if ($user->password == md5($this->input->post('password'))) {
			echo true;
			return;
		}
		echo false;
	}
	public function save_attendance_rules()
	{
		$this->load->model('attendance_rule');
		$attRule = new Attendance_rule;
		$hasRule = $attRule->get(1);
		$theRule = false;
		$toRet = array();


		if ($hasRule) {
			$theRule = reset($hasRule);
		}
		else{
			$theRule = new Attendance_rule;
		}
		$theRule->late_hr_max = $this->input->post('late_hr_max');
		$theRule->late_min_max = $this->input->post('late_min_max');
		$theRule->ut_hr_max = $this->input->post('ut_hr_max');
		$theRule->ut_min_max = $this->input->post('ut_min_max');
		// $theRule->uw_hr_max = $this->input->post('uw_hr_max');
		// $theRule->uw_min_max = $this->input->post('uw_min_max');

		$theRule->save();
	
		$toRet['view'] = $this->load->view('shared/success',array('successMsg' => "Attendance Rule Saved!", ), TRUE);		
		echo json_encode($toRet);
	}

}

/* End of file account_settings.php */
/* Location: ./application/controllers/admin/account_settings.php */
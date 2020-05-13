<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

	public function index()
	{
		echo lte_load_view('register', []);
	}
	public function check_register()
	{
		$this->load->model('keycode');

		$result = ['success' => true,
					'txt' => '<span class="text-green"> User Registration Complete!</span><hr>'];

		$kCode = new Keycode;
		$valid = $kCode->pop(['employee_id' => $this->input->post('employee_id'),
							'keycode' => $this->input->post('keycode')]);

		if ($valid->keycode == "") {
			$result['success'] = false;
			$result['txt'] 	= "<span class='text-red'>Invalid keycode or employee ID!</span><hr>";
		}
		elseif ($this->input->post('password') != $this->input->post('password2')) {
			$result['success'] = false;
			$result['txt'] 	= "<span class='text-red'>Passwords don't match!</span><hr>";
		}
		else{
			$this->load->model('users');
			$user 			= new Users;
			$userExists 	= $user->pop(['employee_id' => $this->input->post('employee_id')]);

			if ($userExists->username != "") {
				$result['success'] 	= false;
				$result['txt'] 		= "<span class='text-red'>Keycode already registered!</span><hr>";
			}
			else{
				$user->username = $this->input->post('employee_id');
				$user->password = md5($this->input->post('password'));
				$user->employee_id = $this->input->post('employee_id');
				$user->user_privilege = "employee";
				$user->save();
			}
		}
		echo json_encode($result);
	}

}

/* End of file register.php */
/* Location: ./application/controllers/register.php */
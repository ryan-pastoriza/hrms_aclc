<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_accounts extends MY_Controller {

	public function index()
	{
		$this->create_head_and_navi();


		$data = ['empData' => $this->emp_json_data() ];

		$account_gen = $this->load->view('admin/user_accounts/generate_account',$data, TRUE);

		create_content(['contentHeader' => "User Accounts",
						'content' => [$account_gen]]);
		$this->create_footer([$this->load->view('admin/user_accounts/gen_account/jscript',[], TRUE)]);
		
	}
	public function generate_keycode($employee_id)
	{
		$this->load->model('keycode');
		$kCode = new Keycode;
		
		$hasKeyCode = $kCode->pop(['employee_id' => $employee_id]);

		if ($hasKeyCode->keycode == "") {
			$randomNum = rand(0,100000);
			$keycode = hash('adler32',"aC".$randomNum."lC");

			$nKeyCode = new Keycode;
			$nKeyCode->employee_id = $employee_id;
			$nKeyCode->keycode = $keycode;
			$nKeyCode->save();
			echo $keycode; 
		}
		else{
			echo $hasKeyCode->keycode;
		}
	}
}

/* End of file user_accounts.php */
/* Location: ./application/controllers/admin/user_accounts.php */
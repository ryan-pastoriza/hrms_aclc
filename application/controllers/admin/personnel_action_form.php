<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personnel_Action_Form extends MY_Controller {

	public function index() {
		$allEmp = $this->basic_emp_json();
		$data  = array(
					"allEmp" => $allEmp,
					"allDept" => $this->load_dept()
				);
		$contents = array(
				$this->load->view('admin/PAF/main', $data, true)
			);
		$this->create_head_and_navi(
			array(asset_url('plugins/datatables/jquery.dataTables.min.js'),
				asset_url('plugins/datatables/dataTables.bootstrap.min.js')),
			array(asset_url('plugins/datatables/dataTables.bootstrap.css'))
		);
		create_content(array(
			'contentHeader' => 'Personnel Action Form',
			'breadCrumbs' => true,
			'content' => $contents
			));
		$this->create_footer();
	}

	public function paf_json(){
		$this->load->model('employee_paf');
		$paf = new Employee_Paf;
		$paf->toJoin = array('employee' => 'employee_paf', 'employment' => 'employee', 'department' => 'employment');
		$all = $paf->get();
		$data = array('data' => array());
		foreach ($all as $key => $value) {
			$data['data'][] = array(
									$value->fullName('f m. l'),
									$value->department_name,
									$value->emp_paf_action_taken,
									$value->emp_paf_date_filed,
									'<button class="btn btn-flat btn-primary btn-xs" title="Print" name="'.$value->emp_paf_id.'" onclick="print_this(this)"><span class="fa fa-print"></span></button>'
								);
		}
		echo json_encode($data);
	}
	public function load_dept(){
		$this->load->model("department");
		$dept = new Department;
		$depts = $dept->get();

		return $depts;
	}

	public function add_paf(){
		$data = [];
		if(sizeof($this->input->post('action')) > 1){
			
			for($i= 0;$i < sizeof($this->input->post('action'));$i++){

				$this->load->model('employee');
				$this->load->model("employment");
				$this->load->model('department');
				$this->load->model('employee_paf');

				$emp = new Employee;
				$paf = new Employee_Paf;
				$dept = new Department;
				$employment = new Employment;


				

				$paf->employee_id = $this->input->post('employee_id');
		
				$sel_action 					= $this->input->post('select_action');
				$sel_pur 						= $this->input->post('select_purpose');
				$paf->emp_paf_date_filed 		= $this->input->post('date_filed');
				$paf->emp_paf_action_taken 		= $this->input->post('action');
				$paf->emp_paf_effectivity_date 	= $this->input->post('effectivity_date');
				$paf->emp_paf_justification 	= $this->input->post('justification');


				$emp->load_with_employment_info($paf->employee_id);
				$employment->load($emp->employment_id);

				if($employment->sss_no == NULL || $employment->sss_no == ""){
					if($this->input->post("sss") != ""){
						$employment->sss_no = $this->input->post("sss");
						$employment->save();
					}
				}
				if($employment->tin_no == NULL || $employment->tin_no == ""){
					if($this->input->post("tin") != ""){
						$employment->tin_no = $this->input->post("tin");
						$employment->save();
					}
				}
				if($employment->atm_no == NULL || $employment->atm_no == ""){
					if($this->input->post("atm_acct_no") != ""){
						$employment->atm_no = $this->input->post("atm_acct_no");
						$employment->save();
					}
				}
				if($employment->pagibig_no == NULL || $employment->pagibig_no == ""){
					if($this->input->post("pagibig") != ""){
						$employment->pagibig_no = $this->input->post("pagibig");
						$employment->save();
					}
				}
				if($employment->philhealth_no == NULL || $employment->philhealth_no == ""){
					if($this->input->post("phic") != ""){
						$employment->philhealth_no = $this->input->post("phic");
						$employment->save();
					}
				}
				if($employment->tax == NULL || $employment->tax == ""){
					if($this->input->post("tax_exemption") != ""){
						$employment->tax = $this->input->post("tax_exemption");
						$employment->save();
					}
				}

				if($sel_action == 0){
					$data['msg'] = "Please select action.";
					$data['success'] = false;
				}

				//select action
				if($this->input->post('action')[$i] == "EMPLOYMENT STATUS"){
					
					$employment->employment_type = $this->input->post('tos')[$i];

					$paf->emp_paf_action_taken = "EMPLOYMENT STATUS";
					$paf->emp_paf_from_employment = $this->input->post('current')[$i];
					$paf->emp_paf_to_employment = $this->input->post('tos')[$i];
					$data['msg'] = "Successfully saved.";
					$employment->save();
					$paf->save();
				}

				if($this->input->post('action')[$i] == "DEPARTMENT"){
					$employment->department_id = $this->input->post('tos')[$i];

					$paf->emp_paf_action_taken = "DEPARTMENT";
					$paf->emp_paf_from_department = $this->input->post('current')[$i];
					
					$dept->load($this->input->post('to')[$i]);
					$paf->emp_paf_to_department = $dept->department_name;
					

					$data['msg'] = "Successfully saved.";
					$employment->save();
					$paf->save();
				}

				if($this->input->post('action')[$i] == "BASIC SALARY"){

					$paf->emp_paf_action_taken = "BASIC SALARY";
					$paf->emp_paf_from_basic_sal = $employment->employment_rate;
					$paf->emp_paf_to_basic_sal = $this->input->post('tos')[$i];

					$data['msg'] = "Successfully saved.";
					$paf->save();

				}

				if($this->input->post('action')[$i] == "TRANSPORTATION"){

					$paf->emp_paf_action_taken = "TRANSPORTATION";
					$paf->emp_paf_from_transportation = $this->input->post('current')[$i];
					$paf->emp_paf_to_transportation = $this->input->post('tos')[$i];

					$data['msg'] = "Successfully saved.";
					$paf->save();

				}

				if($this->input->post('action')[$i] == "MEAL ALLOWANCE"){

					$paf->emp_paf_action_taken = "MEAL ALLOWANCE";
					$paf->emp_paf_from_meal = $this->input->post('current')[$i];
					$paf->emp_paf_to_meal = $this->input->post('tos')[$i];

					$data['msg'] = "Successfully saved.";
					$paf->save();

				}

				if($this->input->post('action')[$i] ==  "OTHERS - COLA"){

					$paf->emp_paf_action_taken = "OTHERS - COLA";
					$paf->emp_paf_from_others = $this->input->post('current')[$i];
					$paf->emp_paf_to_others = $this->input->post('tos')[$i];

					$data['msg'] = "Successfully saved.";
					$paf->save();

				}

			}
			echo json_encode($data);

		}else{

			$this->load->model('employee');
			$this->load->model("employment");
			$this->load->model('department');
			$this->load->model('employee_paf');

			$emp = new Employee;
			$paf = new Employee_Paf;
			$dept = new Department;
			$employment = new Employment;
			$paf->employee_id = $this->input->post('employee_id');
			$sel_action = $this->input->post('select_action');
			$sel_pur = $this->input->post('select_purpose');
			$paf->emp_paf_date_filed = $this->input->post('date_filed');
			$paf->emp_paf_action_taken = $this->input->post('action');
			$paf->emp_paf_effectivity_date = $this->input->post('effectivity_date');
			
			$paf->emp_paf_justification = $this->input->post('justification');

			

			$emp->load_with_employment_info($paf->employee_id);
			$employment->load($emp->employment_id);

			if($this->input->post("sss") != ""){
				$employment->sss_no = $this->input->post("sss");
				$employment->save();
			}
			if($this->input->post("tin") != ""){
				$employment->tin_no = $this->input->post("tin");
				$employment->save();
			}
			if($this->input->post("pagibig") != ""){
				$employment->pagibig_no = $this->input->post("pagibig");
				$employment->save();
			}
			if($this->input->post("phic") != ""){
				$employment->philhealth_no = $this->input->post("phic");
				$employment->save();
			}
			if($this->input->post("atm_acct_no") != ""){
				$employment->atm_no = $this->input->post("atm_acct_no");
				$employment->save();
			}
			if($this->input->post("tax_exemption") != ""){
				$employment->tax = $this->input->post("tax_exemption");
				$employment->save();
			}

			

			if($sel_action == 0){

				$data['msg'] = "Please select action.";
				$data['success'] = false;

			}

			//select action
			if($sel_action == 1){
				
				$employment->employment_type = $this->input->post('toEmpStat');

				$paf->emp_paf_action_taken = "EMPLOYMENT STATUS";
				$paf->emp_paf_from_employment = $this->input->post('from');
				$paf->emp_paf_to_employment = $this->input->post('toEmpStat');
				$data['msg'] = "Successfully saved.";
				$employment->save();
				$paf->save();
			}

			if($sel_action == 2){
				$employment->department_id = $this->input->post('toDept');

				$paf->emp_paf_action_taken = "DEPARTMENT";
				$paf->emp_paf_from_department = $this->input->post('from');
				
				$dept->load($this->input->post('toDept'));
				$paf->emp_paf_to_department = $dept->department_name;
				

				$data['msg'] = "Successfully saved.";
				$employment->save();
				$paf->save();
			}

			if($sel_action == 4){

				$paf->emp_paf_action_taken = "COMPANY";
				$paf->emp_paf_from_company = $this->input->post('from');
				$paf->emp_paf_to_company = $this->input->post('to');

				$data['msg'] = "Successfully saved.";
				$paf->save();
			}

			if($sel_action == 5){
				$paf->emp_paf_action_taken = "BRANCH / WORK AREA";
				$paf->emp_paf_from_branch = $this->input->post('from');
				$paf->emp_paf_to_branch = $this->input->post('to');

				$data['msg'] = "Successfully saved.";
				$paf->save();
			}

			if($sel_action == 6){

				$paf->emp_paf_action_taken = "BASIC SALARY";
				$paf->emp_paf_from_basic_sal = $employment->employment_rate;
				$paf->emp_paf_to_basic_sal = $this->input->post('to');

				$data['msg'] = "Successfully saved.";
				$paf->save();

			}

			if($sel_action == 7){

				$paf->emp_paf_action_taken = "TRANSPORTATION";
				$paf->emp_paf_from_transportation = $this->input->post('from');
				$paf->emp_paf_to_transportation = $this->input->post('to');

				$data['msg'] = "Successfully saved.";
				$paf->save();

			}

			if($sel_action == 8){

				$paf->emp_paf_action_taken = "MEAL ALLOWANCE";
				$paf->emp_paf_from_meal = $this->input->post('from');
				$paf->emp_paf_to_meal = $this->input->post('to');

				$data['msg'] = "Successfully saved.";
				$paf->save();

			}

			if($sel_action == 9){

				$paf->emp_paf_action_taken = "OTHERS - COLA";
				$paf->emp_paf_from_others = $this->input->post('from');
				$paf->emp_paf_to_others = $this->input->post('to');

				$data['msg'] = "Successfully saved.";
				$paf->save();


			}

			echo json_encode($data);
		}
		
		


	}

	public function print_paf() {
		$this->load->model('Employee_Paf');
		$paf = new Employee_Paf;
		$paf->toJoin = array('employee' => 'employee_paf', 'employment' => 'employee', 'department' => 'employment');
		$all = $paf->get();
		$data = array();
		foreach ($all as $key => $value) {
			if($value->emp_paf_id === $this->input->post('emp_paf_id')) {
				$data = array(
					'date_filed' => $value->emp_paf_date_filed,
					'name' => $value->fullName('f m. l'),
					'position' => $value->employment_job_title,
					'hired_date' => date("m/d/Y", strtotime($value->employment_hired_date)),
					'department' => $value->department_name,
					'employment' => $value->employment_type,
					'effectivity_date' => $value->emp_paf_effectivity_date,
					'action' => $value->emp_paf_action_taken,
					'justification' => $value->emp_paf_justification,
					'empl_stat_from' => $value->emp_paf_from_employment,
					'empl_stat_to' => $value->emp_paf_to_employment,
					'dep_from' => $value->emp_paf_from_department,
					'dep_to' => $value->emp_paf_to_department,
					'div_from' => $value->emp_paf_from_division,
					'div_to' => $value->emp_paf_to_division,
					'comp_from' => $value->emp_paf_from_company,
					'comp_to' => $value->emp_paf_to_company,
					'branch_from' => $value->emp_paf_from_branch,
					'branch_to' => $value->emp_paf_to_branch,
					'basic_sal_from' => $value->emp_paf_from_basic_sal,
					'basic_sal_to' => $value->emp_paf_to_basic_sal,
					'trans_from' => $value->emp_paf_from_transportation,
					'trans_to' => $value->emp_paf_to_transportation,
					'meal_from' => $value->emp_paf_from_meal,
					'meal_to' => $value->emp_paf_to_meal,
					'others_from' => $value->emp_paf_from_others,
					'others_to' => $value->emp_paf_to_others,
					'tin_no' => $value->tin_no,
					'phic_no' => $value->philhealth_no,
					'pagibig_no' => $value->pagibig_no,
					'sss_no' => $value->sss_no,
					'atm_no' => $value->atm_no,
					'tax'	=> $value->tax
				);
			}
		}
		$this->load->view('admin/PAF/printable_paf', $data, FALSE);
	}

}

/* End of file personnel_action_form.php */
/* Location: ./application/controllers/admin/personnel_action_form.php */
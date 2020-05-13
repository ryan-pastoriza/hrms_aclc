<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Personnel_Information extends MY_Controller{
		public function index(){
			$this->load->model('department');

			$depts = new Department;
			$allDepts = $depts->search("department_status = 'active'");
			$data  = array("departments" => $allDepts);
			$header_data = array("title" => "New Employee",
								 "sub_title"=> "Personnel Information Sheet");

			$this->create_head_and_navi();

			$pis = $this->load->view('admin/PIS/new/pis',$data,TRUE);

			create_content(array('contentHeader' => 'Personnel Information Sheet',
								 'breadCrumbs' => true,
								 'content' => array($pis)
								)
						  );
			$this->create_footer([
									$this->load->view('admin/PIS/new/jscripts', [],true)
								]);
		}
		public function change_status($employeeID, $newStat)
		{
			$toret = array();
			$this->load->model('employment');
			$this->load->model('employment_record');

			$employment = new Employment;
			$employmentInfo = $employment->search(array('employee_id' => $employeeID));
			$employmentInfo = reset($employmentInfo);
			$employmentInfo->employment_status = $newStat;
			$employmentInfo->save();

			$emp_rec = new Employment_record;
			$emp_rec->employment_id = $employmentInfo->employment_id;
			$emp_rec->emp_rec_type = "Employment Status set to '{$newStat}'";
			$emp_rec->emp_rec_date = date('Y-m-d');
			$emp_rec->save();
		}
		public function set_active()
		{
			$this->change_status($this->input->post('employee_id'), "active");

			$toret['view'] = $this->load->view('shared/success', array('successMsg' => "Employment Record Set to Active."),TRUE);
			$toret['success'] = true;

			echo json_encode($toret);
		}
		public function set_inactive()
		{
			$this->change_status($this->input->post('employee_id'), "inactive");

			$toret['view'] = $this->load->view('shared/success', array('successMsg' => "Employment Record Set to Inactive."),TRUE);
			$toret['success'] = true;

			echo json_encode($toret);
		}
		public function save_employee(){
			$this->load->model('employee');
			$this->load->model('employment');
			$this->load->model('employment_record');
			$employees  = new Employee;
			$employee 	= new Employee;

			$employee->load($this->input->post('employee_id'));

			$employment = new Employment;
			$emp_record = new Employment_Record;
			$data 		= array();
			$ret 		= array();

			/*------------------- set values from PIS ------------------------*/
			foreach ($employees as $key => $value) {
				if ($this->input->post($key)) {
					$employees->$key = $this->input->post($key);
				}
			}

			/*------------------- end of setting values from PIS ------------------------*/

			$checkEmployee = array();

			if ($employee->employee_id == "" ) {

		    	$checkEmployee = $employees->search(array('employee_fname' => $employees->employee_fname,
													      'employee_mname' => $employees->employee_mname, 
													      'employee_lname' => $employees->employee_lname,
													      'employee_bday'  => $employees->employee_bday
												    ));

		    	if (!$checkEmployee) {
					$employees->sqlQueries['new'] = 1;
		    	}

				$employees->employee_id = $this->input->post('employee_id');
			}

			if(count($checkEmployee) > 0 ){
				$empFound = reset($checkEmployee);
				$employmentStatus = $employment->search(array('employee_id' => $empFound->employee_id));
				$empStat = reset($employmentStatus);

				if(strtolower($empStat->employment_status) == strtolower("resign")){
					$employment->load($empStat->employment_id);
					$employment->employment_status 	= "active";
					$employment->save();
					$data['successMsg'] 			= "Employee Information Updated!";
					$ret['view'] 					= $this->load->view('shared/success',$data,TRUE);
					$ret['success'] 				= true;
				}else{
					$data['errorMsg'] 	= "Data Redundancy Detected";
					$ret['view'] 		= $this->load->view('shared/error',$data,TRUE); 
					$ret['success'] 	= false;
				}

			}
			else{
					$ret['posted'] = $_POST;
			    	$employees->save();
			    	$employment = $employment->pop(['employee_id' => $employees->employee_id ]);
			    	// $has_emp_rec = $employment->search(array('employee_id' => $employees->employee_id));
			    	// if ($has_emp_rec) {
			    	// 	$empRec = reset($has_emp_rec);
				    // 	$employment->load($empRec->employment_id);
			    	// }
			    	// else {
				    // 	$employment->employee_id = $employees->employee_id;
				    // 	$employment->employment_status = "active";
			    	// }
			    	$employment->employment_status 		= "active";
			    	$employment->employee_id  			= $employees->employee_id;	
			    	$employment->employment_rate 		= $this->input->post('employment_rate');
			    	$employment->department_id 			= $this->input->post('department_id');
			    	$employment->employment_job_title 	= $this->input->post("employment_job_title");
			    	$employment->employment_hired_date 	= $this->input->post("employment_hired_date");;
			    	$employment->employment_type 		= $this->input->post('employment_type');
			  		$employment->save();

			  		
			  		$emp_record->employment_id = $employment->employment_id;
			  		$emp_record->emp_rec_type = $this->input->post("emp_rec_type");
			  		$emp_record->emp_rec_date = $this->input->post("emp_rec_date");
			  		$emp_record->save();

			  		$data['successMsg'] = "<br>Employee Information Saved!";
					$ret['view'] = $this->load->view('shared/success',$data,TRUE);
					$ret['success'] = true;
			}
	  		$this->do_upload($employees->employee_id);
			echo json_encode($ret);
		}
		
		public function do_upload($emp_id){
			$config['upload_path'] = 'images/users/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = $emp_id;    	 	
			$this->load->library('upload', $config);
			// $this->upload->initialize($config);
			$this->upload->do_upload();
		}
	}
?>
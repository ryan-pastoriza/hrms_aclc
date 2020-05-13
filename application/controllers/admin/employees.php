<?php
/**
 * @Author: khrey
 * @Date:   2015-08-14 09:23:37
 * @Last Modified by:   Gian
 * @Last Modified time: 2019-07-31 13:47:57
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends MY_Controller {

	public function index()
	{
		$this->load->model('employee');
		$this->load->model('department');
		$this->load->model('employee_requirement');
		
		$emps = new Employee;
		$depts = new Department;

		$data = array('emps' => $emps->get_all(),
					  'departments' => $depts->search(array('department_status' => "active")),
					  'requirement' => $this->disp_emp_requirement(),
					  'empID' => 'none',
					  'inactiveEmps' => $emps->get_all('inactive'),
					  'activeEmps' => $emps->get_all('active'),
					  );

		$er = new Employee_Requirement;
		$data['requirements'] = $er->get();
		$data['hasReq'] 	= [];

		$mainPage = $this->load->view('admin/PIS/employees/main_page',$data,TRUE);
		$this->create_head_and_navi(array(
											asset_url("plugins/datatables/jquery.dataTables.min.js"),
											asset_url("plugins/iCheck/icheck.min.js"),
											asset_url("plugins/daterangepicker/moment.js"),
											asset_url('plugins/jquery.form.min.js'),
											asset_url('plugins/lightbox/js/ekko-lightbox.min.js'),
											asset_url('plugins/jquery.printThis.js'),
											asset_url("plugins/daterangepicker/daterangepicker.js"),
											asset_url("plugins/bootstrap-switch/js/bootstrap-switch.min.js"),

										 ),
									array(
											asset_url("plugins/datatables/dataTables.bootstrap.css"),
											asset_url("plugins/iCheck/all.css"),
											asset_url("font-awesome/4.2.0/css/font-awesome.min.css"),
											asset_url("bootstrap/css/build.css"),
											// asset_url("plugins/daterangepicker/daterangepicker-bs3.css"),
											asset_url('plugins/lightbox/css/ekko-lightbox.min.css'),
											asset_url("plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css"),
										 )
									);
		
		create_content(array('contentHeader' => 'Employees\' Record',
							 'breadCrumbs' 	 => true,
							 'content'		 => array($mainPage)	
					  		)
					   );

		$this->create_footer(array(
								$this->load->view('admin/PIS/new/jscripts',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/employees_table/jscripts',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/201/emp_app_form/jscript',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/201/employment_checklist/jscripts',FALSE,TRUE),
								$this->load->view('admin/PIS/employees/201/staff_info_sheet/jscripts',FALSE,TRUE)
							));
	}
	public function ppst() {
		$this->load->model('employee');
		$this->load->model('employment');
		$this->load->model('employment_application_form');

		$emp = new Employee;
		$employment = new Employment;
		$eaf = new Employment_Application_Form;

		$emp->load_with_employment_info($this->input->post("emp_id"));
		// $emp->load_with_employment_info(1);
		$eaf->load($emp->employee_id);
		$data = [];
		$ret = [];

		$data["sss_no"] = $emp->sss_no != "" ? $emp->sss_no : $eaf->eaf_SSS;
		$data["philhealth_no"] = $emp->philhealth_no != "" ? $emp->philhealth_no : $eaf->eaf_philhealth;
		$data["tin_no"] = $emp->tin_no != "" ? $emp->tin_no : $eaf->eaf_TIN;
		$data["pagibig_no"] = $emp->pagibig_no != "" ? $emp->pagibig_no : $eaf->eaf_pagibig;

		// echo "<pre>";
		echo json_encode($data);
	}
	public function company_info(){
		
		$emp_id = $this->input->post("emp_id");
		// $emp_id = "BTN-2014-0271";
		$this->load->model("employee");
		$emp = new Employee;
		$emp->toJoin = ["employment_application_form" => "employee",
						"employment" => "employee",
						"department" => "employment",
						];
		$search = $emp->search(["employees.employee_id" => $emp_id]);
		$ret = reset($search);

		$this->load->model('department_head');
		$dh = new Department_Head;
		$dh->toJoin = ["employee" => "department_head"];
		$dh_search = $dh->search(["department_id" => $ret->department_id]);
		$dh_ret = reset($dh_search);
		if(empty($dh_ret)){
			$data = ["sss_no" 			=> $ret->sss_no != "" ? $ret->sss_no:"",
				 "phic_no" 				=> $ret->philhealth_no != "" ? $ret->philhealth_no : "",
				 "tin_no" 				=> $ret->tin_no != "" ? $ret->tin_no : "",
				 "pagibig_no" 			=> $ret->pagibig_no != ""  ? $ret->pagibig_no : "" ,
				 "immediate_sup"		=> "",
				 "company" 				=> $ret->companys != "" ? $ret->companys: "BITSI",
				 "date_hired" 			=> $ret->employment_hired_date,
				 "emp_status" 			=> $ret->employment_type,
				 "position" 			=> $ret->employment_job_title,
				 "section_program" 		=> $ret->section_programs,
				 "department" 			=> $ret->department_name,
				 "division" 			=> $ret->divisions,
				];
		}else{
			$data = ["sss_no" 			=> $ret->sss_no != "" ? $ret->sss_no:"",
				 "phic_no" 				=> $ret->philhealth_no != "" ? $ret->philhealth_no : "",
				 "tin_no" 				=> $ret->tin_no != "" ? $ret->tin_no : "",
				 "pagibig_no" 			=> $ret->pagibig_no != ""  ? $ret->pagibig_no : "" ,
				 "immediate_sup" 		=> ucwords($dh_ret->employee_fname ." ". $dh_ret->employee_mname[0] .". ".$dh_ret->employee_lname),
				 "company" 				=> $ret->companys != "" ? $ret->companys: "BITSI",
				 "date_hired" 			=> $ret->employment_hired_date,
				 "emp_status" 			=> $ret->employment_type,
				 "position" 			=> $ret->employment_job_title,
				 "section_program" 		=> $ret->section_programs,
				 "department" 			=> $ret->department_name,
				 "division" 			=> $ret->divisions,
				];
		}

		
		echo json_encode($data);
	}
	public function view_info()
	{
		/*-------------- LOADING EAF MODELS -------------------*/
		$this->load->model('emp_app_form_spouse');
		$this->load->model('emp_app_form_children');
		$this->load->model('emp_app_form_relatives');
		$this->load->model('emp_app_form_education');
		$this->load->model('emp_app_form_employment_records');
		$this->load->model('emp_app_form_teaching_pos');
		$this->load->model('emp_app_form_emprec_at_comp');
		$this->load->model('emp_app_form_trainings');
		$this->load->model('emp_app_form_orgs');
		$this->load->model('emp_app_form_references');
		$this->load->model('employment_application_form');

		/*-------------- END OF LOADING EAF MODELS -------------------*/

		/*------------- INSTANTIATING EAF MODELS ---------------*/
		$spouse 		= new Emp_app_form_spouse;
		$children 		= new Emp_app_form_children;
		$relative 		= new Emp_app_form_relatives;
		$education 		= new Emp_app_form_education;
		$employment_rec = new Emp_app_form_employment_records;
		$teaching 		= new Emp_app_form_teaching_pos;
		$emprec 		= new Emp_app_form_emprec_at_comp;
		$training 		= new Emp_app_form_trainings;
		$orgs 			= new Emp_app_form_orgs;
		$references		= new Emp_app_form_references;
		$emps 			= new Employee;
		$eaf 			= new Employment_application_form;
		/*------------- END OF INSTANTIATING EAF MODELS ---------------*/



		$emps = new Employee;
		$emps->toJoin = array('employment' => 'employee' , 
						'department' => 'employment');

		$emps->load($this->input->post('emp_id'));

		/*------------- FETCHING EAF INFORMATION --------------*/
		$eafs = $eaf->pop(array('employee_id' => $emps->employee_id));
		$emps = (object)array_merge((array)$eafs, (array)$emps);

		if (isset($emps->eaf_id)) {
			$emps->spouse 			= $spouse->search(array('eaf_id' => $emps->eaf_id));
			$emps->children 		= $children->search(array('eaf_id' => $emps->eaf_id));
			$emps->relative 		= $relative->search(array('eaf_id' => $emps->eaf_id));
			$emps->education 		= $education->search(array('eaf_id' => $emps->eaf_id));
			$emps->employment_rec 	= $employment_rec->search(array('eaf_id' => $emps->eaf_id));
			$emps->teaching 		= $teaching->search(array('eaf_id' => $emps->eaf_id));
			$emps->emprec 			= $emprec->search(array('eaf_id' => $emps->eaf_id));
			$emps->training 		= $training->search(array('eaf_id' => $emps->eaf_id));
			$emps->orgs 			= $orgs->search(array('eaf_id' => $emps->eaf_id));
			$emps->references 		= $references->search(array('eaf_id' => $emps->eaf_id));
		}
		/*------------- FETCHING EAF INFORMATION --------------*/

		echo json_encode($emps);
	}
	public function employees_list()
	{
		$this->load->model('employee');
		$emps = new Employee;
		$emps = $emps->get_all();

		$tableData = $this->get_table_data($emps);

		echo json_encode($tableData);
	}
	private function get_table_data($employees)
	{
		$tableData = array();
		foreach ($employees as $key => $value) {
			$fullname = $value->fullName('l f, m.');
			$status = $value->employment_status == "active" ? "<span class=\"label label-success\">ACTIVE</span>" : "<span class=\"label label-danger\">INACTIVE</span>";
			$tableData['data'][] = array("<a href='#' class='openEmpFileBtn' emp_id='".$value->employee_id."'>" . $fullname . "</a>",
										 $value->employment_job_title,
										 $value->department_name,
										 $status,
										 "<a href=\"#\" data-toggle=\"tooltip\" title=\"View Information\" class=\"openEmpFileBtn\" emp_id=\"$value->employee_id\" id=\"$value->employee_id\" ><i class=\"fa fa-folder-open-o\" ></i></a>");
		}
		return $tableData;
	}
	public function save_employment_application_form(){
		$this->load->model('employment_application_form');
		$this->load->model('emp_app_form_spouse');
		$this->load->model('emp_app_form_children');
		$this->load->model('emp_app_form_relatives');
		$this->load->model('emp_app_form_employment_records');
		$this->load->model('emp_app_form_education');
		$this->load->model('emp_app_form_teaching_pos');
		$this->load->model('emp_app_form_emprec_at_comp');
		$this->load->model('emp_app_form_trainings');
		$this->load->model('emp_app_form_orgs');
		$this->load->model('emp_app_form_references');

		$eaf = new Employment_application_form();

		$record_exist = $eaf->pop(array('employee_id' => $this->input->post('employee_id'), ));

		if($record_exist){
			$eaf = $record_exist;
		}

		$eaf->employee_id 			 = $this->input->post('employee_id');
		$eaf->eaf_position_applied 	 = $this->input->post('eaf_position_applied');
		$eaf->eaf_employment_desired = $this->input->post('eaf_employment_desired');
		$eaf->eaf_fname 		= $this->input->post('eaf_fname');
		$eaf->eaf_mname 		= $this->input->post('eaf_mname');
		$eaf->eaf_lname 		= $this->input->post('eaf_lname');
		$eaf->eaf_nickname  	= $this->input->post('eaf_nickname');
		$eaf->eaf_gender 		= $this->input->post('eaf_gender');
		$eaf->eaf_height 		= $this->input->post('eaf_height');
		$eaf->eaf_weight 		= $this->input->post('eaf_weight');
		$eaf->eaf_birthdate		= $this->input->post('eaf_birthdate');
		$eaf->eaf_birthplace 	= $this->input->post('eaf_birthplace');
		$eaf->eaf_civil_status  = $this->input->post('eaf_civil_status');
		$eaf->eaf_marriage_date = $this->input->post('eaf_marriage_date');
		$eaf->eaf_pre_addr 		= $this->input->post('eaf_pre_addr');
		$eaf->eaf_pal_num 	 	= $this->input->post('eaf_pal_num');
		$eaf->eaf_pam_num 	 	= $this->input->post('eaf_pam_num');
		$eaf->eaf_peram_addr 	= $this->input->post('eaf_peram_addr');
		$eaf->eaf_peral_num  	= $this->input->post('eaf_peral_num');
		$eaf->eaf_peram_num  	= $this->input->post('eaf_peram_num');
		$eaf->eaf_blood_type 	= $this->input->post('eaf_blood_type');
		$eaf->eaf_citizenship 	= $this->input->post('eaf_citizenship');
		$eaf->eaf_religion   	= $this->input->post('eaf_religion');
		$eaf->eaf_TIN 			= $this->input->post('eaf_TIN');
		$eaf->eaf_SSS 			= $this->input->post('eaf_SSS');
		$eaf->eaf_philhealth 	= $this->input->post('eaf_philhealth');
		$eaf->eaf_pagibig 	 	= $this->input->post('eaf_pagibig');

		$eaf->eaf_father_name 	= $this->input->post('eaf_father_name');
		$eaf->eaf_mother_name 	= $this->input->post('eaf_mother_name');


		$eaf->eaf_contact_person	 = $this->input->post('eaf_contact_person');
		$eaf->eaf_cp_address		 = $this->input->post('eaf_cp_address');
		$eaf->eaf_cp_num			 = $this->input->post('eaf_cp_num');
		$eaf->eaf_cp_relationship	 = $this->input->post('eaf_cp_relationship');
		$eaf->eaf_prev_hosp			 = $this->input->post('eaf_prev_hosp');
		$eaf->eaf_ph_in				 = $this->input->post('eaf_ph_in');
		$eaf->eaf_prev_operation	 = $this->input->post('eaf_prev_operation');
		$eaf->eaf_po_in 			 = $this->input->post('eaf_po_in');
		$eaf->eaf_cut 				 = $this->input->post('eaf_cut');
		$eaf->eaf_cut_explain		 = $this->input->post('eaf_cut');
		$eaf->eaf_crime 			 = $this->input->post('eaf_crime');
		$eaf->eaf_crime_explain		 = $this->input->post('eaf_crime_explain');
		$eaf->eaf_misconduct 		 = $this->input->post('eaf_misconduct');
		$eaf->eaf_misconduct_explain = $this->input->post('eaf_misconduct_explain');
		$eaf->eaf_criminal 			 = $this->input->post('eaf_criminal');
		$eaf->eaf_criminal_explain 	 = $this->input->post('eaf_criminal_explain');

		$eaf->eaf_mthesis_title		 = $this->input->post('eaf_mthesis_title');
		$eaf->eaf_mthesis_date		 = $this->input->post('eaf_mthesis_date');
		$eaf->eaf_dd_title			 = $this->input->post('eaf_dd_title');
		$eaf->eaf_dd_date			 = $this->input->post('eaf_dd_date');
		$eaf->eaf_pl_title			 = $this->input->post('eaf_pl_title');
		$eaf->eaf_pl_date			 = $this->input->post('eaf_pl_date');
		$eaf->eaf_ss_title  		 = $this->input->post('eaf_ss_title');
		// $eaf->eaf_ss_date 			 = $this->input->post('eaf_ss_date');

		$eaf->save();	

		/*------------ SAVING OF EAF MULTIPLE VALUE TABLES ----------------*/

		//  Spouse
		if($this->input->post('eaf_spouse_name')){
			foreach ($this->input->post('eaf_spouse_name') as $key => $value) {
				$spouse = new Emp_app_form_spouse;

				$spouse_record_exist = $spouse->pop(array('eaf_spouse_name' => $value,
														'eaf_spouse_dob' => $this->input->post('eaf_spouse_dob')[$key],
														'eaf_id' => $eaf->eaf_id));

				if($spouse_record_exist){
					$spouse = $spouse_record_exist;
				}
				if($value != ""){
					$spouse->eaf_id = $eaf->eaf_id;
					$spouse->eaf_spouse_name = $value;
					$spouse->eaf_spouse_dob = $this->input->post('eaf_spouse_dob')[$key];
					$spouse->eaf_spouse_occupation = $this->input->post('eaf_spouse_occupation')[$key];
					$spouse->eaf_spouse_contact_num = $this->input->post('eaf_spouse_contact_num')[$key];
					$spouse->save();
				}
			}
		}
		
		// Children
		if($this->input->post('eaf_child_name')){
			foreach ($this->input->post('eaf_child_name') as $key => $value) {
				$children = new Emp_app_form_children;

				$children_record_exist = $children->pop(array('eaf_child_name' => $value,
														'eaf_child_dob' => $this->input->post('eaf_child_dob')[$key],
														'eaf_id' => $eaf->eaf_id));
				if($children_record_exist){
					$children = $children_record_exist;
				}
				if($value != ""){
					$children->eaf_id = $eaf->eaf_id;
					$children->eaf_child_name = $value;
					$children->eaf_child_dob = date("Y-m-d", strtotime($this->input->post('eaf_child_dob')[$key]));

					$children->save();
				}
			}
		}

		//  Relative
		if($this->input->post('eaf_relative_name')){
			foreach ($this->input->post('eaf_relative_name') as $key => $value) {
				$relative = new Emp_app_form_relatives;
				$relative_record_exist = $relative->pop(array('eaf_relative_name' => $value,
														'eaf_relative_relationship' => $this->input->post('eaf_relative_relationship')[$key],
														'eaf_id' => $eaf->eaf_id));	
														
				if($relative_record_exist){
					$relative = $relative_record_exist;
				}	
				if($value != ""){
					$relative->eaf_id = $eaf->eaf_id;
					$relative->eaf_relative_name = $value;
					$relative->eaf_relative_relationship = $this->input->post('eaf_relative_relationship')[$key];
					$relative->eaf_relative_position = $this->input->post('eaf_relative_position')[$key];
					$relative->save();
				}
			}
		}

		// Education
		if($this->input->post('eaf_educ_school_name')){
			foreach ($this->input->post('eaf_educ_school_name') as $key => $value) {
				$education = new Emp_app_form_education;

				$education_record_exist = $education->pop(array('eaf_educ_school_name' => $value,
														'eaf_educ_school_type' => $this->input->post('eaf_educ_school_type')[$key],
														'eaf_id' => $eaf->eaf_id));
				if($education_record_exist){
					$education = $education_record_exist;
				}	
				if($value != ""){
					$education->eaf_id = $eaf->eaf_id;
					$education->eaf_educ_school_name = $value;
					$education->eaf_educ_school_type = $this->input->post('eaf_educ_school_type')[$key];
					$education->eaf_educ_degree = $this->input->post('eaf_educ_degree')[$key];
					$education->eaf_educ_from = $this->input->post('eaf_educ_from')[$key];
					$education->eaf_educ_to = $this->input->post('eaf_educ_to')[$key];
					$education->eaf_educ_honors = $this->input->post('eaf_educ_honors')[$key];
					$education->save();
				}
			}
		}

		// Employment Records
		if($this->input->post('eaf_er_comp_name')){
			foreach ($this->input->post('eaf_er_comp_name') as $key => $value) {
				$company = new Emp_app_form_employment_records;

				$company_record_exist = $company->pop(array('eaf_er_comp_name' => $value,
														'eaf_id' => $eaf->eaf_id));

				if($company_record_exist){
					$company = $company_record_exist;
				}
				if($value != ""){
					$company->eaf_id = $eaf->eaf_id;
					$company->eaf_er_comp_name = $value;
					$company->eaf_er_superior  = $this->input->post('eaf_er_superior')[$key];
					$company->eaf_er_date_from = $this->input->post('eaf_er_date_from')[$key];
					$company->eaf_er_date_to = $this->input->post('eaf_er_date_to')[$key];
					$company->eaf_er_comp_address = $this->input->post('eaf_er_comp_address')[$key];
					$company->eaf_er_comp_num = $this->input->post('eaf_er_comp_num')[$key];
					$company->eaf_er_superior_num = $this->input->post('eaf_er_superior_num')[$key];
					$company->eaf_er_salary_start = $this->input->post('eaf_er_salary_start')[$key];
					$company->eaf_er_salary_final = $this->input->post('eaf_er_salary_final')[$key];
					$company->eaf_er_position = $this->input->post('eaf_er_position')[$key];
					$company->eaf_er_rfl = $this->input->post('eaf_er_rfl')[$key];
					$company->eaf_er_duties = $this->input->post('eaf_er_duties')[$key];

					$company->save();
				}
			}
		}
	
		// Teaching
		if($this->input->post('eaf_tp_school')){
			foreach ($this->input->post('eaf_tp_school') as $key => $value) {
				$teaching = new Emp_app_form_teaching_pos;

				$teaching_record_exist = $teaching->pop(array('eaf_tp_school' => $value,
														'eaf_id' => $eaf->eaf_id));
				if($teaching_record_exist){
					$teaching = $teaching_record_exist;
				}
				if($value != ""){
					$teaching->eaf_id = $eaf->eaf_id;
					$teaching->eaf_tp_school = $value;

					$date_from = $this->input->post('eaf_tp_date_from')[$key];
					$date_to =  $this->input->post('eaf_tp_date_to')[$key];

					$new_date_from = date("Y-m-d", strtotime($date_from));
					$new_date_to   = date("Y-m-d", strtotime($date_to));

					$teaching->eaf_tp_date_from = $new_date_from;
					$teaching->eaf_tp_date_to   = $new_date_to;

					$teaching->eaf_tp_subject = $this->input->post('eaf_tp_subject')[$key];
					$teaching->eaf_tp_superior_cont = $this->input->post('eaf_tp_superior_cont')[$key];
					$teaching->eaf_tp_salary = $this->input->post('eaf_tp_salary')[$key];
					$teaching->eaf_tp_rfl	 = $this->input->post('eaf_tp_rfl')[$key];
					$teaching->save();
				}
			}
		}

		// Employment in ACLC
		if($this->input->post('eaf_prev_position')){
			foreach ($this->input->post('eaf_prev_position') as $key => $value) {
				$erc = new Emp_app_form_emprec_at_comp;

				$erc_record_exist = $erc->pop(array('eaf_prev_position' => $value,
														'eaf_erc_superior_cont' => $this->input->post('eaf_erc_superior_cont')[$key],
														'eaf_id' => $eaf->eaf_id));
				if($erc_record_exist){
					$erc = $erc_record_exist;
				}
				if($value != ""){
					$erc->eaf_id = $eaf->eaf_id;
					$erc->eaf_prev_position = $value;
					$erc->eaf_erc_date_from = date("Y-m-d", strtotime($this->input->post('eaf_erc_date_from')[$key]));
					$erc->eaf_erc_date_to = date("Y-m-d", strtotime($this->input->post('eaf_erc_date_to')[$key]));
					$erc->eaf_erc_superior_cont = $this->input->post('eaf_erc_superior_cont')[$key];
					$erc->eaf_erc_salary = $this->input->post('eaf_erc_salary')[$key];
					$erc->eaf_erc_rfl = $this->input->post('eaf_erc_rfl')[$key];
					$erc->save();
				}
			}
		}

		// Trainings and Seminars
		if($this->input->post('eaf_tas_title')){
			foreach ($this->input->post('eaf_tas_title') as $key => $value) {
				$trainings = new Emp_app_form_trainings;

				$trainings_record_exist = $trainings->pop(array('eaf_tas_title' => $value,
														'eaf_id' => $eaf->eaf_id));
				if($trainings_record_exist){
					$trainings = $trainings_record_exist;
				}
				if($value != ""){
					$trainings->eaf_id = $eaf->eaf_id;
					$trainings->eaf_tas_title=$value;
					$trainings->eaf_tas_name_loc = $this->input->post('eaf_tas_name_loc')[$key];
					$trainings->eaf_tas_date_from = date("Y-m-d", strtotime($this->input->post('eaf_tas_date_from')[$key]));
					$trainings->eaf_tas_date_to = date("Y-m-d", strtotime($this->input->post('eaf_tas_date_to')[$key]));
					$trainings->save();
				}
			}
		}

		// Organization
		if($this->input->post('eaf_org_name')){
			foreach ($this->input->post('eaf_org_name') as $key => $value) {
				$org = new Emp_app_form_orgs;

				$org_record_exist = $org->pop(array('eaf_org_name' => $value,
														'eaf_id' => $eaf->eaf_id));
				if($org_record_exist){
					$org = $org_record_exist;
				}
				if($value != ""){
					$org->eaf_id = $eaf->eaf_id;
					$org->eaf_org_name = $this->input->post('eaf_org_name')[$key];
					$org->eaf_org_position = $this->input->post('eaf_org_position')[$key];
					$org->eaf_org_date_from = date("Y-m-d", strtotime($this->input->post('eaf_org_date_from')[$key]));
					$org->eaf_org_date_to = date("Y-m-d", strtotime($this->input->post('eaf_org_date_to')[$key]));
					$org->save();
				}
			}
		}

		// Reference
		if($this->input->post('eaf_ref_name')){
			foreach ($this->input->post('eaf_ref_name') as $key => $value) {
				$references = new Emp_app_form_references;

				$references_record_exist = $references->pop(array('eaf_ref_name' => $value,
														'eaf_id' => $eaf->eaf_id));
				if($references_record_exist){
					$references = $references_record_exist;
				}
				if($value != ""){
					$references->eaf_id = $eaf->eaf_id;
					$references->eaf_ref_name = $value;
					$references->eaf_ref_comp_name = $this->input->post('eaf_ref_comp_name')[$key];
					$references->eaf_ref_position = $this->input->post('eaf_ref_position')[$key];
					$references->eaf_ref_contact = $this->input->post('eaf_ref_contact')[$key];
					$references->save();
				}
			}
		}

		/*------------ END OF SAVING OF EAF MULTIPLE VALUE TABLES ----------------*/

	}
	public function disp_emp_requirement(){
		$this->load->model("employee_requirement");
		$er = new employee_requirement;
		$requirement = $er->get();
		return $requirement;
	}

	/*------------- EAF DELETE METHODS -----------*/
	public function delete_spouse() {
			$this->load->model('emp_app_form_spouse');
			$tbl = new Emp_app_form_spouse;
			$tbl->load($this->input->post('id'));
			$tbl->delete();
	}
	public function delete_children() {
		$this->load->model('emp_app_form_children');
		$tbl = new Emp_app_form_children;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_relative() {
		$this->load->model('emp_app_form_relatives');
		$tbl = new Emp_app_form_relatives;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_education() {
		$this->load->model('emp_app_form_education');
		$tbl = new Emp_app_form_education;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_employment() {
		$this->load->model('emp_app_form_employment_records');
		$tbl = new Emp_app_form_employment_records;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_teaching() {
		$this->load->model('emp_app_form_teaching_pos');
		$tbl = new Emp_app_form_teaching_pos;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_emprec() {
		$this->load->model('emp_app_form_emprec_at_comp');
		$tbl = new Emp_app_form_emprec_at_comp;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_training() {
		$this->load->model('emp_app_form_trainings');
		$tbl = new Emp_app_form_trainings;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_orgs() {
		$this->load->model('emp_app_form_orgs');
		$tbl = new Emp_app_form_orgs;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}
	public function delete_references() {
		$this->load->model('emp_app_form_references');
		$tbl = new Emp_app_form_references;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	/*------------- END OF EAF DELETE METHODS -----------*/

	/*-------------- EAF SPOUSE UPDATE METHODS -----------------*/
	public function update_spouse() {
		$this->load->model('emp_app_form_spouse');
		$tbl = new Emp_app_form_spouse;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_children() {
		$this->load->model('emp_app_form_children');
		$tbl = new Emp_app_form_children;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_relative() {
		$this->load->model('emp_app_form_relatives');
		$tbl = new Emp_app_form_relatives;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_education() {
		$this->load->model('emp_app_form_education');
		$tbl = new Emp_app_form_education;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_employment() {
		$this->load->model('emp_app_form_employment_records');
		$tbl = new Emp_app_form_employment_records;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_teaching() {
		$this->load->model('emp_app_form_teaching_pos');
		$tbl = new Emp_app_form_teaching_pos;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_emprec() {
		$this->load->model('emp_app_form_emprec_at_comp');
		$tbl = new Emp_app_form_emprec_at_comp;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_training() {
		$this->load->model('emp_app_form_trainings');
		$tbl = new Emp_app_form_trainings;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_orgs() {
		$this->load->model('emp_app_form_orgs');
		$tbl = new Emp_app_form_orgs;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	public function update_references() {
		$this->load->model('emp_app_form_references');
		$tbl = new Emp_app_form_references;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	/*-------------- END OF EAF SPOUSE UPDATE METHODS -----------------*/
	public function employee_application_sheet()
	{
		if ($this->input->get('employee_id')) {
			$this->load->model('employee');
			$emp = new Employee;
			$emp->load($this->input->get('employee_id'));

		}
		echo "
				<style>
					a,button{
						display:none;
					}
					input,select{
						border:none;
					}
				</style>

				<script src='".asset_url('plugins/jQuery/jQuery-1.11.3.min.js')."' type='text/javascript'></script>
				<script>
					$(function(){
						window.print();
						$(document).print();
					})
				</script>
				";
		$data = array('empInfo' => $emp, );
		$this->load->view('admin/PIS/employees/201/emp_app_form/employment_app_form',$data);
	}
	//@Author: ARIEL
	public function save_staff_info_sheet() {
		if($this->input->post('employee_id') !== '' && $this->input->post('employee_fname') && $this->input->post('employee_lname')) {
			$this->load->model('employee');
			$emp = new Employee;
			$emp->load($this->input->post('employee_id'));
			$emp->employee_fname 					= $this->input->post('employee_fname');
			$emp->employee_mname 					= $this->input->post('employee_mname');
			$emp->employee_lname 					= $this->input->post('employee_lname');
			$emp->employee_blood_type 				= $this->input->post('employee_blood_type');
			$emp->employee_status 					= $this->input->post('employee_status');
			$emp->employee_bday 					= $this->input->post('employee_bday');
			$emp->employee_gender 					= $this->input->post('employee_gender');
			$emp->employee_father 					= $this->input->post('employee_father');
			$emp->employee_mother 					= $this->input->post('employee_mother');
			$emp->employee_telephone 				= $this->input->post('employee_telephone');
			$emp->employee_mobile 					= $this->input->post('employee_mobile');
			$emp->employee_religion 				= $this->input->post('employee_religion');
			$emp->employee_current_address 			= $this->input->post('employee_current_address');
			$emp->employee_permanent_address 		= $this->input->post('employee_permanent_address');
			$emp->employee_contact_person_name 		= $this->input->post('employee_contact_person_name');
			$emp->employee_contact_person_address 	= $this->input->post('employee_contact_person_address');
			$emp->employee_contact_person_telephone = $this->input->post('employee_contact_person_telephone');
			$emp->employee_contact_person_mobile = $this->input->post('employee_contact_person_mobile');
			$emp->save();

			//july 31, 2019 - gian
			$this->load->model('employment');
			$employment_ = new Employment;
			$search_employment_id = $employment_->search(["employee_id" => $this->input->post("employee_id")]);
			$result_search = reset($search_employment_id);

			$employment_->load($result_search->employment_id);
			$employment_->companys 				= $this->input->post("company_name");
			$employment_->employment_job_title 	= $this->input->post("position");
			$employment_->section_programs 		= $this->input->post("section_program");
			$employment_->divisions 			= $this->input->post("division");
			$employment_->philhealth_no		 	= $this->input->post("philhealth_no");
			$employment_->sss_no 				= $this->input->post("sss_no");
			$employment_->tin_no 				= $this->input->post("tin_no");
			$employment_->pagibig_no 			= $this->input->post("pagibig_no");
			$employment_->save();
			//end july 31, 2019 -gian



			//gian author
				$emp->load_with_employment_info($this->input->post('employee_id'));
				$employment = new Employment;
				$employment->load($emp->employment_id);
				$employment->sss_no 		= $this->input->post('sss_no');
				$employment->pagibig_no 	= $this->input->post('pagibig_no');
				$employment->tin_no 		= $this->input->post('tin_no');
				$employment->philhealth_no 	= $this->input->post('philhealth_no');
				$employment->save();
			//end gian author

			foreach ($this->input->post('spouse_name') as $key => $value) {
				$this->load->model('employee_spouse');
				$emp_spouse = new Employee_Spouse;
				if($value !== '') {
					$emp_spouse->employee_id = $this->input->post('employee_id');
					$emp_spouse->spouse_name = $value;
					$emp_spouse->spouse_birth_date = $this->input->post('spouse_birth_date')[$key];
					$emp_spouse->spouse_date_of_marriage = $this->input->post('spouse_date_of_marriage')[$key];
					$emp_spouse->spouse_occupation = $this->input->post('spouse_occupation')[$key];
					$emp_spouse->spouse_employer = $this->input->post('spouse_employer')[$key];
					$emp_spouse->spouse_employer_address = $this->input->post('spouse_employer_address')[$key];
					$emp_spouse->save();
				}
			}

			foreach ($this->input->post('emp_dependent_name') as $key => $value) {
				$this->load->model('employee_dependent');
				$emp_dep = new Employee_Dependent;
				if($value !== '') {
					$dep = 0;
					$emp_dep->employee_id = $this->input->post('employee_id');
					$emp_dep->emp_dependent_name = $value;
					$emp_dep->emp_dependent_birthdate = $this->input->post('emp_dependent_birthdate')[$key];
					$emp_dep->emp_dependent_relationship = $this->input->post('emp_dependent_relationship')[$key];
					if($this->input->post('emp_dependent_dependency')[$key] === 'true') {
						$dep = 1;
					}
					$emp_dep->emp_dependent_dependency = $dep;
					$emp_dep->save();
				}
			}

			foreach ($this->input->post('ee_school_name') as $key => $value) {
				$this->load->model('employee_education');
				$emp_ed = new Employee_Education;
				if($value !== '' && $this->input->post('ee_attainment')[$key]) {
					$emp_ed->employee_id = $this->input->post('employee_id');
					$emp_ed->ee_school_name = $value;
					$emp_ed->ee_attainment = $this->input->post('ee_attainment')[$key];
					$emp_ed->ee_course_taken = $this->input->post('ee_course_taken')[$key];
					$emp_ed->ee_units_earned = $this->input->post('ee_units_earned')[$key];
					$emp_ed->ee_ongoing_units = $this->input->post('ee_ongoing_units')[$key];
					$emp_ed->ee_year_graduated = $this->input->post('ee_year_graduated')[$key];
					$emp_ed->save();
				}
			}

			foreach ($this->input->post('emp_el_program') as $key => $value) {
				$this->load->model('employee_eligibility');
				$emp_el = new Employee_Eligibility;
				if($value !== '') {
					$emp_el->employee_id = $this->input->post('employee_id');
					$emp_el->emp_el_program = $value;
					$emp_el->emp_el_certificate_level = $this->input->post('emp_el_certificate_level')[$key];
					$emp_el->emp_el_status = $this->input->post('emp_el_status')[$key];
					$emp_el->emp_el_certificate_exp = $this->input->post('emp_el_certificate_exp')[$key];
					$emp_el->save();
				}
			}

			foreach ($this->input->post('emp_aff_org_name') as $key => $value) {
				$this->load->model('employee_affilation');
				$emp_aff = new Employee_Affilation;
				if($value !== '') {
					$emp_aff->employee_id = $this->input->post('employee_id');
					$emp_aff->emp_aff_org_name = $value;
					$emp_aff->emp_aff_membership_type = $this->input->post('emp_aff_membership_type')[$key];
					$emp_aff->emp_aff_status = $this->input->post('emp_aff_status')[$key];
					$emp_aff->emp_aff_membership_exp = $this->input->post('emp_aff_membership_exp')[$key];
					$emp_aff->save();
				}
			}

			foreach ($this->input->post('ets_title') as $key => $value) {
				$this->load->model('employee_training_seminar');
				$ets = new Employee_Training_Seminar;
				if($value !== '') {
					$ets->employee_id = $this->input->post('employee_id');
					$ets->ets_title = $value;
					$ets->ets_date = $this->input->post('ets_date')[$key];
					$ets->ets_venue = $this->input->post('ets_venue')[$key];
					$ets->ets_provider = $this->input->post('ets_provider')[$key];
					$ets->save();
				}
			}

		}
	}

	public function update_sis_spouse() {
		$this->load->model('employee_spouse');
		$tbl = new Employee_Spouse;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}

	public function update_dependent() {
		$this->load->model('employee_dependent');
		$tbl = new Employee_Dependent;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}

	public function update_sis_education() {
		$this->load->model('employee_education');
		$tbl = new Employee_Education;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}

	public function update_eligibility() {
		$this->load->model('employee_eligibility');
		$tbl = new Employee_Eligibility;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}

	public function update_affilation() {
		$this->load->model('employee_affilation');
		$tbl = new Employee_Affilation;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}

	public function update_training_seminar() {
		$this->load->model('employee_training_seminar');
		$tbl = new Employee_Training_Seminar;
		$tbl->load($this->input->post('pk'));
		$tbl->{$this->input->post('name')} = $this->input->post('value');
		$tbl->save();
	}
	
	public function delete_sis_spouse() {
		$this->load->model('employee_spouse');
		$tbl = new Employee_Spouse;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	public function delete_dependent() {
		$this->load->model('employee_dependent');
		$tbl = new Employee_Dependent;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	public function delete_sis_education() {
		$this->load->model('employee_education');
		$tbl = new Employee_Education;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	public function delete_eligibility() {
		$this->load->model('employee_eligibility');
		$tbl = new Employee_Eligibility;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	public function delete_affilation() {
		$this->load->model('employee_affilation');
		$tbl = new Employee_Affilation;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	public function delete_training_seminar() {
		$this->load->model('employee_training_seminar');
		$tbl = new Employee_Training_Seminar;
		$tbl->load($this->input->post('id'));
		$tbl->delete();
	}

	public function get_dep_json() {
		$this->load->model('employee_dependent');
		$tbl = new Employee_Dependent;
		$all = $tbl->search(array('employee_id' => $this->input->get('employee_id')));
		$data = array('data' => array());
		$url = '"'.base_url("index.php/admin/employees/delete_dependent").'"';
		foreach ($all as $key => $value) {
			$id = $value->emp_dependent_id;

			$age = '';
			if($value->emp_dependent_birthdate !== '0000-00-00') {
				$bday = new DateTime($value->emp_dependent_birthdate);
				$cur_date = new DateTime();
				$bday = $bday->diff($cur_date);
				$age = $bday->y;
			}
			
			$data['data'][] = array(
									"<span class='emp_dependent_name' data-pk='{$id}' data-name='emp_dependent_name' data-value='{$value->emp_dependent_name}'>".$value->emp_dependent_name."</span>",
									"<span class='emp_dependent_birthdate' data-pk='{$id}' data-name='emp_dependent_birthdate' data-value='{$value->emp_dependent_birthdate}'>".date("m/d/Y", strtotime($value->emp_dependent_birthdate))."</span>",
									"<span>".$age."</span>",
									"<span class='emp_dependent_relationship' data-pk='{$id}' data-name='emp_dependent_relationship' data-value='{$value->emp_dependent_relationship}'>".$value->emp_dependent_relationship."</span>",
									"<span class='emp_dependent_dependency' data-pk='{$id}' data-name='emp_dependent_dependency' data-value='{$value->emp_dependent_dependency}'></span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='dependent' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function get_spouse_json() {
		$this->load->model('employee_spouse');
		$tbl = new Employee_Spouse;
		$all = $tbl->search(array('employee_id' => $this->input->get('employee_id')));
		$data = array('data' => array());
		$url = '"'.base_url("index.php/admin/employees/delete_sis_spouse").'"';
		foreach ($all as $key => $value) {
			$id = $value->emp_spouse_id;
			$age = '';
			if($value->spouse_birth_date !== '0000-00-00') {
				$bday = new DateTime($value->spouse_birth_date);
				$cur_date = new DateTime();
				$bday = $bday->diff($cur_date);
				$age = $bday->y;
			}
			$data['data'][] = array(
									"<span class='spouse_name' data-pk='{$id}' data-name='spouse_name' data-value='{$value->spouse_name}'>".$value->spouse_name."</span>",
									"<span class='spouse_birth_date' data-pk='{$id}' data-name='spouse_birth_date' data-value='{$value->spouse_birth_date}'>".date("m/d/Y", strtotime($value->spouse_birth_date))."</span>",
									"<span>".$age."</span>",
									"<span class='spouse_date_of_marriage' data-pk='{$id}' data-name='spouse_date_of_marriage' data-value='{$value->spouse_date_of_marriage}'>".date("m/d/Y", strtotime($value->spouse_date_of_marriage))."</span>",
									"<span class='spouse_occupation' data-pk='{$id}' data-name='spouse_occupation' data-value='{$value->spouse_occupation}'>".$value->spouse_occupation."</span>",
									"<span class='spouse_employer' data-pk='{$id}' data-name='spouse_employer' data-value='{$value->spouse_employer}'>".$value->spouse_employer."</span>",
									"<span class='spouse_employer_address' data-pk='{$id}' data-name='spouse_employer_address' data-value='{$value->spouse_employer_address}'>".$value->spouse_employer_address."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='spouse' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function get_educ1_json() {
		$this->load->model('employee_education');
		$tbl = new Employee_Education;
		$all = $tbl->search("employee_id = '{$this->input->get('employee_id')}' AND (ee_attainment = 'Elementary' OR ee_attainment = 'High School')" );
		$data = array('data' => array());	
		$url = '"'.base_url("index.php/admin/employees/delete_sis_education").'"';
		foreach ($all as $key => $value) {
			$id = $value->ee_id;
			$data['data'][] = array(
									"<span class='ee_attainment' data-pk='{$id}' data-name='ee_attainment' data-value='{$value->ee_attainment}'>".$value->ee_attainment."</span>",
									"<span class='ee_school_name' data-pk='{$id}' data-name='ee_school_name' data-value='{$value->ee_school_name}'>".$value->ee_school_name."</span>",
									"<span class='ee_year_graduated' data-pk='{$id}' data-name='ee_year_graduated' data-value='{$value->ee_year_graduated}'>".$value->ee_year_graduated."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='educ1' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function test1(){
		$this->get_educ2_json("BTN-2016-0334 ");
	}
	public function get_educ2_json($employee_id) {
		$this->load->model('employee_education');
		$tbl = new Employee_Education;
		$all = $tbl->search("employee_id = '{$employee_id}' AND (ee_attainment = 'Undergrad' OR ee_attainment = 'Graduate' OR ee_attainment = 'Post Grad' OR ee_attainment = 'TechVoc')");
		$data = array('data' => array());	
		$url = '"'.base_url("index.php/admin/employees/delete_sis_education").'"';

		foreach ($all as $key => $value) {
			$id = $value->ee_id;
			$data['data'][] = array(
									"<span class='ee_attainment' data-pk='{$id}' data-name='ee_attainment' data-value='{$value->ee_attainment}'>".$value->ee_attainment."</span>",
									"<span class='ee_course_taken' data-pk='{$id}' data-name='ee_course_taken' data-value='{$value->ee_course_taken}'>".$value->ee_course_taken."</span>",
									"<span class='ee_school_name' data-pk='{$id}' data-name='ee_school_name' data-value='{$value->ee_school_name}'>".$value->ee_school_name."</span>",
									"<span class='ee_units_earned' data-pk='{$id}' data-name='ee_units_earned' data-value='{$value->ee_units_earned}'>".$value->ee_units_earned."</span>",
									"<span class='ee_ongoing_units' data-pk='{$id}' data-name='ee_ongoing_units' data-value='{$value->ee_ongoing_units}'>".$value->ee_ongoing_units."</span>",
									"<span class='ee_year_graduated' data-pk='{$id}' data-name='ee_year_graduated' data-value='{$value->ee_year_graduated}'>".$value->ee_year_graduated."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='educ2' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function get_eli_json() {
		$this->load->model('employee_eligibility');
		$tbl = new Employee_Eligibility;
		$all = $tbl->search(array('employee_id' => $this->input->get('employee_id')));
		$data = array('data' => array());	
		$url = '"'.base_url("index.php/admin/employees/delete_eligibility").'"';
		foreach ($all as $key => $value) {
			$id = $value->emp_el_id;
			$data['data'][] = array(
									"<span class='emp_el_program' data-pk='{$id}' data-name='emp_el_program' data-value='{$value->emp_el_program}'>".$value->emp_el_program."</span>",
									"<span class='emp_el_certificate_level' data-pk='{$id}' data-name='emp_el_certificate_level' data-value='{$value->emp_el_certificate_level}'>".$value->emp_el_certificate_level."</span>",
									"<span class='emp_el_status' data-pk='{$id}' data-name='emp_el_status' data-value='{$value->emp_el_status}'>".$value->emp_el_status."</span>",
									"<span class='emp_el_certificate_exp' data-pk='{$id}' data-name='emp_el_certificate_exp' data-value='{$value->emp_el_certificate_exp}'>".date("m/d/Y", strtotime($value->emp_el_certificate_exp))."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='eli' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function get_aff_json() {
		$this->load->model('employee_affilation');
		$tbl = new Employee_Affilation;
		$all = $tbl->search(array('employee_id' => $this->input->get('employee_id')));
		$data = array('data' => array());	
		$url = '"'.base_url("index.php/admin/employees/delete_affilation").'"';
		foreach ($all as $key => $value) {
			$id = $value->emp_aff_id;
			$data['data'][] = array(
									"<span class='emp_aff_org_name' data-pk='{$id}' data-name='emp_aff_org_name' data-value='{$value->emp_aff_org_name}'>".$value->emp_aff_org_name."</span>",
									"<span class='emp_aff_membership_type' data-pk='{$id}' data-name='emp_aff_membership_type' data-value='{$value->emp_aff_membership_type}'>".$value->emp_aff_membership_type."</span>",
									"<span class='emp_aff_status' data-pk='{$id}' data-name='emp_aff_status' data-value='{$value->emp_aff_status}'>".$value->emp_aff_status."</span>",
									"<span class='emp_aff_membership_exp' data-pk='{$id}' data-name='emp_aff_membership_exp' data-value='{$value->emp_aff_membership_exp}'>".date("m/d/Y", strtotime($value->emp_aff_membership_exp))."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='aff' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function get_ets_json() {
		$this->load->model('employee_training_seminar');
		$tbl = new Employee_Training_Seminar;
		$all = $tbl->search(array('employee_id' => $this->input->get('employee_id')));
		$data = array('data' => array());	
		$url = '"'.base_url("index.php/admin/employees/delete_training_seminar").'"';
		foreach ($all as $key => $value) {
			$id = $value->ets_id;
			$data['data'][] = array(
									"<span class='ets_title' data-pk='{$id}' data-name='ets_title' data-value='{$value->ets_title}'>".$value->ets_title."</span>",
									"<span class='ets_date' data-pk='{$id}' data-name='ets_date' data-value='{$value->ets_date}'>".date("m/d/Y", strtotime($value->ets_date))."</span>",
									"<span class='ets_venue' data-pk='{$id}' data-name='ets_venue' data-value='{$value->ets_venue}'>".$value->ets_venue."</span>",
									"<span class='ets_provider' data-pk='{$id}' data-name='ets_provider' data-value='{$value->ets_provider}'>".$value->ets_provider."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' name='ets' onclick='delete_row({$url} ,{$id} ,this); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function print_sis() {
		$this->load->model('employee_spouse');
		$this->load->model('employee_dependent');
		$this->load->model('employee_education');
		$this->load->model('employee_eligibility');
		$this->load->model('employee_affilation');
		$this->load->model('employee_training_seminar');
		$emp = new Employee;
		$emp_spouse = new Employee_Spouse;
		$emp_dep = new Employee_Dependent;
		$emp_educ = new Employee_Education;
		$emp_eli = new Employee_Eligibility;
		$emp_aff = new Employee_Affilation;
		$emp_ts = new Employee_Training_Seminar;

		$emp_id = $this->input->post('emp_id');

		$all = $emp->search(array('employee_id' => $emp_id));
		$data = array();
		foreach ($all as $key => $value) {
			$data = array(
					'employee_lname' => $value->employee_lname,
					'employee_fname' => $value->employee_fname,
					'employee_mname' => $value->employee_mname,
					'employee_blood_type' => $value->employee_blood_type,
					'employee_status' => $value->employee_status,
					'employee_bday' => $value->employee_bday,
					'employee_gender' => $value->employee_gender,
					'employee_father' => $value->employee_father,
					'employee_mother' => $value->employee_mother,
					'employee_telephone' => $value->employee_telephone,
					'employee_mobile' => $value->employee_mobile,
					'employee_religion' => $value->employee_religion,
					'employee_current_address' => $value->employee_current_address,
					'employee_permanent_address' => $value->employee_permanent_address,
					'employee_contact_person_name' => $value->employee_contact_person_name,
					'employee_contact_person_address' => $value->employee_contact_person_address,
					'employee_contact_person_telephone' => $value->employee_contact_person_telephone,
					'employee_contact_person_mobile' => $value->employee_contact_person_mobile,
					'spouse' => $emp_spouse->search(array('employee_id' => $emp_id)),
					'dependent' => $emp_dep->search(array('employee_id' => $emp_id)),
					'education1' => $emp_educ->search("employee_id = '{$emp_id}' AND ee_attainment = 'Elementary' OR ee_attainment = 'High School'" ),
					'education2' => $emp_educ->search("employee_id = '{$emp_id}' AND ee_attainment = 'Undergrad' OR ee_attainment = 'Graduate' OR ee_attainment = 'Post Grad' OR ee_attainment = 'TechVoc'"),
					'eligibility' => $emp_eli->search(array('employee_id' => $emp_id)),
					'affilation' => $emp_aff->search(array('employee_id' => $emp_id)),
					'training_seminar' => $emp_ts->search(array('employee_id' => $emp_id))
				);
		}
		$this->load->view('admin/PIS/employees/201/staff_info_sheet/printable_staff_sheet', $data, FALSE);
	}
	//END
	// EMPLOYMENT REQUIREMENT
	public function check_requirement(){

		$this->load->model('employee_requirement');
		$this->load->model('employment_requirement_checklist');

		$empID = $this->input->post('empID');
		// $empID = 'BTN-2012-0213';
		$data = array();
		$emp = new Employee;
		$emp->toJoin = array('employment' => 'employee',
							 'department' => 'employment'
							);
		$emp->db->where("employees.employee_id = '{$empID}' ");
		foreach($emp->get() as $key => $value){
			$data = array('empFull' => $value->employee_lname . ", ". $value->employee_fname . " ". $value->employee_mname[0].".",
						  'position' => $value->employment_job_title,
						  'department' => $value->department_name
						 );
		}
		
		$data['empID'] = $empID;
		$er = new Employee_Requirement;
		$data['requirements'] = $er->get();

		$erc = new Employment_Requirement_Checklist;
		$erc->db->where("employment_requirement_checklists.employee_id = '{$empID}' ");

		$data['hasReq'] = $erc->get();
		$data['hasFile'] = $this->has_file($empID);
		$ret['view'] = $this->load->view('admin/PIS/employees/201/employment_checklist/employment_req_checklist',$data,TRUE);
		echo json_encode($ret);
	}

	public function has_file($empID=FALSE){
		$file = "";
		if(file_exists('file_upload/users/'.$empID)){
			$file = array_diff(scandir('file_upload/users/'.$empID),array('..','.'));
		}else{
			mkdir('file_upload/users/'.$empID,0777,true);
			$file = array_diff(scandir('file_upload/users/'.$empID),array('..','.'));
		}
		return $file;
	}
	public function delete_file(){
		$ret = array();
		$unlink = unlink('file_upload/users/'.$this->input->post('imageSrc'));
		if(!$unlink){
			$ret['success'] = false;
		}else{
			$ret['success'] = true;
		}
		echo json_encode($ret);
	}
	public function add_emp_req_checklist(){
		$this->load->model("employment_requirement_checklist");

		$ret = array('success' => true);
		if($this->input->post('empID') != NULL){
			if($this->input->post('requirement')){
				foreach ($this->input->post('requirement') as $key => $value) {
					$erc = new Employment_Requirement_Checklist;
					$searchArray = array('employee_id' => $this->input->post('empID'),
										 'er_id' => $key,
										 'status' => $this->input->post('empID') . "_".$key
										);
					$erc->save_or_get($searchArray,$searchArray,'employment_requirement_checklist');
				}
			}
			if($this->input->post('has_file')){
				foreach ($this->input->post('has_file') as $key => $value) {
					$erc = new Employment_Requirement_Checklist;
					$searchArray = array('employee_id' => $this->input->post('empID'),
										 'er_id' => $key,
										 'status' => $this->input->post('empID') . "_".$key
										);
					$erc->save_or_get($searchArray,$searchArray,'employment_requirement_checklist');
				}
			}
			
			$this->upload_files($this->input->post('empID'));
		}else{
			$ret['success'] = false;
		}	
		echo json_encode($ret);
	}
	public function upload_files($empID){

        $this->load->library('upload');
        $files = $_FILES;
        $images = array();
        if(!empty($files['userfile']['name'])){
        	foreach ($files['userfile']['name'] as $key => $image) {
	            $_FILES['userfile']['name']		= $files['userfile']['name'][$key];
	            $_FILES['userfile']['type']		= $files['userfile']['type'][$key];
	            $_FILES['userfile']['tmp_name']	= $files['userfile']['tmp_name'][$key];
	            $_FILES['userfile']['error']	= $files['userfile']['error'][$key];
	            $_FILES['userfile']['size']		= $files['userfile']['size'][$key];

	            $fileName = $empID .'_'. $key;

	            $images[] = $fileName;
	            $config = $this->set_upload_options($empID);
	            $config['file_name'] = $fileName;

	            $this->upload->initialize($config);

	            if ($this->upload->do_upload('userfile')) {
	                $this->upload->data();
	            } else {
	                return false;
	            }
	        }
        }
        

        return $images;
    }
	public function set_upload_options($empID){

		$config = array();
		$path 	= 'file_upload/users/'.$empID;

		if(!is_dir($path)){
			mkdir($path,0777,true);
			$config['upload_path'] = 'file_upload/users/'.$empID."/";	
		}else{
			$config['upload_path'] = 'file_upload/users/'.$empID."/";	
		}

		$config['allowed_types'] = 'jpg|png';
		$config['overwrite'] = TRUE;
		return $config;
	}
	// END OF EMPLOYMENT REQUIREMENT
}

/* End of file employees.php */
/* Location: ./application/controllers/admin/employees.php */
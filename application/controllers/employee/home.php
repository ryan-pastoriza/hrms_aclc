<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{

		$this->create_head_and_navi(array(
									asset_url('plugins/jquery.printThis.js'),
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
											asset_url('plugins/lightbox/css/ekko-lightbox.min.css'),
											asset_url("plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css"),
										 )
									);

		$this->load->model('employee_requirement');
		$this->load->model('employment_requirement_checklist');

		$er = new Employee_Requirement;
		$erc = new Employment_Requirement_Checklist;
		// $erc->db->where("employment_requirement_checklists.employee_id = '{$this->userInfo->employee_id}' ");

		

		// -----

		// EAF

		$emp_id 		 					= $this->emp_id();
		$emp_requirments 					= $this->emp_requirments();
		// $pis 			 					= $this->fetch_pis();
		// $pis_ei 		 					= $this->fetch_pis_ei();
		$department_name 					= $this->emp_dept_id();
		$emp_requirements_done 				= $this->emp_requirements_done();
		$eaf 								= $this->employment_app_form();
		$eaf_spouse 						= $this->emp_app_form_spouse();
		$eaf_children 						= $this->emp_app_form_children();
		$emp_app_form_relative 				= $this->emp_app_form_relative();
		$emp_app_form_education 			= $this->emp_app_form_education();
		$emp_app_form_employment_records 	= $this->emp_app_form_employment_records();
		$emp_app_form_teaching_pos 			= $this->emp_app_form_teaching_pos();
		$emp_app_form_emprec_at_comp 		= $this->emp_app_form_emprec_at_comp();
		$emp_app_form_trainings 			= $this->emp_app_form_trainings();
		$emp_app_form_orgs 					= $this->emp_app_form_orgs();
		$emp_app_form_references 			= $this->emp_app_form_references();

		// // SIS

		$sis_employees = $this->sis_employees();
		$sis_spouse = $this->sis_spouse();
		$sis_dependents = $this->sis_dependents();
		$sis_education = $this->sis_education();
		$sis_education2 = $this->sis_education2();
		$sis_eligibility = $this->sis_eligibility();
		$sis_affilation = $this->sis_affilation();
		$sis_training = $this->sis_training();

		// Update Request

		$view_update_request = $this->view_update_requests();


		$data = array('emp_id' 					=> $emp_id,
					  'emp_requirments' 		=> $emp_requirments,
					  'emp_requirements_done' 	=> $emp_requirements_done,
					  'eaf' 					=> $eaf,
					  'eaf_spouse' 				=> $eaf_spouse,
					  'eaf_children' 			=> $eaf_children,
					  'emp_app_form_relative' 	=> $emp_app_form_relative,
					  'emp_app_form_education' 	=> $emp_app_form_education,
					  'eaf_employment_records' 	=> $emp_app_form_employment_records,
					  'eaf_teaching_pos' 		=> $emp_app_form_teaching_pos,
					  'eaf_emprec' 				=> $emp_app_form_emprec_at_comp,
					  'eaf_training' 			=> $emp_app_form_trainings,
					  'eaf_orgs' 				=> $emp_app_form_orgs,
					  'eaf_ref' 				=> $emp_app_form_references,
					  'sis_emp' 				=> $sis_employees,
					  'sis_spouse' 				=> $sis_spouse,
					  'sis_dependents' 			=> $sis_dependents,
					  'sis_education' 			=> $sis_education,
					  'sis_education2' 			=> $sis_education2,
					  'sis_eligibility'			=> $sis_eligibility,
					  'sis_affilation' 			=> $sis_affilation,
					  'sis_training' 		 	=> $sis_training,
					  'vur'						=> $view_update_request, 
			);
			$data['hasReq'] = $erc->get();
			$data['requirements'] = $er->get();
			$data['hasFile'] = $this->has_file($this->userInfo->employee_id);

		$content = $this->load->view('employee/home', $data, TRUE);

		// -----
		// $content = $this->load->view('admin/PIS/employees/201/employment_checklist/employment_req_checklist',$data,TRUE);
		// $content .= $this->load->view('admin/PIS/employees/201/employment_checklist/jscripts',[],TRUE);

		create_content(array('contentHeader' => 'My Records',
							 'breadCrumbs'	 => true,
							 'content'       => $content
							)
					  );

		$this->create_footer();

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
	// Employment Application Form 

	public function emp_id(){
		$emp_id = $this->session->userdata['DP_USER_ID'];		
		return $emp_id;
	}

	public function emp_requirments(){

		$emp_id = $this->emp_id();


		$this->load->model('employee_requirement');
		$er = new Employee_Requirement;

		$er_all = array();
		$er_all = $er->get();

		return $er_all;

	}

	public function emp_requirements_done(){
		$emp_id = $this->emp_id();

		$this->load->model('employment_requirement_checklist');
		$erc = new Employment_Requirement_Checklist;

		$erc_all = $erc->search("employment_requirement_checklists.employee_id = '$emp_id'");

		return $erc_all;
	}



	public function emp_dept_id(){
		$emp_id = $this->emp_id();
		
		$this->load->model('employment');
		$pis_ei = new Employment;

		$fpis_ei = $pis_ei->pop("employment.employee_id = '$emp_id'");
		$dept_id = $fpis_ei->department_id;

		$this->load->model('department');
		$dept = new Department;

		$dept_name = $dept->pop("departments.department_id = $dept_id");

		$department_name = $dept_name->department_name;
		return $department_name;

	}

	public function employment_app_form()
	{

		$emp_id = $this->emp_id();

		$this->load->model('employment_application_form');
		$eaf = new Employment_application_form;

		$erc_all = $eaf->pop("employment_application_forms.employee_id = '$emp_id' ");
		
		return $erc_all;

		// echo $erc_all->eaf_position_applied;

	}

	public function get_eaf_id(){

		$emp_id = $this->emp_id();
		$this->load->model('employment_application_form');
		$eaf = new Employment_application_form;
		$eaf_id = $eaf->pop("employment_application_forms.employee_id = '$emp_id'");

		return $eaf_id->eaf_id;

	}


	public function emp_app_form_spouse(){

		$eaf_id = $this->get_eaf_id();

		$this->load->model('emp_app_form_spouse');
		$spouse = new Emp_app_form_spouse;

		$eaf_spouse = $spouse->search("emp_app_form_spouse.eaf_id = '$eaf_id'");

		return $eaf_spouse;
	}

	public function emp_app_form_children(){
		$eaf_id = $this->get_eaf_id();

		$this->load->model('emp_app_form_children');
		$children = new Emp_app_form_children;

		$eaf_children = $children->search("emp_app_form_children.eaf_id = '$eaf_id'");

		return $eaf_children;

	}

	public function emp_app_form_relative(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_relatives');
		$relative = new Emp_app_form_relatives;

		$eaf_relative = $relative->search("emp_app_form_relatives.eaf_id = '$eaf_id'");
		return $eaf_relative;
	}

	public function emp_app_form_education(){

		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_education');

		$education = new Emp_app_form_education;
		$eaf_education = $education->search("emp_app_form_education.eaf_id = '$eaf_id'");

		return $eaf_education;

	}

	public function emp_app_form_employment_records(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_employment_records');
		$emp_records = new Emp_app_form_employment_records;
		$eaf_eaf_er = $emp_records->search("emp_app_form_employment_records.eaf_id = '$eaf_id'");

		return $eaf_eaf_er;
	}

	public function emp_app_form_teaching_pos(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_teaching_pos');
		$emp_tp = new Emp_app_form_teaching_pos;
		$eaf_tp = $emp_tp->search("emp_app_form_teaching_pos.eaf_id = '$eaf_id'");

		return $eaf_tp;
	}

	public function emp_app_form_emprec_at_comp(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_emprec_at_comp');
		$emp_emprec = new Emp_app_form_emprec_at_comp;
		$eaf_empre = $emp_emprec->search("emp_app_form_emprec_at_comp.eaf_id = '$eaf_id'");

		return $eaf_empre;
	}

	public function emp_app_form_trainings(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_trainings');
		$emp_training = new Emp_app_form_trainings;
		$eaf_training = $emp_training->search("emp_app_form_trainings.eaf_id = '$eaf_id'");
		
		return $eaf_training;
	}

	public function emp_app_form_orgs(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_orgs');
		$emp_orgs = new Emp_app_form_orgs;
		$eaf_orgs = $emp_orgs->search("emp_app_form_orgs.eaf_id = '$eaf_id'");

		return $eaf_orgs;
	}

	public function emp_app_form_references(){
		$eaf_id = $this->get_eaf_id();
		$this->load->model('emp_app_form_references');
		$emp_ref = new Emp_app_form_references;
		$eaf_ref = $emp_ref->search("emp_app_form_references.eaf_id = '$eaf_id'");

		return $eaf_ref;
	}



	// Staff Information Sheet Section

	public function sis_employees(){
		$emp_id = $this->emp_id();

		$this->load->model('employee');
		$employee = new Employee;

		$sis_emp = $employee->pop("employees.employee_id = '$emp_id'");

		return $sis_emp;
	}

	public function sis_spouse(){
		$emp_id = $this->emp_id();

		$this->load->model('employee_spouse');
		$spouse = new Employee_spouse;

		$sis_spouse = $spouse->search("employee_spouse.employee_id = '$emp_id'");

		return $sis_spouse;
	}

	public function sis_dependents(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_dependent');
		$dependents = new Employee_Dependent;
		$sis_dependents = $dependents->search("employee_dependents.employee_id = '$emp_id'");
		return $sis_dependents;

	}

	public function sis_education(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_education');
		$education = new Employee_Education;
		$sis_education = $education->search("employee_education.employee_id = '$emp_id' and (employee_education.ee_attainment = 'Elementary' or employee_education.ee_attainment = 'High School') ");
		return $sis_education;
	}

	public function sis_education2(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_education');
		$education = new Employee_Education;
		$sis_education2 = $education->search("employee_education.employee_id = '$emp_id' and (employee_education.ee_attainment != 'Elementary' AND employee_education.ee_attainment != 'High School') ");
		return $sis_education2;
	}

	public function sis_eligibility(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_eligibility');
		$eligibility = new Employee_Eligibility;
		$sis_eligibility = $eligibility->search("employee_eligibilities.employee_id = '$emp_id'");
		return $sis_eligibility;
	}

	public function sis_affilation(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_affilation');
		$affilation = new Employee_Affilation;
		$sis_affilation = $affilation->search("employee_affilations.employee_id = '$emp_id'");
		return $sis_affilation;
	}

	public function sis_training(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_training_seminar');
		$training = new Employee_Training_Seminar;
		$sis_training = $training->search("employee_training_seminar.employee_id = '$emp_id'");
		return $sis_training;
	}

	public function add_request(){

		$empID = $this->userInfo->employee_id;
		$this->load->model('employee_update_request');
		$emp_ur = new Employee_Update_Request;

		$emp_ur->eur_request_content = $this->input->post('eur_request_content');	
		$emp_ur->employee_id 		 = $this->userInfo->employee_id;
		$emp_ur->eur_date_filed 	 = date("Y-m-d H:i:s");
		$emp_ur->eur_status 		 = 0;
		$emp_ur->save();
		$vur_new = $this->view_update_requests();
		$form_view = $this->load->view('employee/new/update_form', ['vur' => $vur_new], TRUE);

		// Return JSON_ENCODE
		if($emp_ur->db->affected_rows() > 0){
			$this->upload_request_file();
			echo json_encode(array("result" => true, "form_view" => $form_view ));
		}
	}

	public function upload_request_file(){

		$empID = $this->userInfo->employee_id;
		$config = $this->set_upload_options($empID);
		
    	$this->load->library('upload', $config);

	 	if (!$this->upload->do_upload('eur_request_file')){
	 		return false;
	 	}
	 	else{
	 		$this->upload->data();
	 	}

	}
   
	public function set_upload_options($empID){

		// set folder
		$config = array();
		$path 	= 'file_upload/users/'.$empID."/update_requests";
		if(!is_dir($path)){
			mkdir($path,0777,true);
			$config['upload_path'] = 'file_upload/users/'.$empID."/update_requests";	
		}else{
			$config['upload_path'] = 'file_upload/users/'.$empID."/update_requests/";	
		}

		$config['allowed_types'] = '*';
		$config['overwrite'] = FALSE;
		$config['file_name'] = "update_request_" . date("M-d-Y-l");
		return $config;
	}


	public function delete_request($id){
		$this->load->model('employee_update_request');
		$eur = new Employee_Update_Request;
		$eur->load($id);
		$eur->delete();
		$vur_new = $this->view_update_requests();
		$form_view = $this->load->view('employee/new/update_form', ['vur' => $vur_new], TRUE);
		echo json_encode(array("result" => true, "form_view" => $form_view));
	}

	public function view_update_requests(){
		$emp_id = $this->emp_id();
		$this->load->model('employee_update_request');
		$eur = new Employee_Update_Request;
		$eur->sqlQueries["order_type"] = 'desc';
		$eur->sqlQueries["order_field"] = 'eur_date_filed';
		$fetch_eur = $eur->search("employee_update_request.employee_id = '$emp_id'");
		return $fetch_eur;
	}

}

/* End of file home.php */
/* Location: ./application/controllers/employee/home.php */

		// echo "<pre>";
		// print_r();
		// echo "<pre>";
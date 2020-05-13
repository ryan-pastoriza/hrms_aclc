<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employment extends MY_Model{
		const DB_TABLE = "employment";
		const DB_TABLE_PK = "employment_id";
		public $employment_id;
		public $employee_id;
		public $employment_rate;
		public $employment_status;
		public $department_id;
		public $employment_job_title;
		public $employment_hired_date;
		public $employment_type;
		public $sss_no;
		public $pagibig_no;
		public $tin_no;
		public $philhealth_no;
		public $companys;
		public $divisions;
		public $section_programs;
		public $atm_no;
		public $tax;
	}
	
?>
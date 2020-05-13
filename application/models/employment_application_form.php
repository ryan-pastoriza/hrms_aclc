<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employment_application_form extends MY_Model {

		const DB_TABLE = "employment_application_forms";
		const DB_TABLE_PK = "eaf_id";

		public $eaf_id;
		public $employee_id;
		public $eaf_position_applied;
		public $eaf_employment_desired;
		public $eaf_fname;
		public $eaf_mname;
		public $eaf_lname;
		public $eaf_nickname;
		public $eaf_gender;
		public $eaf_height;
		public $eaf_weight;
		public $eaf_birthdate;
		public $eaf_birthplace;
		public $eaf_civil_status;
		public $eaf_marriage_date;
		public $eaf_pre_addr;
		public $eaf_pal_num;
		public $eaf_pam_num;
		public $eaf_peram_addr;
		public $eaf_peral_num;
		public $eaf_peram_num;
		public $eaf_blood_type;
		public $eaf_citizenship;
		public $eaf_religion;
		public $eaf_TIN;
		public $eaf_SSS;
		public $eaf_philhealth;
		public $eaf_pagibig;
}

/* End of file employment_application_form.php */
/* Location: ./application_form.php */
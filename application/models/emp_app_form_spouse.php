<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_spouse extends MY_Model {

	const DB_TABLE = "emp_app_form_spouse";
	const DB_TABLE_PK = "eaf_spouse_id";

	public $eaf_spouse_id;
	public $eaf_id;
	public $eaf_spouse_name;
	public $eaf_spouse_dob;
	public $eaf_spouse_occupation;
	public $eaf_spouse_contact_num;

}

/* End of file emp_app_form_spouse.php */
/* Location: ./application/models/emp_app_form_spouse.php */
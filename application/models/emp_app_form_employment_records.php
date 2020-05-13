<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_employment_records extends MY_Model {

	const DB_TABLE = "emp_app_form_employment_records";
	const DB_TABLE_PK = "eaf_er_id";

	public $eaf_er_id;
	public $eaf_id;
	public $eaf_er_comp_name;
	public $eaf_er_superior;
	public $eaf_er_date_from;
	public $eaf_er_date_to;
	public $eaf_er_comp_address;
	public $eaf_er_comp_num;
	public $eaf_er_superior_num;
	public $eaf_er_salary_start;
	public $eaf_er_salary_final;
	public $eaf_er_position;
	public $eaf_er_rfl;
	public $eaf_er_duties;

}

/* End of file emp_app_form_employment_records.php */
/* Location: ./application/models/emp_app_form_employment_records.php */
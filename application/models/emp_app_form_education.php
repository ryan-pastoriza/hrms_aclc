<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_app_form_education extends MY_Model {

	const DB_TABLE="emp_app_form_education";
	const DB_TABLE_PK="eaf_educ_id";

	public $eaf_id;
	public $eaf_educ_school_type;
	public $eaf_educ_school_name;
	public $eaf_educ_degree;
	public $eaf_educ_from;
	public $eaf_educ_to;
	public $eaf_educ_honors;

}

/* End of file emp_app_form_education.php */
/* Location: ./application/models/emp_app_form_education.php */
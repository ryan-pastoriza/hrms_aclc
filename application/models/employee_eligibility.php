<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Eligibility extends MY_Model {

	const DB_TABLE = "employee_eligibilities";
	const DB_TABLE_PK = "emp_el_id";

	public $emp_el_id;
	public $employee_id;
	public $emp_el_program;
	public $emp_el_certificate_level;
	public $emp_el_status;
	public $emp_el_certificate_exp;

}

/* End of file employee_eligibility.php */
/* Location: ./application/models/employee_eligibility.php */
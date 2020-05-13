<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Affilation extends MY_Model {

	const DB_TABLE = "employee_affilations";
	const DB_TABLE_PK = "emp_aff_id";

	public $emp_aff_id;
	public $employee_id;
	public $emp_aff_org_name;
	public $emp_aff_membership_type;
	public $emp_aff_status;
	public $emp_aff_membership_exp;

}

/* End of file employee_affilation.php */
/* Location: ./application/models/employee_affilation.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Paf extends MY_Model {

	const DB_TABLE = "employee_paf";
	const DB_TABLE_PK = "emp_paf_id";

	public $emp_paf_id;
	public $employee_id;
	public $emp_paf_date_filed;
	public $emp_paf_action_taken;
	public $emp_paf_effectivity_date;
	public $emp_paf_from_employment;
	public $emp_paf_to_employment;
	public $emp_paf_from_department;
	public $emp_paf_to_department;
	public $emp_paf_from_division;
	public $emp_paf_to_division;
	public $emp_paf_from_company;
	public $emp_paf_to_company;
	public $emp_paf_from_branch;
	public $emp_paf_to_branch;
	public $emp_paf_to_basic_sal;
	public $emp_paf_from_transportation;
	public $emp_paf_to_transportation;
	public $emp_paf_from_meal;
	public $emp_paf_to_meal;
	public $emp_paf_to_others;
	public $emp_paf_from_others;
	public $emp_paf_from_basic_sal;
	public $emp_paf_justification;
	public $emp_paf_regularization;
	public $emp_paf_promotion;
	public $emp_paf_transfer;
	public $emp_paf_salary_increase;
	public $emp_paf_others;
	public $emp_paf_others_detail;

}

/* End of file employee_paf.php */
/* Location: ./application/models/employee_paf.php */
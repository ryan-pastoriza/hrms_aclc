<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Dependent extends MY_Model {

	const DB_TABLE = "employee_dependents";
	const DB_TABLE_PK = "emp_dependent_id";

	public $emp_dependent_id;
	public $employee_id;
	public $emp_dependent_name;
	public $emp_dependent_birthdate;
	public $emp_dependent_relationship;
	public $emp_dependent_dependency;

}

/* End of file employee_Dependent.php */
/* Location: ./application/models/employee_Dependent.php */
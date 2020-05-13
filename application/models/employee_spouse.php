<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Spouse extends MY_Model {

	const DB_TABLE = "employee_spouse";
	const DB_TABLE_PK = "emp_spouse_id";

	public $emp_spouse_id;
	public $employee_id;
	public $spouse_name;
	public $spouse_birth_date;
	public $spouse_date_of_marriage;
	public $spouse_occupation;
	public $spouse_employer;
	public $spouse_employer_address;
	public $spouse_contact_number;

}

/* End of file employee_spouse.php */
/* Location: ./application/models/employee_spouse.php */
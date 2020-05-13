<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Education extends MY_Model {

	const DB_TABLE = "employee_education";
	const DB_TABLE_PK = "ee_id";

	public $ee_id;
	public $employee_id;
	public $ee_school_name;
	public $ee_attainment;
	public $ee_course_taken;
	public $ee_units_earned;
	public $ee_ongoing_units;
	public $ee_year_graduated;

}

/* End of file employee_education.php */
/* Location: ./application/models/employee_education.php */
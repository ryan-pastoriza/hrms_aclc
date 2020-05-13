<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employee_Child extends MY_Model{
		const DB_TABLE = "employee_child";
		const DB_TABLE_PK = "emp_child_id";
		public $emp_child_id;
		public $employee_id;
		public $emp_child_name;
		public $emp_child_birthday;
		public $emp_child_dependency;
	}
?>
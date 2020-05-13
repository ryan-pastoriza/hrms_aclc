<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employee_Addresses extends MY_Model{
		
		const DB_TABLE = "employee_addresses";
		const DB_TABLE_PK = "emp_add_id";
		public $emp_add_id;
		public $employee_id;
		public $emp_add_type;
		public $emp_location;
		public $emp_phone;
		public $emp_mobile;
	}
?>
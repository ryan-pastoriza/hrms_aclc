<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employee_Leave extends MY_Model{

		const DB_TABLE = "employee_leave";
		const DB_TABLE_PK = "emp_leave_id";

		public $employee_id;
		public $emp_leave_id;
		public $emp_leave_filed;
		public $emp_leave_availment;
		public $emp_leave_from;
		public $emp_leave_to;
		public $emp_leave_days;
		public $emp_leave_hours;
		public $emp_leave_with_pay;
		public $emp_leave_remark;
		public $emp_leave_request_status;

	}
	
?>
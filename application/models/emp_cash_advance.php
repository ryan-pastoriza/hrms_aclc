<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Emp_Cash_Advance extends MY_Model{
		
		const DB_TABLE = "emp_cash_advances";
		const DB_TABLE_PK = "emp_ca_id";

		public $emp_ca_id;
		public $employee_id;
		public $emp_ca_filed;
		public $emp_ca_amount;
		public $emp_ca_purpose;
		public $emp_ca_repayment_term;
		public $emp_ca_repayment_amt;
		public $emp_ca_request_status;
		public $emp_ca_deduct_start;
	}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Emp_Loan_Payment extends MY_Model{
		
		const DB_TABLE = "emp_loan_payments";
		const DB_TABLE_PK = "el_payment_id";

		public $emp_loan_id;
		public $el_payment_date;
		public $el_payment_option;
		public $el_payment_amount;
	}
?>
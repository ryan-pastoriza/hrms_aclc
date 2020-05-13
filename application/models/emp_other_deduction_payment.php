<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Emp_Other_Deduction_Payment extends MY_Model{
		
		const DB_TABLE = "emp_other_deduction_payments";
		const DB_TABLE_PK = "eod_payment_id";

		public $eod_payment_id;
		public $eod_id;
		public $eod_payment_date;
		public $eod_payment_option;
		public $eod_payment_amount;
	}
?>
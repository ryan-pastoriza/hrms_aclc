<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Emp_Ca_Payment extends MY_Model{
		
		const DB_TABLE = "emp_ca_payments";
		const DB_TABLE_PK = "ca_payment_id";

		public $ca_payment_id;
		public $emp_ca_id;
		public $ca_payment_amt;
		public $ca_payment_option;
		public $ca_payment_date;
	}
?>
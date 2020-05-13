<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_eod_payment extends MY_Model {

	const DB_TABLE = 'payroll_eod_payments';
	const DB_TABLE_PK = 'proll_eod_payment_id';

	public $proll_eod_payment_id;
	public $emp_proll_id;
	public $eod_payment_id;

}

/* End of file payroll_eod_payment.php */
/* Location: ./application/models/payroll_eod_payment.php */
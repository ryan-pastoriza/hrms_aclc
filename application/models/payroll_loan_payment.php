<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_loan_payment extends MY_Model {

	const DB_TABLE 		= 'payroll_loan_payments';
	const DB_TABLE_PK 	= 'plp_id';

	public $plp_id;
	public $el_payment_id;
	public $emp_proll_id;

}

/* End of file payroll_loan_payment.php */
/* Location: ./application/models/payroll_loan_payment.php */
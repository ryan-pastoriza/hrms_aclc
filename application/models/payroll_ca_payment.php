<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_ca_payment extends MY_Model {

	const DB_TABLE 		= 'payroll_ca_payments';
	const DB_TABLE_PK 	= 'pcap_id';

	public $pcap_id;
	public $ca_payment_id;
	public $emp_proll_id;

}

/* End of file payroll_ca_payment.php */
/* Location: ./application/models/payroll_ca_payment.php */
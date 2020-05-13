<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_adjustment extends MY_Model {

	const DB_TABLE = 'payroll_adjustments';
	const DB_TABLE_PK = 'proll_adj_id';

	public $proll_adj_id;
	public $proll_adj_amt;
	public $emp_proll_id;
	public $proll_adj_name;

}

/* End of file payroll_adjustment.php */
/* Location: ./application/models/payroll_adjustment.php */
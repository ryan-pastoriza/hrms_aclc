<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_record extends MY_Model {

	const DB_TABLE 		= 'payroll_record';
	const DB_TABLE_PK 	= 'pr_id';

	public $pr_id;
	public $pr_date;
	public $pr_cut_off_from;
	public $pr_cut_off_to;


	public function emp_proll()
	{
		$this->load->model('emp_payroll_rec');

		$epr = new Emp_payroll_rec;
		$epr->toJoin = ['employment' => 'emp_payroll_rec',
						'employee' => 'employment'];

		$eprs = $epr->search(['pr_id' => $this->pr_id]);

		return $eprs;

	}

}

/* End of file payroll_record.php */
/* Location: ./application/models/payroll_record.php */
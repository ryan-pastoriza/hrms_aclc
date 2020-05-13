<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_payroll_rec extends MY_Model {

	const DB_TABLE 		= 'emp_payroll_rec';
	const DB_TABLE_PK 	= 'emp_proll_id';

	public $emp_proll_id;
	public $employment_id;
	public $pr_id;
	public $emp_proll_ot_hrs;
	public $emp_proll_ot_pay;
	public $emp_proll_pay;
	public $emp_proll_absent;
	public $emp_proll_wtax;
	public $emp_proll_sss;
	public $emp_proll_philhealth;
	public $emp_proll_hdmf;
	public $emp_proll_absent_days;
	public $emp_proll_late_mins;
	public $emp_proll_ut_mins;
	public $emp_proll_ut_ded;
	public $emp_proll_late_ded;

	public function adjustments()
	{
		$this->load->model('payroll_adjustment');

		$pa = new Payroll_adjustment;
		$pas = $pa->search(['emp_proll_id' => $this->emp_proll_id]);

		return $pas;
	}
	public function empInfo()
	{
		$this->load->model('employee');
		$emp = new Employee;
		$emp->toJoin = ['employment' => 'employee'];
		$emp->load($this->employee_id);

		return $emp;
	}
	public function cash_advance_payments()
	{
		$this->load->model('payroll_ca_payment');
		$pcp = new Payroll_ca_payment;
		$pcp->toJoin = ['emp_ca_payment' => 'payroll_ca_payment',
						'emp_cash_advance' => 'emp_ca_payment'];
		$pcps = $pcp->search(['emp_proll_id' => $this->emp_proll_id]);

		return $pcps;
	}

	public function loan_payments()
	{
		$this->load->model('emp_loan_payment');
		$lp = new Emp_loan_payment;
		$lp->toJoin = ['emp_loan' => 'emp_loan_payment',
						'payroll_loan_payment' => 'emp_loan_payment'];

		$lps = $lp->search(['emp_proll_id' => $this->emp_proll_id]);

		return $lps;
	}
	public function other_deduction_payments()
	{
		$this->load->model('payroll_eod_payment');
		$pep  = new Payroll_eod_payment;

		$pep->toJoin = ['emp_other_deduction_payment' 	=> 'payroll_eod_payment',
						'emp_other_deduction' 			=> 'emp_other_deduction_payment',
						'other_deduction' 				=> 'emp_other_deduction'];
		$peps = $pep->search(['emp_proll_id' => $this->emp_proll_id]);
		return $peps;
	}


}

/* End of file emp_payroll_rec.php */
/* Location: .//C/xampp/htdocs/hrms_compile_42615/emp_payroll_rec.php */
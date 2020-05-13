<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_Loan extends MY_Model {
	const DB_TABLE = "emp_loans";
	const DB_TABLE_PK = "emp_loan_id";

	public $employee_id;
	public $emp_loan_id;
	public $emp_loan_filed;
	public $emp_loan_type;
	public $emp_loan_term;
	public $emp_loan_amt;
	public $emp_loan_deduct;
	public $emp_loan_request_status;

}
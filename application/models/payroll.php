<?php
/**
 * @Author: gian
 * @Date:   2015-12-08 15:26:05
 * @Last Modified by:   gian
 * @Last Modified time: 2015-12-08 15:29:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Payroll extends MY_Model {
	
	const DB_TABLE = "payroll";
	const DB_TABLE_PK = "payroll_id";
	public $payroll_id;
	public $employee_id;
	public $date;
	public $start_day;
	public $end_day;
	public $hours_worked;
	public $gross_pay;
	public $sss_deduction;
	public $pabibig_deduction;
	public $tax_deduction;
	public $philhealth_deduction;

}
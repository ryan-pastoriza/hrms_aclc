<?php
/**
 * @Author: gian
 * @Date:   2016-04-11 09:44:40
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-11 17:26:16
 */

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Emp_Log_Fail_Requests extends MY_Model{
	
	const DB_TABLE = "emp_log_fail_requests";
	const DB_TABLE_PK = "emp_lfr_id";
	
	public $emp_lfr_id;
	public $employee_id;
	public $emp_lfr_filed;
	public $sched_id;
	public $emp_lfr_log_in;
	public $emp_lfr_log_out;
	public $emp_lfr_reason;
	public $emp_lfr_request_status;	
	// public $emp_lfr_changed;
	public $emp_lfr_date;

}

/* End of file emp_log_fail_requests.php */
/* Location: ./application/models/emp_log_fail_requests.php */
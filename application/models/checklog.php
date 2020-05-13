<?php
/**
 * @Author: khrey
 * @Date:   2015-10-22 11:00:30
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-22 11:54:30
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklog extends MY_Model {
	const DB_TABLE = "checklogs";
	const DB_TABLE_PK = "log_id";

	public $log_id;
	public $badgenumber;
	public $log_time;
	public $logtype;

	public function employee()
	{
		$emp = new Employee;
		$emp = $emp->pop(['biometric_id' => $this->badgenumber]);

		if ($emp->employee_id != "") {
			$theEmp = new Employee;
			$theEmp->load_with_employment_info($emp->employee_id);
			return $theEmp;
		}
		return false;
	}


}

/* End of file attendance_rule.php */
/* Location: ./application/models/attendance_rule.php */
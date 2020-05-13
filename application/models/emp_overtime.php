<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_Overtime extends MY_Model {
	const DB_TABLE = "emp_overtime";
	const DB_TABLE_PK = "emp_ot_id";

	public $emp_ot_id;
	public $employee_id;
	public $emp_ot_date;
	public $emp_ot_from;
	public $emp_ot_to;
	public $emp_ot_total_hours;
	public $emp_ot_work_shift_in;
	public $emp_ot_work_shift_out;
	public $emp_ot_purpose;
	public $emp_ot_actual_worked;
	public $emp_ot_request_status;
	public $emp_ot_date_filed;

	public function logs()
	{
		if ($this->emp_ot_work_shift_in != "" || $this->emp_ot_work_shift_out != "") {
			$theLogs 			 = new stdClass;
			$theLogs->emp_ot_in  = $this->emp_ot_work_shift_in;
			$theLogs->emp_ot_out = $this->emp_ot_work_shift_out;
			return $theLogs;
		}
		else{
			$emp = new Employee;
			$emp->load_with_employment_info($this->employee_id);

			$this->load->model('checklog');

				$this->checklog->sqlQueries['order_field'] 	= 'log_time';
				$this->checklog->sqlQueries['order_type'] 	= 'desc';

				$theIn = $this->checklog->search("DATE(log_time) = '{$this->emp_ot_date}' AND TIME(log_time) < '{$this->emp_ot_to}' AND badgenumber = {$emp->biometric_id} AND logType = 'I' ", 1);

				$this->checklog->sqlQueries['order_type'] = 'asc';
				$theOut = $this->checklog->search("DATE(log_time) = '{$this->emp_ot_date}' AND TIME(log_time) >= '{$this->emp_ot_from}' AND badgenumber = {$emp->biometric_id} AND logType = 'O'", 1);

				if($theIn || $theOut){
					$theLogs = new stdClass;

					if ($theIn) {

						$theIn = reset($theIn);	
						$timeIn = date('H:i', strtotime($this->emp_ot_from));
						$this->emp_ot_work_shift_in = $timeIn;
						$theLogs->emp_ot_in = strtotime($theIn->log_time) > strtotime($timeIn) ? date('H:i', strtotime($theIn->log_time)) : $timeIn;
						$theIn->delete();

					}
					else{
						$theLogs->emp_ot_in = false;
					}


					if ($theOut) {
						$theOut = reset($theOut);
						$theLogs->emp_ot_out = date('H:i', strtotime($theOut->log_time));

						$this->emp_ot_work_shift_out = $theLogs->emp_ot_out;
					}
					else{
						$theLogs->emp_ot_out = false;
					}

					$theOut->delete();
					$this->save();

					return $theLogs;

				}
				else{
					return false;
				}
		}
	}
}
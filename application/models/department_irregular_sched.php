<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_irregular_sched extends MY_Sched_Model {

	const DB_TABLE 		= 'department_irregular_sched';
	const DB_TABLE_PK 	= 'dis_id';
	const TIME_IN       = 'sched_from_date';
	const TIME_OUT 		= 'sched_to_date';

	public $dis_id;
	public $department_id;
	public $sched_from_date; /*datetime*/
	public $sched_to_date;	/*datetime*/

	public function log($emp_id, $date)
	{
		if (!isset($this->log)) {
			$this->load->model('employee_log');
			$emp_log = new Employee_log; 
			$theLog = $emp_log->pop(['emp_log_sched_type' => "Department_irregular_sched",
									'emp_log_date' => $date,
									'emp_log_sched_id' => $this->dis_id,
									'employee_id' => $emp_id]);
			$this->log = $theLog;
		}
		
		return $this->log;
	}
	public function on_leave($emp_id, $date)
	{
		$this->load->model('employee_leave');

		$emp_leave = new Employee_leave;
		$dateFrom  = $date." ".$this->{$this::TIME_IN};
		$dateTo    = $date." ".$this->{$this::TIME_OUT};

		$el =  $emp_leave->pop(" employee_id = '{$emp_id}' 
								AND
								(
									emp_leave_from BETWEEN '{$dateFrom}' AND '{$dateTo}'
									OR
									emp_leave_to BETWEEN '{$dateFrom}' AND '{$dateTo}'
									OR
									'{$dateFrom}' BETWEEN emp_leave_from AND emp_leave_to
									OR
									'{$dateTo}' BETWEEN emp_leave_from AND emp_leave_to
								)");
		return $el;
	}
	public function minutes_length()
	{
		$difference = $this->funcs->time_interval($this->{$this::TIME_IN},$this->{$this::TIME_OUT});

		$diff = $difference->i;
		$diff += $difference->h * 60;

		return $diff;

	}

}

/* End of file department_irregular_sched.php */
/* Location: ./application/models/department_irregular_sched.php */
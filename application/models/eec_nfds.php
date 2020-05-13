<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/

	/**
	* 
	*/
	class Eec_Nfds extends MY_Sched_Model{		

		const DB_TABLE    = "eec_nfds";
		const DB_TABLE_PK = "eec_nfds_id";
		const TIME_IN     = "nfds_time_in";
		const TIME_OUT    = "nfds_time_out";

		
		public $eec_nfds_id;
		public $eec_id;
		public $nfds_id;
		public $status;
		public $start;
		public $end;

		public function log($emp_id, $date)
		{
			if (!isset($this->log)) {
				$this->load->model('employee_log');
				$emp_log = new Employee_log; 
				$theLog = $emp_log->pop(['emp_log_sched_type' 	=> "Eec_Nfds",
										'emp_log_date' 			=> $date,
										'emp_log_sched_id' 		=> $this->eec_nfds_id,
										'employee_id' 			=> $emp_id]);
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
									)
									");
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

?>
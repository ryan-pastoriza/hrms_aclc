<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_log extends MY_Model {

	const DB_TABLE = "employee_logs";
	const DB_TABLE_PK = "emp_log_id";

	public $emp_log_id;
	public $emp_log_sched_type;
	public $employee_id;
	public $emp_log_sched_id;
	public $emp_log_date;
	public $emp_log_in;
	public $emp_log_out;
	public $emp_log_update;

	public function sched_info()
	{
		$this->load->model($this->emp_log_sched_type);
		$class = new $this->emp_log_sched_type();

		if ($this->emp_log_sched_type == "Depts_Def_Sched_Nfds" || $this->emp_log_sched_type == "Eec_Nfds") {
			$class->toJoin = ['non_flexi_daily_scheds' => $this->emp_log_sched_type];
		}

		$class->load($this->emp_log_sched_id);
		return $class;
	}
	public function logs_today()
	{
		$emp = new Employee;
		$emp->load_with_employment_info($this->employee_id);

		return $emp->logs_today();
	}	

}

/* End of file employee_log.php */
/* Location: ./application/models/employee_log.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/

	/**
	* 
	*/
	class Nfds_Logs extends MY_Model
	{
		const DB_TABLE = "nfds_logs";
		const DB_TABLE_PK = "nfds_log_id";
		public $nfds_log_id;
		public $nfds_id;
		public $log_date;
		public $log_in;
		public $log_out;
		public $employee_id;
		public $log_update;

		public function by_dates($fromDate, $toDate, $emp_id)
		{
			$fromDate 	= date('Y-m-d',strtotime($fromDate));
			$toDate 	= date('Y-m-d',strtotime($toDate));
			$allByDate	= array();


			$this->toJoin = array('non_flexi_daily_scheds' => 'nfds_logs',
										'employee' => 'nfds_logs');
			$allLogs = $this->search("employees.employee_id = '{$emp_id}' AND (nfds_logs.log_date BETWEEN '{$fromDate}' AND '{$toDate}')");
			$this->sqlQueries['order_field'] = "nfds_logs.log_date";
			$this->sqlQueries['order_type'] = "asc";

			foreach ($allLogs as $key => $value) {
					$allByDate[$value->log_date][] = $value;
			}
			return $allByDate;
		}
		
	}

?>
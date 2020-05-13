<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/

	/**
	* 
	*/
	class Non_Flexi_Daily_Scheds extends MY_Model{		
		const DB_TABLE = "non_flexi_daily_scheds";
		const DB_TABLE_PK = "nfds_id";
		public $nfds_id;
		public $nfds_day;
		public $nfds_time_in;
		public $nfds_time_out;

		public function log($date = false, $employee_id = false)
		{
			if (!isset($this->log)) {
				$this->load->model('nfds_logs');

				$nfds_log = new Nfds_Logs;
				$log = $nfds_log->search(['log_date' => $date,
										  'nfds_id' => $this->nfds_id,
										  'employee_id' => $employee_id ]);
				$this->log = $log ? reset($log) : false;
			}
			return $this->log;
		}

	}

?>
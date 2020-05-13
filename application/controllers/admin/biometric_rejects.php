<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biometric_rejects extends MY_Controller {

	public function test()
	{
		echo "test ni";
	}
	public function log_attendance()
	{
		$this->load->model('checklog');
		$this->load->model('employee_log');

		$cl = new Checklog;

		$allLogs = $cl->get();
		foreach ($allLogs as $key => $value) {
			$employee = $value->employee();
			if ($employee) {
				$date = date('Y-m-d', strtotime($value->log_time));
				$sched = $employee->scheds($date);
				if ($sched) {
					$matched = $this->log_match($date, $value->logtype, $employee);
					if ($matched) {
						$hasLogged = $matched->log($employee->employee_id, $date);
						if (!$hasLogged) {

							$empLog  					= new Employee_log;
							$empLog->emp_log_sched_type = get_class($matched);
							$empLog->employee_id 		=  $employee->employee_id;
							$empLog->emp_log_sched_id   = $matched->{$matched::DB_TABLE_PK};
							$empLog->emp_log_date 		= $date;
							if ($value->logtype == "I") {
								$empLog->emp_log_in = $matched->{$matched::TIME_IN};
							}
							else{
								$empLog->emp_log_out = $matched->{$matched::TIME_OUT};
							}

							$empLog->save();
							echo "saved new<br>";

							}
					}
				}
			}
		}
	}	
	public function index()
	{
		$this->create_head_and_navi(array(
										asset_url("plugins/datatables/jquery.dataTables.min.js"),
										asset_url("plugins/datatables/dataTables.bootstrap.min.js"),
										asset_url("plugins/iCheck/icheck.min.js")
									 ),
								array(
										asset_url("plugins/datatables/dataTables.bootstrap.css"),
										asset_url("plugins/iCheck/all.css")
									 )
								);

		$bio = $this->load->view('admin/biometric_rejects/main', FALSE, TRUE);

		create_content(array('contentHeader' => 'Biometrics',
							 'breadCrumbs'	 => true,
							 'content'       => array($bio)
							)
					  );
	}
	public function bio_data_json()
	{
		
		$this->load->model('checklog');
		$cl = new Checklog;
		$startDate = $this->input->get('startDate');
		$endDate = $this->input->get('endDate');


		// $totalRec = $cl->db->query("select COUNT(log_time) as total from checklogs");

		// $totalRec = $totalRec->row_array();

		$totalRec = $cl->db->query("SELECT COUNT(log_time) as total FROM checklogs WHERE log_time BETWEEN '{$startDate}' AND '{$endDate}' ");
		$totalRec = $totalRec->row_array();
		$filteredRecs = $totalRec['total'];


		if ($this->input->get('search')['value'] != "" ) {
			$srchK = $this->input->get('search')['value'];
			if (is_numeric($this->input->get('search')['value'])) {

				$cls = $cl->search("badgenumber like '%{$srchK}%' AND log_time BETWEEN '{$startDate}' AND '{$endDate}' " , $this->input->get('length'), $this->input->get('start') );
				$filteredRecs = $cl->db->query("SELECT *, COUNT(log_time)  as total from checklogs where badgenumber like '%{$srchK}%' AND log_time BETWEEN '{$startDate}' AND '{$endDate}' " );
				$filteredRecs = $filteredRecs->row_array();
				$filteredRecs = $filteredRecs['total'];
			}
			else{
				$emp = new Employee;
				$empInfo = $emp->pop(" employee_fname like '%{$srchK}%' OR employee_mname like '%{$srchK}%' OR employee_lname like '%{$srchK}%' OR CONCAT(employee_fname, ' ', employee_mname,
									' ', employee_lname) like  '%{$srchK}%' OR CONCAT(employee_fname,' ', employee_lname) like '%{$srchK}%' OR CONCAT(employee_lname,' ', employee_fname) like  '%{$srchK}%'");

				if ($empInfo->employee_id != "") {
					$cls 		  = $cl->search("badgenumber =  {$empInfo->biometric_id} AND log_time BETWEEN '{$startDate}' AND '{$endDate}'" , $this->input->get('length'), $this->input->get('start') );
					$filteredRecs = $cl->db->query("SELECT *, COUNT(log_time) as total from checklogs where badgenumber =  {$empInfo->biometric_id} AND log_time BETWEEN '{$startDate}' AND '{$endDate}'");
					$filteredRecs = $filteredRecs->row_array();
					$filteredRecs = $filteredRecs['total'];
				}
				else{
					$cls = [];
					$filteredRecs = 0;
				}

			}

		}
		else{
			$cls = $cl->search("log_time BETWEEN '{$startDate}' AND '{$endDate}' ",$this->input->get('length'), $this->input->get('start') );

		}

		

		$data = [
					'draw' => $this->input->get('draw'),
					'data' => [],
					'recordsTotal' => $totalRec['total'],
					'recordsFiltered' => $filteredRecs,
					'start' => $this->input->get('start'),
					'length' => $this->input->get('length')
				];

		foreach ($cls as $key => $value) {
			$data['data'][] = [date('m/d/Y', strtotime($value->log_time)),
							 $value->employee() ? $value->employee()->fullName(): $value->badgenumber ,
							 $value->logtype == 'I' ? "Time in" : "Time out",
							 date('h:i a', strtotime($value->log_time))];	
		}

		echo json_encode($data);
	}
	public function log_match($date,$logType,$emp)
	{
		$schedOnDay = $emp->scheds($date);

		$times = [];
		$fromTime = date('H:i:s', strtotime($date));
		$from = strtotime($fromTime);


		foreach ($schedOnDay as $key => $value) {
			if ($logType == 'I') {
				if (get_class($value) == "Emp_irreg_sched") {
					$to = strtotime($value->emp_irreg_sched_time_in);
				}
				elseif (get_class($value) == "Eec_Nfds") {
					$to = strtotime($value->nfds_time_in);
				}
				elseif (get_class($value) == "Department_irregular_sched" ) {
					$toTime = date('H:i', strtotime($value->sched_from_date));
					$to = strtotime($toTime);
				}
				elseif (get_class($value) == "Depts_Def_Sched_Nfds") {
					$to = strtotime($value->nfds_time_in);
				}
			}else{
				if (get_class($value) == "Emp_irreg_sched") {
					$to = strtotime($value->emp_irreg_sched_time_out);
					
				}
				elseif (get_class($value) == "Eec_Nfds") {
					$to = strtotime($value->nfds_time_out);
				}
				elseif (get_class($value) == "Department_irregular_sched" ) {
					$toTime = date('H:i', strtotime($value->sched_to_date));
					$to = strtotime($toTime);
				}
				elseif (get_class($value) == "Depts_Def_Sched_Nfds") {
					$to = strtotime($value->nfds_time_out);
				}
			}

			$times[] = ['time' => $to,
						'obj' => $value];
		}

		$min = false;
		$minObj = false;

		foreach ($times as $key => $value) {
			$newMin = abs($from - $value['time']);

			if ($minObj) {
				if ($min > $newMin) {
					$min = $newMin;
					$minObj = $value['obj'];
				}

			}
			else{
				$minObj = $value['obj'];
				$min = $newMin;
			}
		}

		return $minObj;
	}

}

/* End of file biometric_rejects.php */
/* Location: ./application/controllers/admin/biometric_rejects.php */
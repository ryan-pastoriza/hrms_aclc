<?php
/**
 * @Author: khrey
 * @Date:   2015-09-24 09:04:34
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-14 10:38:41
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Biometrics extends MY_Controller {

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

		$bio = $this->load->view('admin/biometrics/main', FALSE, TRUE);

		create_content(array('contentHeader' => 'Biometrics',
							 'breadCrumbs'	 => true,
							 'content'       => array($bio)
							)
					  );
	}
	public function bio_list()
	{
		$this->load->model('employee');
		$emps = new Employee;
		$emps = $emps->get();
		echo json_encode($this->get_table_data($emps));
	}
	private function get_table_data($bio)
	{
		$toret = array();
		foreach ($bio as $key => $value) {
			$bid = $value->biometric_id != "" ? $value->biometric_id : "Not assigned";
			$bio_id = "<a href='#'' data-type='number' data-title='Assign Biometric ID'  data-pk='". $value->employee_id ."' class='editable editable-click'>{$bid}</a>";
			$toret['data'][] = array($value->fullName(),$bio_id);
		}
		return $toret;
	}
	public function assign_id()
	{
		$this->load->model('employee');
		$emp      = new Employee;
		$assigned = $emp->search(array('biometric_id' => $this->input->post('value')));
		$data = array();

		if ($assigned) {
			$data['success'] = false;
			$data['view'] = "Biometric ID {$this->input->post('value')} has already been assigned to another employee.";
		}else{
			$empNew = new Employee;
			$empNew->load($this->input->post('pk'));
			$empNew->biometric_id = $this->input->post('value');
			$empNew->save();
			$data['success'] = true;
		}
		echo json_encode($data);
	}
	public function upload_attendance()
	{
		set_time_limit(0);

		$toret = ['success' => true,
				'text' => "<span class='text-success'> Attendace Successfully Uploaded!</span>"];

		if ($_FILES['attlog']['type'] != "application/octet-stream") {
			$toret['success'] = false;
			$toret['text'] = "Invalid File";
		}
		else{
			$file = fopen($_FILES['attlog']['tmp_name'],"r");
			$attLogs = [];
			while ($line = fgetcsv($file,1000,"\t")) {
				$badgeNumber =  trim($line[0]);
				$dateTime 	 = $line[1];
				$logType 	 = $line[3];
				$attLogs[] = ['BADGENUMBER' => $badgeNumber,
							'STATE' => $logType == 1 ? "O" : "I",
							'CHECKTIME' => $dateTime];
			}

			$this->record_logs($attLogs);
		}

		echo json_encode($toret);
	}
	private function record_logs($logInfo = false)
	{
		$toret =array();
		$this->load->model('employee','empInfo');
		$this->load->model('nfds_logs','bioLog');
		$this->load->model('employee_log');

		foreach ($logInfo as $key => $value) {

			$empInfo      = @reset($this->empInfo->search(array("biometric_id" => $value['BADGENUMBER']) ));
 			if (!$empInfo) {
 				$this->saveLog($value['BADGENUMBER'],$value['CHECKTIME'],$value['STATE']);

 				$chData = array(
					'log_errors' => ['text' => "We could not identify your biometric ID no. {$value['BADGENUMBER']}.<br>Please contact the Human Resource Department regarding this matter.",
									'time' => $value['CHECKTIME']
													]
				);
				
				$this->session->set_userdata( $chData );
				$toret[] = array('unidentified' =>['text' => "We could not identify your biometric ID no. {$value['BADGENUMBER']}.<br>Please contact the Human Resource Department regarding this matter.",
													'time' => $value['CHECKTIME']
													]);
				continue;
			}

			$matched = $this->log_match($value['CHECKTIME'], $value['STATE'], $empInfo);

			if ($matched) {
				$date = date('Y-m-d', strtotime($value['CHECKTIME']));
				$hasLoggedOnSched = $this->logs_on_sched($empInfo->employee_id,$date,$matched);

				$theLog = $hasLoggedOnSched ? reset($hasLoggedOnSched) : false;


				if ($value['STATE'] == 'O' && $theLog) {
					$theLog->emp_log_out = date('H:i', strtotime($value['CHECKTIME']));
					$theLog->emp_log_update = date('Y-m-d H:i');
					$theLog->save();
				}
				elseif (!$hasLoggedOnSched) {
					$newLog = new Employee_log;
					$newLog->employee_id = $empInfo->employee_id;
					$newLog->emp_log_sched_type = get_class($matched);
					$newLog->emp_log_sched_id = $matched->{$matched::DB_TABLE_PK};
					$newLog->emp_log_date =date('Y-m-d', strtotime($value['CHECKTIME']));
					$newLog->emp_log_update = date('Y-m-d H:i');
					if ($value['STATE'] == 'O') {
						$newLog->emp_log_out = date('H:i', strtotime($value['CHECKTIME']));				
					}else{
						$newLog->emp_log_in = date('H:i', strtotime($value['CHECKTIME']));				
					}
					$newLog->save();

				}

			}
			else{
				$this->saveLog($value['BADGENUMBER'],$value['CHECKTIME'],$value['STATE']);

				$chData = array(
					'log_errors' => array('text' => "No Schedule Set for ".$empInfo->fullName('l, f m.')." today.",
											'time' => $value['CHECKTIME'])
				);
				
				$this->session->set_userdata( $chData );

				$toret[] = array('error' => ['text' => "No Schedule Set for ".$empInfo->fullName('l, f m.')." today.",
											'time' => $value['CHECKTIME']]);
			}

			
		}
		return $toret;
	}
	public function saveLog($badgenumber, $checktime, $state)
	{
		$this->load->model('checklog');
		$log 				= new Checklog;
		$log->badgenumber 	= $badgenumber;
		$log->log_time 		= date('Y-m-d H:i', strtotime($checktime));
		$log->logtype 		= $state;
		$log->save();
	}
	public function log_match($date,$logType,$empInfo)
	{
		$emp = new Employee;
		$emp->load_with_employment_info($empInfo->employee_id);
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

		$min   	= false;
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
	public function logs_on_sched($employee_id = false, $day = false, $schedObj = false)
	{
		$this->load->model('employee_log');	
		
		$empLog = new Employee_log;

		return $empLog->search([
								'employee_id'      => $employee_id,
								'emp_log_sched_id' => $schedObj->{$schedObj::DB_TABLE_PK},
								'emp_log_date'     => $day,
								'emp_log_sched_type' => get_class($schedObj)
								]);
	}
	public function logs_today($employee_id = false, $day = false)
	{
		$this->load->model('nfds_logs','bioLog');

		$this->bioLog->toJoin = ['non_flexi_daily_scheds' => 'nfds_logs'];

		if ($day) {
			return $this->bioLog->search(array('employee_id' => $employee_id, 'log_date' => date('Y-m-d',strtotime($day))));
		}
		return $this->bioLog->search(array('employee_id' => $employee_id, 'log_date' => date('Y-m-d')));
	}
}

/* End of file biometrics.php */
/* Location: ./application/controllers/admin/biometrics.php */
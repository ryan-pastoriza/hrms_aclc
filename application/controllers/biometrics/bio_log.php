<?php
/**
 * @Author: khrey
 * @Date:   2015-09-11 08:14:04
 * @Last Modified by:   Gian
 * @Last Modified time: 2019-11-18 11:43:47
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Bio_log extends MY_Controller {

	public function test(){
		$this->load->model('employee');
		$emp = new Employee;
		$emp->load_with_employment_info('BTN-2012-0213');
		$match = $this->log_match("2017-10-16 11:00:00","O",$emp);

		echo "<pre>";
		print_r ($match);
		echo "</pre>";

	}
	public function index()
	{
		$this->load->model('announcement');

		$data = array();
		$day  = date('l');
		$date = date('F d, Y');
		$time = date('g:i:s a');
		$dateNow = date('m-d');
		$dayToday = date('d');

		$announcements = new Announcement;


		$this->load->model('employee');

		$emps = new Employee;
		$emps->toJoin = ["employment" => "employee"];
		$emps->sqlQueries['order_field'] = 'DAY(employee_bday)';
		$emps->sqlQueries['order_type']  = 'asc';

		$date = date('Y-m-d');
		$data['announcements']  = $announcements->search("'{$date}' BETWEEN announcements.announcement_start AND announcements.announcement_end");
		$data['day'] 			= $day;
		$data['date'] 			= $date;
		$data['time'] 			= $time;
		$data['birthdays'] 		= $emps->search("MONTH(employees.employee_bday) = '".date('m')."' ");
		$data['recentLogs'] 	= $this->checkLog();

		$this->load->view('biometrics/header');
		$this->load->view('biometrics/home_log', $data);
		$att = $this->checkLog();
		$this->syncTime();
	}
	function syncTime(){
		// $config = ['ip' => "10.80.100.100", 
		$config = ['ip' => "192.168.1.201", 
					'port' => 4370];
		$this->load->library('zklib',$config);

		$ret = $this->zklib->connect();

			sleep(1);
			$date = new DateTime();
			$date->year = date('Y');
			$date->month = date('m');
			$date->day = date('d');
			$date->hour = date('H');
			$date->minute = date('i');
			$date->second = date('s');

	    	$this->zklib->setTime($date);
	    	sleep(1);
	        $this->zklib->enableDevice();
			$this->zklib->disconnect();     
	}
	public function checkLog()
	{
		//$config = ['ip' => "10.80.100.100", 
		$config = ['ip' => "192.168.1.201", 
					'port' => 4370];
		// $config = ['ip' 	=> "192.168.1.201", 
		// 			'port' 	=> 4370];
		$this->load->library('zklib',$config);

		$ret = $this->zklib->connect();

		sleep(1);

	    if ( $ret ){
	        // $this->zklib->disableDevice();
	        
	    	$attendance = $this->zklib->getAttendance();

	    	if (count($attendance) > 50) {

		    	$this->zklib->clearAttendance();	        
		        sleep(1);
		        // $this->zklib->enableDevice();
				$this->zklib->disconnect();

				return ['recovery' => true,
						'attendance' => $attendance];
	    	}
	    	$this->zklib->clearAttendance();	        
	        sleep(1);
	        // $this->zklib->enableDevice();
			$this->zklib->disconnect();
			$record = $this->record_log($attendance);
			// get recorded attendance

			$this->load->model('employee_log');

			$empLogs = new Employee_log;
			$empLogs->toJoin = array('employee' 	=> 'employee_log',
									 'employment' 	=> 'employee',
									 'department' 	=> 'employment');

			$empLogs->sqlQueries['order_field'] = 'emp_log_update';
			$empLogs->sqlQueries['order_type']  = 'desc';

			$recentLogs = $empLogs->search(['emp_log_date' => date('Y-m-d')],3);


			foreach ($recentLogs as $key => $value) {
				$value->logs_today = $value->logs_today();
			}

			$logs = array(
							'recentLogs'	=> $recentLogs,
	 					    'noIds' 	   	=> $record,
	 					    'recovery' 		=> false
	 					  );

			// get recorded attendance
		}
		else{
			echo "unable to connect to device";
		}

		return $logs;
	}
	public function record_from_recovery()
	{
		$att_data = json_decode($this->input->post('att_data'));
		$log_to_record = [['BADGENUMBER' => $att_data->BADGENUMBER,
							'STATE' => $att_data->STATE,
							'CHECKTIME' => $att_data->CHECKTIME]];
		$this->record_log($log_to_record);
		echo "Recording log data:<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Biometric ID: {$att_data->BADGENUMBER}<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; STATE: {$att_data->STATE}<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CHECKTIME: {$att_data->CHECKTIME}<br>
			  ";
	}
	public function monitor_log()
	{
		$this->load->model('announcement');
		$announcements = new Announcement;

		$logs = $this->checkLog();

		if ($logs['recovery']) {
			$views = $logs;
		}
		else{
			$data = array('recentLogs' => $logs);
			$date = date('Y-m-d');
			$data['announcements'] = $announcements->search("'{$date}' BETWEEN announcements.announcement_start AND announcements.announcement_end");

			$ann_view = false;
			if (count($data['announcements']) != $this->input->post('ann_count')) {
				$ann_view =  $this->load->view('biometrics/announcements', $data, TRUE);
			}

			$views = [
					  'monitoring' => $this->load->view('biometrics/log_monitor', $data, TRUE),
					  'log_history' => $this->load->view('biometrics/log_history', $data, TRUE),
					  'announcements' => $ann_view,
					  'new_ann_count' => count($data['announcements']),
					  'recovery' 	=> false
					];

		}
			echo json_encode($views);
		
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
	private function record_log($logInfo = false)
	{
		$toret =array();
		$this->load->model('employee','empInfo');
		$this->load->model('nfds_logs','bioLog');
		$this->load->model('employee_log');

		foreach ($logInfo as $key => $value) {

			$empInfo      = @reset($this->empInfo->search(array("biometric_id" => $value['BADGENUMBER']) ));
 			$this->saveLog($value['BADGENUMBER'],$value['CHECKTIME'],$value['STATE']);

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
	public function logs_today($employee_id = false, $day = false)
	{
		$this->load->model('nfds_logs','bioLog');

		$this->bioLog->toJoin = ['non_flexi_daily_scheds' => 'nfds_logs'];

		if ($day) {
			return $this->bioLog->search(array('employee_id' => $employee_id, 'log_date' => date('Y-m-d',strtotime($day))));
		}
		return $this->bioLog->search(array('employee_id' => $employee_id, 'log_date' => date('Y-m-d')));
	}
	public function show_logs()
	{
          $data['allLogs'] = $this->checkLog();
          $this->load->view('biometrics/home3',$data);
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
	public function announcements()
	{
	}

}
/* End of file bio_log.php */
/* Location: ./application/controllers/biometrics/bio_log.php */
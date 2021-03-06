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
	public function upload_attendance2()
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
	public function upload_attendance()
	{
		$bio_map = [
					"BTN-2014-0271" 	=> 15,
					"BTN-2016-0317" 	=> 86,
					"BTN-2015- 0314" 	=> 77,
					"BTN-2017-6703" 	=> 79,
					"BTN-2017-0366" 	=> 49,
					"BTN-2017-0367" 	=> 6,
					"BTN-2017-0387" 	=> 31,
					"BTN- 2010-0128" 	=> 9,
					"BTN-2016-0354" 	=> 34,
					"BTN-2016-0315" 	=> 23,
					"BTN-2012-0213" 	=> 54,
					"BTN-2016-0341" 	=> 16,
					"BTN-2015-0285" 	=> 14,
					"BTN-2016-0328" 	=> 11,
					"BTN-1998-0005" 	=> 4,
					"BTN-2016-0331" 	=> 91,
					"BTN-2016-0321" 	=> 88,
					"BTN-2016-0316" 	=> 65,
					"BTN-2012-0189" 	=> 53,
					"BTN-2017-0376" 	=> 41,
					"BTN-2014-147" 		=>  51,
					"BTN-2012-0184" 	=> 36,
					"BTN-2016-0359" 	=> 8,
					"BTN-2017-0378" 	=> 62,
					"BTN-2012-0173" 	=> 57,
					"BTN-2017-382" 		=> 12,
					"BTN-2016-0353" 	=> 35,
					"BTN-1997-0002" 	=> 43,
					"BTN-2016-0339" 	=> 44,
					"BTN-2014-0284" 	=> 21,
					"BTN-2016-0333" 	=> 24,
					"BNT-2016-0362" 	=> 73,
					"BTN-2016-0318" 	=> 7,
					"BTN-2017-0385" 	=> 94,
					"BTN-2017-0369" 	=> 48,
					"BTN-2013-0255" 	=> 33,
					"BTN-2013-0249" 	=> 46,
					"BTN-2012-0190" 	=> 45,
					"BTN-2017-0381" 	=> 26,
					"BTN-2016-0361" 	=> 83,
					"BTN-2016-0325" 	=> 69,
					"BTN-2011-0160" 	=> 52,
					"BTN-2017-0371" 	=> 81,
					"BTN-2016-0356" 	=> 64,
					"BTN-2013-0235" 	=> 58,
					"BTN-2006-0019" 	=> 105,
					// "BTN-2016-0363" 	=> "",
					"BTN-2017-393" 		=> 38,
					"BTN-2017-0386" 	=> 90,
					"BTN-2011-0172" 	=> 55,
					"BTn-2016-0355" 	=> 32,
					"BTN-2016-0326" 	=> 72,
					"BTN-2017-0368" 	=> 75,
					"BTN-2016-0329" 	=> 50,
					"BTN-2010-0142" 	=> 63,
					"BTN-2016-0320" 	=> 25,
					"BTN-2105-0310" 	=> 71,
					"BTN-2017-0388" 	=> 20,
					"BTN-2011-0162" 	=> 22,
					"BTN-2015-0298" 	=> 60,
					"BTN-2017-383" 		=> 13,
					"BTN-2015-0302" 	=> 47,
					"BTN-2018-0396" 	=> 67,
					"BTN-2012-0194" 	=> 66,
					"BTN-2017-0397" 	=> 82,
					"BTN-2013-0239" 	=> 87,
					"BTN-2011-0171" 	=> 27,
					"BTN-2017-392" 		=> 84,
					"BTN-2016-0335" 	=> 18,
					"BTN-2003-0010" 	=> 5,
					"BTN-2016-0340" 	=> 80,
					"BTN-2013-0216" 	=> 56,
					// "BTN-2014-0268" 	=> "",
					"BTN-2009-0061" 	=> 17,
					"BTN-2016-0322" 	=> 19,
					"BTN-2017-390" 		=> 30,
					"BTN -2017-384" 	=> 95,
					"BTN-2017-0377" 	=> 42,
					"BTN-1999-0008" 	=> 40,
					"BTN-2013-0241" 	=> 39,
					"BTN-2008-0058" 	=> 37,
					"BTN-2017-1371" 	=> 70,
					"BTN- 2012-0175" 	=> 3,
					"BTN-2015-0312" 	=> 68,
					"BTN-2018-03107"    => 107,
					"BTN-2018-03105" => 106,
					"BTN-2018-03106" => 108,
					"BTN-2018-03103" => 104,
					"BTN-2016-0344" => 85,
					"BTN-2018-0398" => 97,
					"BTN-2018-03100" => 99,
					// "Metante" => 96,
					// "Minerva" => "",
					"BTN-2018-03102" => 101,
					"BTN-2018-03104" => 98,
					"BTN-2018-0399" => 100,
					"BTN-2018-03101" => 102,
					// "Yap" => "",
				];
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
				$inMap = in_array($badgeNumber, $bio_map);
				if($inMap){
					$bio = new Employee;
					$theBio = $bio->pop(['biometric_id' => $bio_map[array_search($badgeNumber,$bio_map)]]);
					echo "employee: ". $theBio->fullName()."<br>";
					echo "fingerprint: ". $bio_map[array_search($badgeNumber,$bio_map)]."<br>";
					echo "face_recognition: ". $theBio->biometric_id ."<hr>";

					if($theBio->employee_id != ""){
						$badgeNumber = $theBio->biometric_id;
					}
				}
				echo "<pre>";
					print_r($line);
				echo "</pre>";

				// $dateTime 	 = $line[1];
				// $logType 	 = $line[3];
				// $attLogs[] = ['BADGENUMBER' => $badgeNumber,
				// 			'STATE' => $logType == 1 ? "O" : "I",
				// 			'CHECKTIME' => $dateTime];
			}

			// echo "Asdsad";
			// $this->record_logs($attLogs);
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
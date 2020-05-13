<?php
/**
 * @Author: khrey
 * @Date:   2015-10-01 10:13:24
 * @Last Modified by:   ryanpastoriza
 * @Last Modified time: 2020-01-14 13:44:56
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Daily_time_record extends MY_Controller {

	
	public function test($value='')
	{
		// BTN-2015-0302
		$emp = new Employee;
		$emp->load_with_employment_info('BTN- 2012-0175');
		$scheds = $emp->cal_scheds();

		echo "<pre>";
			print_r($scheds);
		echo "</pre>";
 

	}	
	public function set_eec()
	{
		$allEmps 	= new Employee;
		$all 		= $allEmps->get();
		$this->load->model('employee_est_classifications');

		foreach ($all as $key => $value) {
			$eec = new Employee_Est_Classifications;
			$hasClassification = $eec->search(['employee_id' => $value->employee_id]);

			if (!$hasClassification) {
				$neec = new Employee_Est_Classifications;
				$neec->est_id = 1;
				$neec->employee_id = $value->employee_id;
				$neec->save();
			}

		}
	}
	// public function test()
	// {
	// 	$this->load->model('event');
	// 	$event  = new Event;
	// 	$has_event	= $event->has_event_on("2018-03-29","2018-03-29");
	// 	echo "<pre>";
	// 	print_r($has_event);

	// }
	public function index()
	{
		// $report = $this->get_json_dtr('BTN-2012-0213','2016-05-03','2016-05-03');

		// echo "<pre>";
		// print_r($report);
		// echo "</pre>";

		$empData 	= $this->emp_json_data();
		$dtr 		= $this->load->view('admin/dtr',array('empData' => $empData), TRUE);
		$jscripts 	= $this->load->view('admin/Daily_Time_Record/Attendance/jscripts',false,TRUE);


		$this->create_head_and_navi([
										asset_url('plugins/daterangepicker/moment.min.js'),
										asset_url('plugins/daterangepicker/daterangepicker.js'),
										asset_url('plugins/datatables/jquery.dataTables.min.js'),
										asset_url('plugins/datatables/datatables.bootstrap.js'),
										asset_url('plugins/datatables/version1/datatableTools.min.js'),
										asset_url('plugins/datatables/version1/dataTables.buttons.min.js'),
										asset_url('plugins/datatables/version1/buttons.html5.min.js'),
										asset_url('plugins/datatables/version1/buttons.print.min.js'),
										asset_url('plugins/datatables/version1/jszip.min.js'),
										asset_url('plugins/datatables/version1/pdfmake.min.js'),
										asset_url('plugins/datatables/version1/vfs_fonts.js'),
									], 
									[
										asset_url('plugins/datatables/version1/buttons.dataTables.min.css'),
										asset_url('plugins/datatables/version1/dataTables.bootstrap.css'),
									]);
		
		create_content(['contentHeader' => 'Daily Time Record', 'content' => $dtr]);
		$this->create_footer([$jscripts]);
	}
	public function data_table_dtr($empID = false, $fromDate= false, $toDate = false)
	{
		$this->load->model('employee','emps');

		$fromDate = date("Y-m-d",strtotime($this->input->post('startDate')));
		$toDate   = date("Y-m-d",strtotime($this->input->post('endDate')));
		$empID    = $this->input->post('empID');
		$allEmps  = $this->emps->get();

		// $generate =  $this->funcs->search_in_array($allEmps,'employee_id',$empID);

		$data = array();
		if ($empID == "") {
			$data['data'] = array();
			echo json_encode($data);
			return true;
		}

		$data['data'] = $this->get_json_dtr($empID,$fromDate,$toDate);

		echo json_encode($data);
	}
	public function dtr_header($emp_id = false, $fromDate = false, $toDate = false)
	{

		$emp_id 	= $this->input->post('employee_id') ? $this->input->post('employee_id') : $emp_id;
		$fromDate 	= $this->input->post('fromDate') ? $this->input->post('fromDate') : $fromDate;
		$toDate 	= $this->input->post('toDate') ? $this->input->post('toDate') : $toDate;

		$emp = new Employee;
		$emp->load_with_employment_info($emp_id);
		$prep = $this->prep_header($emp,$fromDate, $toDate);


		$data = ['emp' 	 	=> $emp,
				'headings' 	=> $prep['headings'],
				'overtime' 	=> $prep['overtime']];


		echo $this->load->view('admin/Daily_Time_Record/Attendance/dtr_header', $data, TRUE);
		$this->get_json_dtr($data['headings'], $emp_id, $fromDate, $toDate);
	}
	public function prep_header($emp = false, $fromDate = false, $toDate = false)
	{
		$dates = $this->funcs->datesInArray($fromDate,$toDate);
		
		$headings = [];
		$overtime = [];
		foreach ($dates as $key => $value) {
			$schedOnDate = $emp->scheds($value->format('Y-m-d'));
			$ot_on_dates = $emp->overtime($value->format('Y-m-d'));
			foreach ($schedOnDate as $key2 => $value2) {
				$in = date("H:i", strtotime($value2->{$value2::TIME_IN}));
				$out = date('H:i', strtotime($value2->{$value2::TIME_OUT}));
				$head = $in." - ".$out ;

				if (!in_array($head,$headings)) {
					$headings[] = $head;
				}

			}
			foreach ($ot_on_dates as $key2 => $value2) {
				$in = date("h:i a", strtotime($value2->emp_ot_from));
				$out = date("h:i a", strtotime($value2->emp_ot_to));
				$head = "<b>OVERTIME</b><br> {$in} - {$out}";

				if (!in_array($head, $headings)) {
					$overtime[] = ['heading' => $head,
									'obj' => $value2];
				}

			}

		}
		asort($headings);
		return ['headings' => $headings,
				'overtime' => $overtime];
	}
	public function  get_json_dtr2($emp_id,$fromDate = false, $toDate = false)
	{
		$this->load->model('nfds_logs');
		$this->load->model('attendance_rule');
		$this->load->model('employee');
		$this->load->model('non_flexi_daily_scheds');

		$fromDate = date("Y-m-d",strtotime($fromDate));
		$toDate   = date("Y-m-d",strtotime($toDate));


		$allLogs      = new Nfds_Logs;
		$logs         = $allLogs->by_dates($fromDate, $toDate, $emp_id);
		$log_dtr      = array();
		$final_report = array();
		$allTime      = $this->funcs->datesInArray($fromDate,$toDate);
		$attRule      = new Attendance_rule;
		$attRule 	  = $attRule->get();
		$theRule      = reset($attRule);
		$maxLateRule  = $theRule->late_hr_max.":".$theRule->late_min_max;
		$maxUtRule	  = $theRule->ut_hr_max.":".$theRule->late_min_max;
		$empInfo 	  = new Employee;
		$empInfo->load($emp_id);

		// loop through logs
		foreach ($logs as $key => $value) {
			$dataForDtr   = array();
			$amIn         = "";
			$pmIn         = "";
			$amOut        = "";
			$pmOut        = "";
			$lateMins     = 0;
			$lateHrs      = 0;
			$totalLateMins 	= 0;
			$totalLateHrs 	= 0;
			$totalUTHrs 	= 0;
			$totalUTMins 	= 0;

			$dataForDtr['date'] = $key;

			foreach ($value as $logDate => $logObject) {

				$current_late 	= 0;
				$byRule		 	= $this->check_rule($logObject);
				$schedShift 	= date('a',strtotime($logObject->nfds_time_in));
				$lates      	= $this->funcs->time_interval($logObject->log_date." ".$logObject->log_in,$logObject->log_date." ".$logObject->nfds_time_in);
				$uts  			= $this->funcs->time_interval($logObject->log_date." ".$logObject->nfds_time_out, $logObject->log_date." ".$logObject->log_out);

				// calculate total late
				if ($lates->invert && $logObject->log_in != "") {
					$lateMins += $lates->i;
					$lateHrs  += $lates->h;
					$totalLateMins += $lates->i;
					$totalLateHrs += $lates->h;
				}
				// calculate total undertime
				if ($uts->invert && $logObject->log_out != "") {

					$lateMins += $uts->i;
					$lateHrs += $uts->h;
					$totalUTHrs += $uts->h;
					$totalUTMins += $uts->i;
				}

				$dataForDtr['scheds'][] = $logObject;
					// switch if log is morning or afternoon
					switch ($schedShift) {
						case 'am':
								// check if not absent by company rule 
								if (!$byRule) {
									// set log in/out as NO LOG if empty
									$amIn 	= $logObject->log_in 	!= "" ? date("h:i a",strtotime($logObject->log_in)) 	: "NO LOG";
									$amOut 	= $logObject->log_out 	!= "" ? date("h:i a", strtotime($logObject->log_out)) 	: "NO LOG";
								}
								else{
									// if absent by rule, am in/out shall be array
									$amIn 	= array('time' => $logObject->log_in, 'txt' 	=> $byRule);
									$amOut 	= array('time' => $logObject->log_out, 'txt' 	=> $byRule);
								}
							break;
							// this is if the log is pm
						default:
								// check if not absent by company rule
								if (!$byRule) {
									// set log in/out as NO LOG if empty
									$pmIn 	= $logObject->log_in != "" ? date("h:i a",strtotime($logObject->log_in)) : "NO LOG";
									$pmOut 	= $logObject->log_out != "" ? date("h:i a", strtotime($logObject->log_out)) : "NO LOG";
								}
								else{
									// if absent by rule, pm in/out shall be array
									$pmIn 	= array('time' => $logObject->log_in, 'txt' 	=> $byRule);
									$pmOut 	= array('time' => $logObject->log_out, 'txt' 	=> $byRule);
								}
							break;
					}
			}

			// converting late minutes to actual hrs
			$lateMinsToHrs = $totalLateMins / 60;
			$totalLateHrs 	+= floor($lateMinsToHrs);
			$totalLateMins 	-= floor($lateMinsToHrs);

			// converting UT minutes to actual hrs
			$utMinsToHrs = $totalUTMins / 60;
			$totalUTHrs += floor($utMinsToHrs);
			$totalUTMins -= floor($utMinsToHrs);

			// consolidating lates and undertime as underwork
			$totalUWHrs = $totalLateHrs + $totalUTHrs;
			$totalUWMins = $totalLateMins + $totalUTMins;
			$UWMinsToHrs = $totalUWHrs / 60;
			$totalUWHrs += floor($UWMinsToHrs);
			$totalUWMins -= floor($UWMinsToHrs);


			$dataForDtr['late'] 		= $totalLateHrs.":".$totalLateMins;
			$dataForDtr['undertime'] 	= "{$totalUTHrs}:{$totalUTMins}";
			$dataForDtr['underwork'] 	=  array('hrs' => $totalUWHrs, 'mins' => $totalUWMins);
			$dataForDtr['am_in'] 		=  $amIn;
			$dataForDtr['am_out'] 		=  $amOut;
			$dataForDtr['pm_in'] 		= 	$pmIn;
			$dataForDtr['pm_out'] 		= 	$pmOut;

			$log_dtr[] = $dataForDtr;
		}
		// loop through dates to order accordingly
		foreach ($allTime as $key => $value) {

			$tod        = $value->format('Y-m-d');
			$empSched   = $this->funcs->search_in_array($empInfo->scheds(),'nfds_day',strtolower(date('D', strtotime($tod))));
			$schedCount = count($empSched);
			$hasLogHere = $this->funcs->search_in_array($log_dtr, 'date', $tod);

			$am_in 		= "";
			$am_out 	= "";
			$pm_in 		= "";
			$pm_out 	= "";
			$schedSpan 	= false;
			$ut_hrs 	= "";
			$ut_mins 	= "";
			$late 		= "";
			$udt 		= "";
			$day_total 	= "";

			// if day is sunday or saturday
			if (strtolower(date('D', strtotime($tod))) == 'sun') {
				$ut_mins = "<span class='red-text'>SUN</span>";
			}
			elseif(strtolower(date('D', strtotime($tod))) == 'sat'){
				$ut_mins = "<span>SAT</span>";
			}

			// loop through schedule and add the total hours an employee should work
			foreach ($empSched as $key2 => $schedObj) {
				$currSpan 				= $this->funcs->time_interval($schedObj->nfds_time_in,$schedObj->nfds_time_out);
				// $schedObj->schedPart 	= date('a', strtotime($schedObj->nfds_time_in));

				// the goal is to get the span of every schedule and add it all up in a day to calculate the total hours an employee is supposed to work
				if ($schedSpan) {
					$newSpan 	= new DateTime("00:00");
					$e 			= clone $newSpan;

					$newSpan->add($currSpan);
					$newSpan->add($schedSpan);
					$schedSpan = $e->diff($newSpan);

					continue;
				}

				$schedSpan = $currSpan;
			}

			// check if employee has logged <- from the loop through logs
			if ($hasLogHere) {
				$theLog 	= reset($hasLogHere);
				$late 		= $theLog['late'];
				$udt 		= $theLog['undertime'];
				$am_in 		= $theLog['am_in'];
				$am_out 	= $theLog['am_out'];
				$pm_in  	= $theLog['pm_in'];
				$pm_out 	= $theLog['pm_out'];
				$underHrs 	= intval($theLog['underwork']['hrs']);
				$underMins 	= intval($theLog['underwork']['mins']);
				$extractMins = $underMins / 60;

				if ( is_array($theLog['am_in'])) {
					$am_in 	= $theLog['am_in']['txt'];
					// $am_out = "NO LOG";
				}
				if (is_array($theLog['pm_in'])) {
					$pm_in = $theLog['pm_in']['txt'];
					// $pm_out = "NO LOG";
				}

				// check if all the logs are complete and valid
				if ($theLog['am_in'] != "NO LOG" && $theLog['am_out'] != "NO LOG") {
					$amIn 	= $theLog['am_in'];
					$amOut 	= $theLog['am_out'];


					// even if it is an array which means the log is considered absent due to company rules, put the total hours worked 
					if (is_array($theLog['am_in'])) {
						$amIn = $theLog['am_in']['time'];
					}
					if (is_array($theLog['am_out'])) {
						$amOut = $theLog['am_out']['time'];
					}
					// put in daily total hours worked
					$day_total = $this->funcs->time_interval($amIn,$amOut);
					$day_total = date('H:i',strtotime($day_total->h.":".$day_total->i));
					// end
				}
				if ($theLog['pm_in'] != "NO LOG" && $theLog['pm_out'] != "NO LOG") {
					$pmIn 	= $theLog['pm_in'];
					$pmOut 	= $theLog['pm_out'];


					// even if it is an array which means the log is considered absent due to company rules, put the total hours worked 
					if (is_array($theLog['pm_in'])) {
						$pmIn = $theLog['pm_in']['time'];
					}
					if (is_array($theLog['pm_out'])) {
						$pmOut = $theLog['pm_out']['time'];
					}

					$pmSpan = $this->funcs->time_interval($pmIn,$pmOut);
					$totalSplit = explode(":",$day_total);

					// check if daily total has value; from am in and out
					// add to daily value

					if (isset($totalSplit[1])) {

						$totalMins = intval($totalSplit[1]) + $pmSpan->i;
						$totalHrs  = $totalSplit[0] + $pmSpan->h /*+ ((($totalMins / 60) - floor($totalMins / 60)) * 60) */;

						// $totalMins = floor($totalMins / 60);
						$day_total = date('H:i',strtotime ($totalHrs.":".$totalMins));
					}
					// end

				}
				$underHrs = floor($extractMins);
				if ( $extractMins >= 0) {
					$underMins = round(($extractMins- $underHrs) * 60);
				}
				$ut = new DateTime("{$underHrs}:{$underMins}");
				if ($schedSpan) {
					$ut->sub($schedSpan);

					$ut_hrs =  $ut->format('H');
					$ut_mins =  $ut->format('i');
				}
			}
			// check if employee has schedule
			if ($schedCount > 0) {
				$absentTxt = "<span class='text-red'>ABSENT</span>";

				if ($am_in == "" && $am_out == "") {

					// check if naay leave
					$schedAm = $this->funcs->search_in_array($empSched,'schedPart','am');
					$schedAm = reset($schedAm);

					if ($schedAm) {
						$hasLeave = $empInfo->has_leave_on_sched(date('Y-m-d', strtotime($tod)), $schedAm->nfds_id );
						if ($hasLeave) {
							$am_out = "<span class='text-green'>ON {$hasLeave->emp_leave_availment}</span>";
						}
					// end of leave checking
						else{
							$am_out = "ABSENT";
						}
					}

				}
				// if incomplete logs
				elseif ($am_in == "") {
					$schedAm = $this->funcs->search_in_array($empSched,'schedPart','am');
					if ($schedAm) {

						$schedAm = reset($schedAm);

						$hasFLR = $empInfo->has_fail_log($tod, $schedAm->nfds_id, "in");
						
						if ($hasFLR) {
							$am_in = date('H:i', strtotime($hasFLR->emp_lfr_log_in));
						}
					}
				}
				elseif ($am_out == "") {
					$schedAm = $this->funcs->search_in_array($empSched,'schedPart','am');
					if ($schedAm) {
						$schedAm = reset($schedAm);


						$hasFLR = $empInfo->has_fail_log($tod, $schedAm->nfds_id, "out");
						
						if ($hasFLR) {
							$am_out = date('H:i', strtotime($hasFLR->emp_lfr_log_out));
						}
					}
				}
				// end incomplete logs
				elseif (is_array($am_in)) {
				// array if am in is considered absent by rules
					$theAm = $am_in;
					$am_in = $theAm['time'];
					$am_out = $absentTxt;
				}
				elseif (is_array($am_out)) {
				// array if am out is considered absent by rules
					$am_out = $absentTxt;
				}

				if ($pm_in == "" && $pm_out == "") {
					// check if naay leave
					$schedPm = $this->funcs->search_in_array($empSched,'schedPart','pm');
					$schedPm = reset($schedPm);

					if ($schedPm) {
						$hasLeave = $empInfo->has_leave_on_sched(date('Y-m-d', strtotime($tod)), $schedPm->nfds_id );
						if ($hasLeave) {
							$pm_out = "<span class='text-green'>ON {$hasLeave->emp_leave_availment}</span>";
						}
					// end of leave checking
						else{
							$pm_out = "ABSENT";
						}
					}

				}
				elseif ($pm_in == "") {
					$schedPm = $this->funcs->search_in_array($empSched,'schedPart','pm');
					if ($schedPm) {
						$schedPm = reset($schedPm);

						$hasFLR = $empInfo->has_fail_log($tod, $schedPm->nfds_id, "in");

						if ($hasFLR) {
							$pm_out = date('H:i', strtotime($hasFLR->emp_lfr_log_in)) ;
						}
					}
				}
				elseif($pm_out == ""){

					$schedPm = $this->funcs->search_in_array($empSched,'schedPart','pm');
					if ($schedPm) {
						$schedPm = reset($schedPm);

						$hasFLR = $empInfo->has_fail_log($tod, $schedPm->nfds_id, "out");
						if ($hasFLR) {
							$pm_out =date('H:i', strtotime($hasFLR->emp_lfr_log_out)) ;
						}
					}
				}
				elseif (is_array($pm_in)) {
					$thePm = $pm_in;
					$pm_in = $thePm['time'];
					$pm_out = $absentTxt;
				}
				elseif (is_array($pm_out)) {
					$pm_out = $absentTxt;
				}
			}

			$final_report[] = array( 
									date('M d', strtotime($tod)),
									$am_in,
									$am_out,
									$pm_in,
									$pm_out,
									$late,
									$udt,
									"",
									"",
									$day_total
									);
		}
		return $final_report;
	}
	public function get_json_dtr($headings = false, $emp_id = false, $fromDate = false, $toDate = false)
	{

		$allTime = $this->funcs->datesInArray($fromDate,$toDate);
		$emp = new Employee;
		$emp->load_with_employment_info($emp_id);

		$data = ['dateArray' => $allTime,
				'emp'  		 => $emp,
				'headings' 	 => $headings];

		echo $this->load->view('admin/Daily_Time_Record/Attendance/dtr_body', $data, TRUE);
	}
	public function clear_log()
	{
		$this->load->model('employee_log');

		$empLog = new Employee_log;
		$empLog->load($this->input->post('log_id'));
		$empLog->{$this->input->post('log_type')} = null;

		$deleted = false;

		if ($this->input->post('log_type') == 'emp_log_in') {
			if ($empLog->emp_log_out == "") {
				$empLog->delete();
				$deleted = true;
			}
		}
		else{
			if ($empLog->emp_log_in == "") {
				$empLog->delete();
				$deleted = true;
			}
		}
		if (!$deleted) {
			$empLog->save();
		}


		// $this->load->model('nfds_logs');
		// $nfds_logs = new Nfds_Logs;

		// $nfds_logs->load($this->input->post('log_id'));
		// $nfds_logs->{$this->input->post('log_type')} = null;
		// $deleted = false;


		// if ($this->input->post('log_type') == 'log_in') {
		// 	if ($nfds_logs->log_out == "") {
		// 		$nfds_logs->delete();
		// 		$deleted = true;
		// 	}
		// }else{
		// 	if ($nfds_logs->log_in == "") {
		// 		$nfds_logs->delete();
		// 		$deleted = true;
		// 	}
		// }
		// if (!$deleted) {
		// 	$nfds_logs->save();
		// }
	}
	public function set_log()
	{
		$this->load->model('employee_log');

		$empLog = new Employee_log;
		if ($this->input->post('has_log') == "yes") {
			$empLog->load($this->input->post('pk'));
		}
		else{
			$empLog->employee_id = $this->input->post('employee_id');
			$empLog->emp_log_sched_type = $this->input->post('emp_log_sched_type');
			$empLog->emp_log_sched_id = $this->input->post('pk');
			$empLog->emp_log_date = $this->input->post('date');

		}

		$empLog->{$this->input->post('name')} = $this->input->post('value');
		$empLog->save();
	}
	public function emp_json_data()
	{
		$this->load->model('employee','emps');
		$this->emps->toJoin = array('employment' => 'employee',
									'department' => 'employment');

		$allEmps = $this->emps->get();
		$json = array();
		$count = 0;
		foreach ($allEmps as $key => $value) {
			$count++;
			$dataArray = array(	"empId" => $value->employee_id,
								"fullName" => $value->fullName('l, f m.'),
								'department' => $value->department_name,
								"number" => $count );
			$json[] = $dataArray;
		}
		return json_encode($json);		
	}
	public function clear_ot_log()
	{
		$this->load->model('emp_overtime');

		$this->emp_overtime->load($this->input->post('ot_id'));

		if($this->input->post('log_type') == "in"){
			$this->emp_overtime->emp_ot_work_shift_in = null;
		}
		else{
			$this->emp_overtime->emp_ot_work_shift_out = null;
		}

		$this->emp_overtime->save();
	}
	public function set_ot_log()
	{

		$this->load->model('emp_overtime');
		$eot = $this->emp_overtime;
		$eot->load($this->input->post('emp_ot_id'));

		if ($this->input->post('log_type') == 'in') {
			$eot->emp_ot_work_shift_in = $this->input->post('value');
		}
		else{
			$eot->emp_ot_work_shift_out = $this->input->post('value');
		}

		$eot->save();
	}

}

/* End of file daily_time_record.php */
/* Location: ./application/controllers/admin/daily_time_record.php */
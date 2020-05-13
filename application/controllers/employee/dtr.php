<?php
/**
 * @Author: gian
 * @Date:   2016-07-11 15:12:00
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 09:43:04
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Dtr extends MY_Controller{
	
	public function index(){
		$empData 	= $this->emp_json_data();
		$dtr 		= $this->load->view('admin/Daily_Time_Record/Attendance/dtr',array('empData' => $empData), TRUE);
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

		$this->create_footer();
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
	
	// log failure widget

	public function absence_bar(){
		$data = array();
		$data["month"] = array("January",
					  "February",
					  "March",
					  "April",
					  "May",
					  "June",
					  "July",
					  "August",
					  "September",
					  "October",
					  "November",
					  "December"
					 );

		$absentPerMonth = array();
		
		foreach ($data["month"] as $key => $value) {
			$absences = $this->get_json_dtr($this->userInfo->employee_id, $value ." 1, ". date("Y"), date("F t, Y",strtotime($value ." ". date("Y"))));
			foreach ($absences as $key2 => $value2) {
				foreach ($value2 as $key3 => $value3) {
					if(($key3 == 2 || $key3 == 4 ) && $value3 == "ABSENT"){
						if(isset($absentPerMonth[$value])){
							$absentPerMonth[$value] +=  0.5;
						}else{
							$absentPerMonth[$value] = 0.5;
						}
					}
				}
			}
		}
		$barData = array();

		foreach ($absentPerMonth as $key => $value) {
			$mm = date("M",strtotime($key." 1, 2016"));
			$barData[] = [
									"y" => $mm,
									"a" => $value
								 ];
		}
		echo json_encode($barData);
	}

	
	public function  get_json_dtr($emp_id,$fromDate = false, $toDate = false)
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

			$dataForDtr['date'] = $key;

			foreach ($value as $logDate => $logObject) {

				$current_late 	= 0;
				$byRule		 	= $this->check_rule($logObject);
				$schedShift 	= date('a',strtotime($logObject->nfds_time_in));
				$lates      	= $this->funcs->time_interval($logObject->log_in,$logObject->nfds_time_in);
				$uts  			= $this->funcs->time_interval($logObject->nfds_time_out,$logObject->log_out);
				
				if ($lates->invert) {
					$lateMins += $lates->i;
					$lateHrs  += $lates->h;
				}
				if (!$uts->invert) {
					$lateMins += $uts->i;
					$lateHrs += $uts->h;
				}

				$dataForDtr['scheds'][] = $logObject;
					switch ($schedShift) {
						case 'am':
								$amIn 	= !$byRule ? $logObject->log_in : array('time' => $logObject->log_in, 'txt' 	=> $byRule);
								$amOut 	= !$byRule ? $logObject->log_out : array('time' => $logObject->log_out, 'txt' 	=> $byRule);
							break;
						default:
								$pmIn 	=  !$byRule ? $logObject->log_in   : array('time' => $logObject->log_in, 'txt' 	=> $byRule);
								$pmOut 	= !$byRule ?  $logObject->log_out : array('time' => $logObject->log_in, 'txt' 	=> $byRule);
							break;
					}
			}
			$dataForDtr['late'] 		= $lates;
			$dataForDtr['undertime'] 	= $uts;
			$dataForDtr['underwork'] 	= array('hrs' => $lateHrs, 'mins' => $lateMins);
			$dataForDtr['am_in'] 		= !is_array($amIn) && $amIn != "" ? $amIn: $amIn;
			$dataForDtr['am_out'] 		= !is_array($amOut) && $amOut !=  ""  ? $amOut: $amOut;
			$dataForDtr['pm_in'] 		= !is_array($pmIn) && $pmIn !=  ""  ? $pmIn: $pmIn;
			$dataForDtr['pm_out'] 		= !is_array($pmOut) &&  $pmOut != "" ? $pmOut: $pmOut;

			$log_dtr[] = $dataForDtr;
		}
		foreach ($allTime as $key => $value) {;

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

			if (date('D', strtotime($tod)) == 'Sun') {
				$ut_mins = "<span class='red-text'>SUN</span>";
			}
			elseif(date('D', strtotime($tod)) == 'sat'){
				$ut_mins = "<span>SAT</span>";
			}

			foreach ($empSched as $key2 => $schedObj) {
				$currSpan = $this->funcs->time_interval($schedObj->nfds_time_in,$schedObj->nfds_time_out);
				$schedObj->schedPart = date('a', strtotime($schedObj->nfds_time_in));
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
			// check if employee has logged
			if ($hasLogHere) {
				$theLog 	= reset($hasLogHere);
				$late 		= $theLog['late']->invert ? date('h:i',strtotime($theLog['late']->h.":".$theLog['late']->i)) : "00:00";
				$udt 		= $theLog['undertime']->invert ? date('h:i',strtotime($theLog['undertime']->h.":".$theLog['late']->i)) : "00:00";
				$am_in 		= $theLog['am_in'];
				$am_out 	= $theLog['am_out'];
				$pm_in  	= $theLog['pm_in'];
				$pm_out 	= $theLog['pm_out'];
				$underHrs 	= intval($theLog['underwork']['hrs']);
				$underMins 	= intval($theLog['underwork']['mins']);
				$extractMins = $underMins / 60;

				if ($theLog['am_in'] != "" && $theLog['am_out'] != "") {
					$amIn = $theLog['am_in'];
					$amOut = $theLog['am_out'];
					if (is_array($theLog['am_in'])) {
						$amIn = $theLog['am_in']['time'];
					}
					if (is_array($theLog['am_out'])) {
						$amOut = $theLog['am_out']['time'];
					}
					// put in daily total
					$day_total = $this->funcs->time_interval($amIn,$amOut);
					$day_total = date('H:i',strtotime($day_total->h.":".$day_total->i));
					// end
				}
				if ($theLog['pm_in'] != "" && $theLog['pm_out'] != "") {
					$pmIn = $theLog['pm_in'];
					$pmOut = $theLog['pm_out'];
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
				$ut->sub($schedSpan);

				$ut_hrs =  $ut->format('H');
				$ut_mins =  $ut->format('i');
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
							$am_in = date('H:i', strtotime($hasFLR->emp_lfr_login));
						}
					}
				}
				elseif ($am_out == "") {
					$schedAm = $this->funcs->search_in_array($empSched,'schedPart','am');
					if ($schedAm) {
						$schedAm = reset($schedAm);


						$hasFLR = $empInfo->has_fail_log($tod, $schedAm->nfds_id, "out");
						
						if ($hasFLR) {
							$am_out = date('H:i', strtotime($hasFLR->emp_lfr_logout));
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
							$pm_out = date('H:i', strtotime($hasFLR->emp_lfr_login)) ;
						}
					}
				}
				elseif($pm_out == ""){

					$schedPm = $this->funcs->search_in_array($empSched,'schedPart','pm');
					if ($schedPm) {
						$schedPm = reset($schedPm);

						$hasFLR = $empInfo->has_fail_log($tod, $schedPm->nfds_id, "out");
						if ($hasFLR) {
							$pm_out =date('H:i', strtotime($hasFLR->emp_lfr_logout)) ;
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
}

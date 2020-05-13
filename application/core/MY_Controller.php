<?php
/**
 * @Author: Gian
 * @Date:   2015-06-26 11:55:18
 * @Last Modified by:   ryanpastoriza
 * @Last Modified time: 2020-01-15 16:24:40
 *//**
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $userInfo;

	public function __construct()
	{
		parent::__construct();
		$sec = new Securitys;
		$sec->redirect_user();
		$this->userInfo = $sec->whose_logged();

	}
	public function create_head_and_navi($plugins = array(), $addStyles = array()){

		$addStyles[] = asset_url("plugins/tautocomplete/tautocomplete.css");
		$addStyles[] = asset_url("bootstrap-editable/css/bootstrap-editable.css");
		$addStyles[] = asset_url("plugins/timepicker/bootstrap-timepicker.min.css");
		$addStyles[] = asset_url("plugins/bootstrap-gritter/jquery.gritter.min.css");
		$addStyles[] = asset_url("plugins/iCheck/all.css");
		$addStyles[] = asset_url("plugins/toast/toastr.css");

		$plugins[] = asset_url("plugins/tautocomplete/tautocomplete.js");
		$plugins[] = asset_url("plugins/jquery.form.min.js");
		$plugins[] = asset_url("bootstrap-editable/js/bootstrap-editable.min.js");
		$plugins[] = asset_url("plugins/timepicker/bootstrap-timepicker.min.js");
		$plugins[] = asset_url("plugins/bootstrap-gritter/jquery.gritter.min.js");
		$plugins[] = asset_url("plugins/daterangepicker/moment.min.js");
		$plugins[] = asset_url("plugins/daterangepicker/daterangepicker.js");
		$plugins[] = asset_url("plugins/datatable_date_filter/daterangefilterinj.js");
		$plugins[] = asset_url("ianjay.js");
		$plugins[] = asset_url("plugins/toast/toastr.min.js");

		$dataNotification = array('cash_advance' => $this->notifications_cash_advance(),
								  'leave'		 => $this->notifications_leave(),
								  'loan'		 => $this->notifications_loan(),
								  'update_rqst'  => $this->notifications_update_request(), );

		if ($this->uri->segment(1) == "admin") {
			
			set_header_title("HRMS");
			set_site_name("AdminHRMS");


			$navigationVars = array();
			$navigationVars['userPanel'] = array('userName' 	=> $this->userInfo->fullName('f m. l'),
												'userInfo' 		=> "ENGTECH",
												'userImage' 	=> file_exists($userImg = base_url('images/users'.$this->userInfo->employee_id)) ? $userImg : $userImg = base_url('images/no-image.fw.png'));

			$navigationVars['searchBar'] = false;
			$navigationVars['options'] 	 = array('Dashboard' 		=> array('icon'=> 'fa fa-dashboard text-blue', 
																			 'link' => base_url('index.php/admin/home')
																			),
											  	 'Employees' 		=> array('icon' => 'fa fa-users', 
											  	 							 'link' => array('New' => base_url('index.php/admin/personnel_information'),
											  	 							 				 '201' => base_url('index.php/admin/employees'),
											  	 							 				 'PAF' => base_url('index.php/admin/personnel_action_form'),
											  	 							 				 'User Accounts' => base_url('index.php/admin/user_accounts')
											  	 							 				)
											  	 							),
											  	 'Departments'		=> array('icon' => 'fa fa-building',
											  	 							 'link' => base_url('index.php/admin/departments')
											  	 							),
											  	 'Biometrics'		=> array('icon' => 'fa fa-thumbs-up',
											  	 							 'link' => ['Biometric Accounts' => base_url('index.php/admin/biometrics'),
											  	 							 			 'Biometric Rejected Data' => base_url('index.php/admin/biometric_rejects')]
											  	 							),
											  	 'Schedule'		=> array('icon' => 'fa fa-calendar',
											  	 							 'link' => [
											  	 							 			'Department Schedule' => base_url('index.php/admin/department_schedule'),
											  	 							 			'Employee Schedule' => base_url('index.php/admin/employee_schedule'),
											  	 							 			],
											  	 							),
											  	  'Overtime'		=> array('icon' => 'fa fa-clock-o',
											  	 							 'link' => base_url('index.php/admin/overtime')
											  	 							),
											  	 'Daily Time Records'	
											  	 /*DTR*/			=> array('icon' => 'fa fa-clock-o',
											  	 							 'link' => array('Attendance' 	  => base_url('index.php/admin/daily_time_record'),
											  	 							 				 'Failure to Log' => base_url('index.php/admin/failure_to_log')
											  	 							 				)
											  	 							),
											  	 'Leave' => array('icon' => 'fa fa-user-times','link' => base_url('index.php/admin/leave')),
												 'Calendar'			=> array('icon' => 'fa fa-calendar',
												 							 'link'	=> base_url('index.php/admin/my_calendar')
												 							),
												 'Payroll' => array('icon' => 'fa fa-file-text', 'link' => base_url('index.php/admin/payroll')),
												 'Loans and Advances' => array('icon' => 'fa fa-money',
												 								'link' => [
												 										'Cash Advances' => base_url("index.php/admin/cash_advance"),
												 										'Loans' 	=> base_url("index.php/admin/loan"), 
												 										'Other Deductions' => base_url("index.php/admin/deduction")
												 										]
												 									),
											  	 'Deduction Tables' => array('icon' => 'fa fa-minus-circle', 'link' => array('SSS' => base_url('index.php/admin/deduction_tables/sss'),
																																	'PHILHEALTH' => base_url('index.php/admin/deduction_tables/philhealth'),
																																	'PAG-IBIG' => base_url('index.php/admin/deduction_tables/pagibig'),
																																	'WTAX' => base_url('index.php/admin/deduction_tables/wtax')))

											);

			create_header(array('rightNav' => array($this->load->view("admin/admin_core/notifications", $dataNotification, TRUE),
													lte_load_view("nav_bar_user_menu",array('imgSrc' 	=> $userImg,
																							'userName' 	=> $this->userInfo->fullName('f m. l'),
																							'leftBTN' 	=> anchor(base_url('index.php/admin/account_settings'), '<i class="fa fa-gears"></i> Settings', array('class' => "btn btn-info btn-flat")),
																							'rightBTN' 	=> anchor(base_url('index.php/admin/personnel_information/logout'), '<i class="fa fa-key"></i> Sign out', array('class' => "btn btn-danger btn-flat",
																							'id' 		=> 'logoutBTN'))))
													)
								),$plugins,$addStyles

						);

			create_navigation($navigationVars);
		}
		elseif($this->uri->segment(1) == "employee"){
			set_header_title("Employee");
			set_site_name("Employee Profile");

			$navigationVars = array();

			$navigationVars["userPanel"] = array("userName" => $this->userInfo->fullName("f m. l"),
												 "userInfo" => $this->userInfo->employment_job_title,
												 "userImage" => file_exists($userImg = "images/users/".$this->userInfo->employee_id.".jpg") ? base_url($userImg) : $userImg = base_url("images/no-image.fw.png"));
			$navigationVars["searchBar"] = false;

			$navigationVars["options"] = array("Dashboard" 	  	=> array("icon" => "fa fa-dashboard text-blue",
																		 "link" => base_url("index.php/employee/dashboard")
																   ),
												"Attendance" 	=> array("icon" => "fa fa-users text-blue",
																	  	 "link" => array("Daily Time Record" => base_url("index.php/employee/dtr"),
																	  				  "Log Failures"	  	 => base_url("index.php/employee/failure_to_log")
																	  				  )
																	    ),

												"Loans and Advances" 	=>	array("icon" => "fa fa-money text-blue",
																				  "link" => array(
																				  				   "Loans" => base_url("index.php/employee/loan"),
																				  				   'Cash Advance'  => base_url("index.php/employee/cash_advance")
																				  				 )
																				 ),
												"Deduction Brackets"	=> array("icon" => "fa fa-minus-circle text-blue",
																				 "link" => base_url("index.php/employee/deduction_tables")
																				 ),
												"201" 			=> array('icon' => 'fa fa-users text-blue', 
											  	 						 'link' => base_url('index.php/employee/home')
											  	 						),
											  	 'Leave' => array('icon' => 'fa fa-user-times text-blue','link' => base_url('index.php/employee/leave')),
											  	 'Payroll' => array('icon' => 'fa fa-file-text text-blue', 'link' => base_url('index.php/employee/payroll')),
												);
			
			create_header(array('rightNav' => array(lte_load_view("nav_bar_user_menu",array('imgSrc' 	=> base_url($userImg),
																							'userName' 	=> $this->userInfo->fullName('f m. l'),
																							'leftBTN' 	=> anchor(base_url('index.php/employee/account_settings'), '<i class="fa fa-gears"></i> Settings', array('class' => "btn btn-info btn-flat")),
																							'rightBTN' 	=> anchor(base_url('index.php/employee/dashboard/logout'), '<i class="fa fa-key"></i> Sign out', array('class' => "btn btn-danger btn-flat",
																							'id' 		=> 'logoutBTN'))))
													)
								),$plugins,$addStyles

						);
			create_navigation($navigationVars);
		}
	}
	public function create_footer($addScripts = array(),$addPlugins = array()){
		$addPlugins[] = asset_url('plugins/raphael.min.js');
		$addPlugins[] = asset_url('plugins/morris/morris.min.js');

		foreach ($addPlugins as $key => $value) {
			$addScripts[] = "<script src='{$value}'></script>";
		}

		// $addScripts[] = $this->load->view('admin/home/jscripts', array(), TRUE);

		if ($this->uri->segment(1) == "admin" || $this->uri->segment(1) == "employee") {
			create_footer(array('left' => '<strong>Copyright &copy; '. date('Y') .' <a href="">ENGTECH GLOBAL SOLUTIONS INC.</a></strong> All rights reserved.',
							'right' => '<b>HRMS</b> Version 2.1'),
						$addScripts
						);
		}
	}
	public function check_rule($logObject = false)
	{
		$this->load->model('attendance_rule');
		$rule = new Attendance_rule;
		$rule = $rule->get();
		$theRule = reset($rule);
		$late = $this->funcs->time_interval($logObject->nfds_time_in,$logObject->log_in);
		$underTime = $this->funcs->time_interval($logObject->nfds_time_in,$logObject->log_in);

		if (strtotime($late->format('%H:%i')) >= strtotime($theRule->late_hr_max.":".$theRule->late_min_max)) {
			return "absent by rule of {$theRule->late_hr_max} hr/s and {$theRule->late_min_max} min/s late.";
		}
		elseif (strtotime($underTime->format('%H:%i')) >= strtotime($theRule->ut_hr_max.":".$theRule->ut_min_max)) {
			return "absent by rule of {$theRule->ut_hr_max} hr/s and {$theRule->ut_min_max} min/s undertime";
		}
		else{
			return false;
		}
	}
	public function emp_schedule($employee_id = false){
		if (!$employee_id) {
			return false;
		}
		$this->load->model('non_flexi_daily_scheds');
		$this->load->model('employee');

		$nfds = new Non_Flexi_Daily_Scheds;
		$employees = new Employee;
		//employee
		$employees->toJoin = array('employment' => 'employee',
								 'department' => 'employment');
		$employees->db->where("employees.employee_id = '{$employee_id}'");
		$empDept = $employees->get();
		$empDept = reset($empDept);

		// employee's own schedule
		$empSched = new non_flexi_daily_scheds;
		$empSched->toJoin = array('eec_nfds' => 'non_flexi_daily_scheds',
								  'employee_est_classifications' => 'eec_nfds',
								  'employee' => 'employee_est_classifications');

		$allEmpScheds = $empSched->search(array('employees.employee_id' => $employee_id ));
		$sqlStatement = "";
		$counter = 0;

		if ($allEmpScheds) {
			$sqlStatement .= "NOT(";
			foreach ($allEmpScheds as $key => $value) {
				if ($counter > 0) {
					$sqlStatement .= " OR ";
				}
				$sqlStatement .= "(
									(non_flexi_daily_scheds.nfds_day = '{$value->nfds_day}') 
									AND
									(
										(non_flexi_daily_scheds.nfds_time_in BETWEEN '{$value->nfds_time_in}' AND '{$value->nfds_time_out}')
										OR
										(non_flexi_daily_scheds.nfds_time_out BETWEEN '{$value->nfds_time_in}' AND '{$value->nfds_time_out}')
									)
								 )";
				$timeScheds[] = array(	'day' 		=> $value->nfds_day,
										'time_in' 	=> $value->nfds_time_in,
										'time_out' 	=> $value->nfds_time_out
										);
				$counter++;
				if (!$value->status) {
					unset($allEmpScheds[$key]);
				}

			}
			$sqlStatement .= " ) AND ";
		}


		// employee's department schedule
		$nfds->toJoin = array('depts_def_sched_nfds' => 'non_flexi_daily_scheds');
		$deptSched    = $nfds->search( $sqlStatement." depts_def_sched_nfds.department_id = '{$empDept->department_id}'");
		$getAllNfds   = array_merge($allEmpScheds,$deptSched);

		return $getAllNfds;
	}
	// public function  get_json_dtr($emp_id,$fromDate = false, $toDate = false)
	// {
	// 	$this->load->model('nfds_logs');
	// 	$this->load->model('attendance_rule');
	// 	$this->load->model('employee');

	// 	$allLogs      = new Nfds_Logs;
	// 	$logs         = $allLogs->by_dates($fromDate, $toDate, $emp_id);
	// 	$log_dtr      = array();
	// 	$final_report = array();
	// 	$allTime      = $this->funcs->datesInArray($fromDate,$toDate);
	// 	$attRule      = new Attendance_rule;
	// 	$attRule 	  = $attRule->get();
	// 	$theRule      = reset($attRule);
	// 	$maxLateRule  = $theRule->late_hr_max.":".$theRule->late_min_max;
	// 	$maxUtRule	  = $theRule->ut_hr_max.":".$theRule->late_min_max;
	// 	$empInfo = new Employee;
	// 	$empInfo->load($emp_id);

	// 	foreach ($logs as $key => $value) {
	// 		$dataForDtr   = array();
	// 		$amIn         = "";
	// 		$pmIn         = "";
	// 		$amOut        = "";
	// 		$pmOut        = "";
	// 		$lateMins     = 0;
	// 		$lateHrs      = 0;


	// 		$dataForDtr['date'] = $key;

	// 		foreach ($value as $logDate => $logObject) {
	// 			$current_late = 0;
	// 			$byRule = $this->check_rule($logObject);
	// 			$schedShift = date('a',strtotime($logObject->nfds_time_in));
	// 			$lates      = $this->funcs->time_interval($logObject->log_in,$logObject->nfds_time_in);
	// 			$uts  		= $this->funcs->time_interval($logObject->nfds_time_out,$logObject->log_out);
				
	// 			if ($lates->invert) {
	// 				$lateMins += $lates->i;
	// 				$lateHrs += $lates->h;
	// 			}
	// 			if ($uts->invert) {
	// 				$lateMins += $uts->i;
	// 				$lateHrs += $uts->h;
	// 			}

	// 			$dataForDtr['scheds'][] = $logObject;
	// 				switch ($schedShift) {
	// 					case 'am':
	// 							$amIn = !$byRule ? $logObject->log_in : array('time' => $logObject->log_in, 'txt' => $byRule);
	// 							$amOut = !$byRule ? $logObject->log_out : array('time' => $logObject->log_out, 'txt' => $byRule);
	// 						break;
	// 					default:
	// 							$pmIn =  !$byRule ? $logObject->log_in : array('time' => $logObject->log_in, 'txt' => $byRule);
	// 							$pmOut = !$byRule ?  $logObject->log_out : array('time' => $logObject->log_in, 'txt' => $byRule);
	// 						break;
	// 				}
	// 		}
	// 		$dataForDtr['late'] 	= $lates;
	// 		$dataForDtr['undertime'] = $uts;
	// 		$dataForDtr['underwork'] = array('hrs' => $lateHrs, 'mins' => $lateMins);
	// 		$dataForDtr['am_in'] = !is_array($amIn) && $amIn != "" ? date('h:i', strtotime($amIn)): $amIn;
	// 		$dataForDtr['am_out'] = !is_array($amOut) && $amOut !=  ""  ? date('h:i', strtotime($amOut)): $amOut;
	// 		$dataForDtr['pm_in'] = !is_array($pmIn) && $pmIn !=  ""  ? date('h:i', strtotime($pmIn)): $pmIn;
	// 		$dataForDtr['pm_out'] = !is_array($pmOut) &&  $pmOut != "" ? date('h:i', strtotime($pmOut)): $pmOut;
			

	// 		$log_dtr = $dataForDtr;
	// 	}
	// 	foreach ($allTime as $key => $value) {
	// 		$tod        = $value->format('Y-m-d');
	// 		$empSched   = $this->funcs->search_in_array($empInfo->scheds(),'nfds_day',strtolower(date('D', strtotime($tod))));
	// 		$schedCount = count($empSched);
	// 		$hasLogHere = $this->funcs->search_in_array($log_dtr, 'date', $tod);
	// 		$am_in = "";
	// 		$am_out = "";
	// 		$pm_in = "";
	// 		$pm_out = "";
	// 		$schedSpan = false;
	// 		$ut_hrs = "";
	// 		$ut_mins = "";
	// 		$late = "";
	// 		$udt = "";
	// 		$day_total = "";

	// 		if (date('D', strtotime($tod)) == 'sun') {
	// 			$ut_mins = "<span class='red-text'>SUN</span>";
	// 		}
	// 		elseif(date('D', strtotime($tod)) == 'sat'){
	// 			$ut_mins = "<span>SAT</span>";
	// 		}

	// 		foreach ($empSched as $key2 => $schedObj) {
	// 			$currSpan = $this->funcs->time_interval($schedObj->nfds_time_in,$schedObj->nfds_time_out);
	// 			if ($schedSpan) {
	// 				$newSpan = new DateTime("00:00");
	// 				$e = clone $newSpan;
	// 				$newSpan->add($currSpan);
	// 				$newSpan->add($schedSpan);
	// 				$schedSpan = $e->diff($newSpan);
	// 				continue;
	// 			}
	// 			$schedSpan = $currSpan;

	// 		}
	// 		if ($hasLogHere) {
	// 			$theLog = reset($hasLogHere);
	// 			$late = $theLog['late']->invert ? date('H:i',strtotime($theLog['late']->h.":".$theLog['late']->i)) : "00:00";
	// 			$udt =   $theLog['undertime']->invert ? date('H:i',strtotime($theLog['undertime']->h.":".$theLog['late']->i)) : "00:00";
	// 			$am_in = $theLog['am_in'];
	// 			$am_out = $theLog['am_out'];
	// 			$pm_in  = $theLog['pm_in'];
	// 			$pm_out = $theLog['pm_out'];
	// 			$underHrs = intval($theLog['underwork']['hrs']);
	// 			$underMins = intval($theLog['underwork']['mins']);
	// 			$extractMins = $underMins / 60;
	// 			if ($theLog['am_in'] != "" && $theLog['am_out'] != "") {
	// 				$day_total = $this->funcs->time_interval($theLog['am_in'],$theLog['am_out']);
	// 				$day_total = date('H:i',strtotime($day_total->h.":".$day_total->i));
	// 			}
	// 			if ($theLog['pm_in'] != "" && $theLog['pm_out'] != "") {
	// 				$pmSpan = $this->funcs->time_interval($theLog['pm_in'],$theLog['pm_out']);
	// 				$totalSplit = explode(":",$day_total);
	// 				if (isset($totalSplit[1])) {
	// 					$day_total = ($totalSplit[0] + $pmSpan->h ).":". ($totalSplit[1] + $pmSpan->i);
	// 				}

	// 			}
	// 			if ( $extractMins >= 1) {
	// 				$underHrs = floor($extractMins);
	// 				$underMins = ($underHrs - $extractMins) * 100;
	// 			}
	// 			$ut = new DateTime("{$underHrs}:{$underMins}");
	// 			$ut->sub($schedSpan);

	// 			$ut_hrs =  $ut->format('H');
	// 			$ut_mins =  $ut->format('i');
	// 		}
	// 		if ($schedCount > 0) {
	// 			$absentTxt = "<span class='text-red'>ABSENT</span>";
	// 			if ($am_in == "" && $am_out == "") {
	// 				$am_out = "ABSENT";
	// 			}
	// 			elseif (is_array($am_in)) {
	// 				$theAm = $am_in;
	// 				$am_in = $theAm['time'];
	// 				$am_out = $absentTxt;
	// 			}
	// 			elseif (is_array($am_out)) {
	// 				$am_out = $absentTxt;
	// 			}

	// 			if ($pm_in == "" && $pm_out == "") {
	// 				$pm_out = "ABSENT";
	// 			}
	// 			elseif (is_array($pm_in)) {
	// 				$thePm = $pm_in;
	// 				$pm_in = $thePm['time'];
	// 				$pm_out = $absentTxt;
	// 			}
	// 			elseif (is_array($pm_out)) {
	// 				$pm_out = $absentTxt;
	// 			}
	// 		}

	// 		$final_report[] = array( 'date' => date('d', strtotime($tod)), 
	// 								'am_in' => $am_in,
	// 								'am_out' => $am_out,
	// 								'pm_in' => $pm_in,
	// 								'pm_out' => $pm_out,
	// 								'late' => $late,
	// 								'undertime' => $udt
	// 								,"",
	// 								"",
	// 								'total days' => $day_total);
	// 	}
	// 	return $final_report;
	// }
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
					$pmIn 	= $theLog['pm_in'];
					$pmOut 	= $theLog['pm_out'];
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
					$underMins = round(($extractMins - $underHrs) * 60);
				}
				$ut = new DateTime("{$underHrs}:{$underMins}");
				if ($schedSpan) {
					$ut->sub($schedSpan);

					$ut_hrs 	=  $ut->format('H');
					$ut_mins 	=  $ut->format('i');
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
									'date' 		=> date('M d', strtotime($tod)),
									'am_in' 	=> $am_in,
									'am_out' 	=> $am_out,
									'pm_in' 	=> $pm_in,
									'pm_out' 	=> $pm_out,
									'late' 		=> $late,
									'undertime' => $udt,
									"",
									"",
									$day_total
									);
		}
		return $final_report;
	}
	public function basic_emp_json()
	{
		$this->load->model('employee');
		$emps         = new Employee;
		$emps->toJoin = array('employment' => 'employee',
								'department' => 'employment');


		$json = array();
		$all  = $emps->get();
		foreach ($all as $key => $value) {
			$data = array('' => $value->employee_id,
						'fullName' 		=> "<b class='red-text'>".$value->fullName()."</b>",
						'age' 			=> $value->age(),
						'department' 	=> $value->department_name,
						'status' 		=> $value->employment_status,
						'position' 		=> $value->employment_job_title,
						'hired_date' 	=> $value->employment_hired_date,
						'employment_type' => $value->employment_type,
						'employment_rate' => $value->employment_rate,
						'pagibig'		=> $value->employment_application_info()->eaf_pagibig,
						'sss' 			=> $value->employment_application_info()->eaf_SSS,
						'philhealth' 	=> $value->employment_application_info()->eaf_philhealth,
						'tin' 			=> $value->employment_application_info()->eaf_TIN,
						);

			$json[] = $data;
		}

		return json_encode($json);
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
								"fullName" => $value->fullName(),
								'department' => $value->department_name,
								'position' => $value->employment_job_title,
								"number" => $count );
			$json[] = $dataArray;
		}
		return json_encode($json);		
	}
	public function employee_datatable_json()
	{
		$this->load->model('employee','emps');
		$this->emps->toJoin = array('employment' => 'employee',
									'department' => 'employment');

		$allEmps = $this->emps->search(["employment.employment_status" => "active"]);
		$json = array('data' => []);
		$count = 0;
		foreach ($allEmps as $key => $value) {
			$count++;
			$dataArray = array(
								$value->employee_id,
								$value->fullName(),
								$value->department_name,
								$value->employment_job_title
							 );
			$json['data'][] = $dataArray;
		}
		echo json_encode($json);		
	}
	public function logout(){
		$sec = new Securitys;
		$sec->logout();
	}
	public function notifications_cash_advance(){
		$this->load->model('emp_cash_advance');
		$eca = new Emp_Cash_Advance;
		$data = $eca->search("emp_cash_advances.emp_ca_request_status = 0");			
		return $data;
	}
	public function notifications_leave(){
		$this->load->model('employee_leave');
		$emp_leave = new Employee_Leave;
		$data = $emp_leave->search("employee_leave.emp_leave_request_status = 0");
		return $data;
	}
	public function notifications_loan(){
		$this->load->model('emp_loan');
		$emp_loan = new Emp_Loan;
		$data = $emp_loan->search("emp_loans.emp_loan_request_status = 0");
		return $data;
	}
	public function notifications_update_request(){
		$this->load->model('employee_update_request');
		$eur = new Employee_Update_Request;
		$data = $eur->search("employee_update_request.eur_status = 0");
		return $data;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
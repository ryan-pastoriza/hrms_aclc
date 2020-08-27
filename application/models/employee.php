<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Employee extends MY_Model{
		const DB_TABLE = "employees";
		const DB_TABLE_PK = "employee_id";
		const FIRST_NAME = "employee_fname";
		const MIDDLE_NAME = "employee_mname";
		const LAST_NAME = "employee_lname";
		
		public $employee_id;
		public $employee_fname;		
		public $employee_mname;	
		public $employee_lname;
		public $employee_ext;
		public $employee_bday;
		public $employee_birth_place;
		public $employee_gender;
		public $employee_height;
		public $employee_weight;
		public $employee_blood_type;
		public $employee_mother;
		public $employee_father;
		public $biometric_id;
		public $employee_status;
		public $employee_telephone;
		public $employee_mobile;
		public $employee_religion;
		public $employee_current_address;
		public $employee_permanent_address;
		public $employee_contact_person_name;
		public $employee_contact_person_address;
		public $employee_contact_person_telephone;
		public $employee_contact_person_mobile;


		public function attendance($from = false, $to = false)
		{
			$this->load->model('event');
			$event = new Event;

			$datesInArray = $this->funcs->datesInArray($from,$to);
			$total_days_absent 	= 0;
			$total_late_minutes = 0;
			$total_undertime_minutes = 0;

			foreach ($datesInArray as $key => $value) {

				$date 			= $value->format('Y-m-d');
				$daySched  		= $this->scheds($date);
				$hrs_to_render  = $this->hours_to_render_on_date($date, $daySched);

				foreach ($daySched as $key2 => $value2) {

					$log = $value2->log($this->employee_id,$date);

					if ($log->emp_log_in != "" && $log->emp_log_out != "") {
						$total_late_minutes += $value2->minutes_late();
						$total_undertime_minutes += $value2->minutes_undertime();
					}
					else{
						$has_leave = $value2->on_leave($this->employee_id, $date);

						// echo "<pre>";
						// print_r($has_leave);
						// echo "</pre>";
						if($has_leave->emp_leave_id != ""){
						}
						elseif(!$event->has_event_on($date,$date) && ($has_leave->emp_leave_with_pay != 1) ){
						// calculate days absent
						$hrsToRender = $value2->minutes_length() / 60;
						$percentage = $hrsToRender / $hrs_to_render;
						$total_days_absent += $percentage;
						}

					}
				}
			}

			$ret = [
					'days_absent' => round($total_days_absent,2),
					'minutes_late' => round($total_late_minutes,2),
					'minutes_undertime' => round($total_undertime_minutes,2)
					];



			return $ret;
		}
		public function monthly_absences($from = false, $to = false)
		{
			$datesInArray = $this->funcs->datesInArray($from,$to);
			$attendance = [];

			foreach ($datesInArray as $key => $value) {

				$date 			= $value->format('Y-m-d');
				$daySched  		= $this->scheds($date);
				$hrs_to_render  = $this->hours_to_render_on_date($date, $daySched);

				foreach ($daySched as $key2 => $value2) {

					$log = $value2->log($this->employee_id,$date);

					if ($log->emp_log_in == "" && $log->emp_log_out == "") {
						// calculate days absent
						$hrsToRender = $value2->minutes_length() / 60;
						$percentage = $hrsToRender / $hrs_to_render;
						$absent_days = $percentage;

						if (isset($attendance[$value->format('m')])) {
							$attendance[$value->format('m')] += $absent_days;
						}
						else{
							$attendance[$value->format('m')] = $absent_days;
						}
					}
				}
			}


			return $attendance;
		}
		public function hours_to_render_on_date($date = false, $scheds = false)
		{
			if (!$scheds) {
				$scheds = $this->scheds($date);
			}
			$hrs = 0;

			foreach ($scheds as $key => $value) {
				$interval = $this->funcs->time_interval($value->{$value::TIME_IN}, $value->{$value::TIME_OUT} );

				$hrs += $interval->h;
				$hrs += $interval->i / 60;
			}

			return $hrs;
		}
		public function employee_bday()
		{
			return date('F d', strtotime($this->employee_bday));
		}
		public function age(){
			$age = 0;
	    	if($this->employee_bday != ""){
	    	  $birthDate = date("m/d/Y",strtotime($this->employee_bday));
			  //get age from date or birthdate
			  $age = date_diff(date_create( $birthDate), date_create('today'))->y;
	    	}
	    	
			$employee_age = $age;
			return $employee_age;
		}
		public function get_all($status = false, $limit = 0, $offset = 0)
		{
			$this->toJoin = array('employment' => 'employee' , 
										'department' => 'employment');
			if ($status) {
				return $this->search("employment.employment_status = '{$status}'");

			}
			return $this->get();
		}	
		public function logs_today()
		{
			$this->load->model('employee_log');

			$empLog = new Employee_log;
			$empLogs = $empLog->search(['employee_id' => $this->employee_id,
										'emp_log_date' => date('Y-m-d'),]);

			return $empLogs;

		}
		public function scheds($date = false)
		{
			$allSched = $this->cal_scheds($date);


			foreach ($allSched as $key => $value) {

				// filter out deleted department schedule
				if(get_class($value) == 'Depts_Def_Sched_Nfds'){
					foreach ($allSched as $key2 => $value2) {
						if(get_class($value2) == "Eec_Nfds"){
							if($value2->deleted_dept_sched == 1){

								if($value->nfds_time_in == $value2->nfds_time_in && $value->nfds_time_out == $value2->nfds_time_out)
									unset($allSched[$key]);
									unset($allSched[$key2]);
								continue;
							}

						}
					}
				}
				// filter out overlapping employee irregular schedule from all other types of schedule 
				elseif (get_class($value) == "Emp_irreg_sched") {
					$in1 = strtotime($value->emp_irreg_sched_time_in);
					$out1 = strtotime($value->emp_irreg_sched_time_out);

					foreach ($allSched as $key2 => $value2) {

						$in2 = false;
						$out2 = false;

						if (get_class($value2) == "Eec_Nfds") {
							$in2 = strtotime($value2->nfds_time_in);
							$out2 = strtotime($value2->nfds_time_out);
						}
						elseif (get_class($value2) == "Depts_Def_Sched_Nfds") {
							$in2 = strtotime($value2->nfds_time_in);
							$out2 = strtotime($value2->nfds_time_out);
						}
						elseif (get_class($value2) == "Department_irregular_sched") {
							$inTime = date("H:i", strtotime($value2->sched_from_date));
							$outTime = date("H:i", strtotime($value2->sched_to_date));

							$in2 = strtotime($inTime);
							$out2 = strtotime($outTime);
						}

						if ($in2 && $out2) {
							$intersects = $this->funcs->range($in1, $in2, $out2,true) || $this->funcs->range($out1,$in2,$out2,true) || $this->funcs->range($in2, $in1, $out1,true) || $this->funcs->range($out2, $in1, $out1,true);

							if ($intersects) {
								unset($allSched[$key2]);
							}
						}


					}
				}
				// filter out overlapping employee regular schedule from all other types of schedule except employee irregular scheds
				elseif (get_class($value) == "Eec_Nfds") {
					$in1  = strtotime($value->nfds_time_in);
					$out1 = strtotime($value->nfds_time_out);

					

					foreach ($allSched as $key2 => $value2) {
						$in2  = false;
						$out2 = false;

						if (get_class($value2) == "Depts_Def_Sched_Nfds") {
							$in2  = strtotime($value2->nfds_time_in);
							$out2 = strtotime($value2->nfds_time_out);

						}
						elseif (get_class($value2) == "Department_irregular_sched") {
							$inTime = date("H:i", strtotime($value2->sched_from_date));
							$outTime = date("H:i", strtotime($value2->sched_to_date));

							$in2 = strtotime($inTime);
							$out2 = strtotime($outTime);
						}

						if ($in2 && $out2) {

							
							$intersects = $this->funcs->range($in1, $in2, $out2,TRUE) 
										|| $this->funcs->range($out1,$in2,$out2,TRUE) 
										|| $this->funcs->range($in2, $in1, $out1,TRUE) 
										|| $this->funcs->range($out2, $in1, $out1,TRUE);

							if ($intersects) {
								unset($allSched[$key2]);
							}
						}

					}
				}
				// filter out overlapping department irregular schedule from department regular schedule
				elseif (get_class($value) == "Department_irregular_sched") {
					$inTime = date("H:i", strtotime($value->sched_from_date));
					$outTime = date("H:i", strtotime($value->sched_to_date));

					$in1 = strtotime($inTime);
					$out1 = strtotime($outTime);

					foreach ($allSched as $key2 => $value2) {
						$in2  = false;
						$out2 = false;

						if (get_class($value2) == "Depts_Def_Sched_Nfds") {
							$in2  = strtotime($value2->nfds_time_in);
							$out2 = strtotime($value2->nfds_time_out);
						}

						if ($in2 && $out2) {
							$intersects = $this->funcs->range($in1, $in2, $out2,TRUE) 
											|| $this->funcs->range($out1,$in2,$out2,TRUE) 
											|| $this->funcs->range($in2, $in1, $out1,TRUE) 
											|| $this->funcs->range($out2, $in1, $out1,TRUE);

							if ($intersects) {
								unset($allSched[$key2]);
							}
						}


					}
				}


			}
			return $allSched;
		}
		public function emp_scheds($date = false)
		{

			// regular sched
			$this->load->model('eec_nfds');
			$reg_sched = new Eec_Nfds;

			$dow 		= date('D', strtotime($date));

			if ($date) {
				$reg_sched->toJoin = ['non_flexi_daily_scheds' => 'eec_nfds'];
				$all_reg = $reg_sched->search( " eec_id = {$this->eec_id}
												AND
											   status = 1
											   AND
											   nfds_day = '{$dow}'
											   AND
											   start <= '{$date}'
											   AND 
											   (
											   	end IS NOT NULL AND end >= '{$date}'
											   	OR
											   	end IS NULL
											   )
												");

				$this->load->model('emp_irreg_sched');
				$irregSched = new Emp_irreg_sched;
				$allIrreg = $irregSched->search(['employee_id' 				=> $this->employee_id,
												'emp_irreg_sched_status' 	=> 1,
												 'emp_irreg_sched_date' 	=> $date ]);

			}
			else{

				$reg_sched->toJoin = ['non_flexi_daily_scheds' => 'eec_nfds'];
				$all_reg = $reg_sched->search(['eec_id' => $this->eec_id,
											'status' => 1 ]);

				$this->load->model('emp_irreg_sched');
				$irregSched = new Emp_irreg_sched;
				$allIrreg = $irregSched->search(['employee_id' 			 => $this->employee_id,
												'emp_irreg_sched_status' => 1]);
			}


			

			// irregSched
			

			$allSched = array_merge($all_reg, $allIrreg);
			// echo "<pre>";
			// 	print_r($allSched);
			// echo "</pre>";


			return $allSched;
		}
		public function department_sched($from = false, $to = false)
		{
			$this->load->model('department');
			$dept = new Department;
			$dept->load($this->department_id);

			$sched = $dept->sched($from, $to);


			return $sched;
		}
		public function check_sched_conflict($sched_type = false, $sched_days = false, $time_in = false, $time_out = false, $start_date = false, $end_date = false )
		{
			$department_sched = $this->department_sched($start_date);
			$this->load->model('eec_nfds');

			$in 	= strtotime($time_in);
			$out 	= strtotime($time_out);
			$conflicts = [];

			// load department

			if ($sched_type == "reg") {
				// loop through set days
				foreach ($sched_days as $key => $value) {
					// loop through existing department_schedule
					foreach ($department_sched as $key2 => $value2) {
						// if sched comes from depts_def_sched_nfds
						if (get_class($value2) == "Depts_Def_Sched_Nfds") {
							// if set schedule day is the same as one of the existing schedule							
							if (strtolower($value2->nfds_day) == $value) {

								$schedIn 	= strtotime($value2->nfds_time_in);
								$schedOut 	= strtotime($value2->nfds_time_out);

								$in_range 		= $this->funcs->range($in, $schedIn, $schedOut);
								$out_range 		= $this->funcs->range($out, $schedIn, $schedOut);
								$schedIn_range 	= $this->funcs->range($schedIn, $in, $out);
								$schedOut_range = $this->funcs->range($schedOut, $in, $out);


								if ($in_range || $out_range || $schedIn_range || $schedOut_range) {
									$forCheck = new Eec_Nfds;
									$hasDeleted = $forCheck->search("eec_id = {$this->eec_id} AND nfds_id = {$value2->nfds_id} AND start = '{$value2->start}' AND deleted_dept_sched = 1");
									if (!$hasDeleted) {
										$conflicts[]  = $value2;
									}

								}
							}
						}
					}

					// find schedule in conflict with employee regular schedule
					$emp_reg_sched = new Eec_Nfds;
					$emp_reg_sched->toJoin = ['non_flexi_daily_scheds' => 'eec_nfds'];

					if ($end_date) {
						$emp_sched     = $emp_reg_sched->search("eec_id = {$this->eec_id} 
														AND non_flexi_daily_scheds.nfds_day = '{$value}' 
														AND
														 eec_nfds.status = 1 
														AND 
														 ( 
													 		(
													 			eec_nfds.end is NULL
													 			AND
													 			CAST(eec_nfds.start as DATE) BETWEEN '{$start_date}' AND '{$end_date}'
															)
														 	OR 
														 	('{$start_date}' BETWEEN CAST(eec_nfds.start as DATE) AND CAST(eec_nfds.end as DATE))
														 	OR
														 	( CAST(eec_nfds.start as DATE) BETWEEN '{$start_date}' AND '{$end_date}' )
														 	OR
														 	(
														 		CAST(eec_nfds.end as DATE) BETWEEN '{$start_date}' AND '{$end_date}'
														 	)

														  ) 
														AND 
														( 
															CAST(non_flexi_daily_scheds.nfds_time_in as TIME) BETWEEN '{$time_in}' AND '{$time_out}' 
															OR 
															CAST(non_flexi_daily_scheds.nfds_time_out as TIME) BETWEEN '{$time_in}' AND '{$time_out}' 
															OR 
															'{$time_in}' BETWEEN CAST(non_flexi_daily_scheds.nfds_time_in as TIME) AND CAST(non_flexi_daily_scheds.nfds_time_out as TIME) 
															OR 
															'{$time_out}' BETWEEN CAST(non_flexi_daily_scheds.nfds_time_in as TIME) AND CAST(non_flexi_daily_scheds.nfds_time_out as TIME) 
														) AND deleted_dept_sched != 1
														");
					}					
					else{
						$emp_sched     = $emp_reg_sched->search("eec_id = {$this->eec_id} 
														AND non_flexi_daily_scheds.nfds_day = '{$value}' 
														AND
														 eec_nfds.status = 1 
														AND 
														 ( 
													 		(	
													 			eec_nfds.end is NULL
															)
														 	OR 
														 	('{$start_date}' BETWEEN CAST(eec_nfds.start as DATE) AND CAST(eec_nfds.end as DATE))

														  ) 
														AND 
															( 
															CAST(non_flexi_daily_scheds.nfds_time_in as TIME) BETWEEN '{$time_in}' AND '{$time_out}' 
															OR 
															CAST(non_flexi_daily_scheds.nfds_time_out as TIME) BETWEEN '{$time_in}' AND '{$time_out}' 
															OR 
															'{$time_in}' BETWEEN CAST(non_flexi_daily_scheds.nfds_time_in as TIME) AND CAST(non_flexi_daily_scheds.nfds_time_out as TIME) 
															OR 
															'{$time_out}' BETWEEN CAST(non_flexi_daily_scheds.nfds_time_in as TIME) AND CAST(non_flexi_daily_scheds.nfds_time_out as TIME) 
														) AND deleted_dept_sched != 1
														");
					}
					

					$conflicts = array_merge($conflicts,$emp_sched);

				}
			}
			else{
				$this->load->model('eec_nfds');
				$this->load->model('emp_irreg_sched');

				$sched_days = explode(",", $sched_days);

				$eecnfds = new Eec_Nfds;
				$eecnfds->toJoin = ['non_flexi_daily_scheds' => 'eec_nfds'];

				$eir = new Emp_irreg_sched;


				$qry = "eec_id = {$this->eec_id}
						AND
						eec_nfds.status = 1 
						AND 
						( 
							non_flexi_daily_scheds.nfds_time_in BETWEEN '{$time_in}' AND '{$time_out}' 
							OR 
							non_flexi_daily_scheds.nfds_time_out BETWEEN '{$time_in}' AND '{$time_out}' 
							OR 
							'{$time_in}' BETWEEN non_flexi_daily_scheds.nfds_time_in AND non_flexi_daily_scheds.nfds_time_out 
							OR 
							'{$time_out}' BETWEEN non_flexi_daily_scheds.nfds_time_in AND non_flexi_daily_scheds.nfds_time_out 
						)
						 AND ( ";

				$eir_qry = "
								employee_id = '{$this->employee_id}'
								AND
								(
							";



				$counter = 0;
				// search from department regular schedule
				foreach ($sched_days as $key => $value) {
					$counter++;
					// loop through existing department schedule
					$theDay = date('D', strtotime($value));
					$theDate = date('Y-m-d', strtotime($value));

					if ($counter != 1) {
						$eir_qry .= " OR ";
						$qry .= " OR ";
					}

					$eir_qry .= "
							(
								emp_irreg_sched_date = '{$theDate}'
								AND
								( 
									emp_irreg_sched_time_in BETWEEN '{$time_in}' AND '{$time_out}'
									OR
									emp_irreg_sched_time_out BETWEEN '{$time_in}' AND '{$time_out}'
									OR 
									'{$time_in}' BETWEEN emp_irreg_sched_time_in AND emp_irreg_sched_time_out
									OR 
									'{$time_out}' BETWEEN emp_irreg_sched_time_in AND emp_irreg_sched_time_out
								)
							)
								";


					$qry .= " ( 
						 		eec_nfds.start <= '{$theDate}' 
								AND 
						 			( 
						 				eec_nfds.end is NULL 
						 					OR 
						 				eec_nfds.end >= '{$theDate}'
						  			) 
						  AND
							non_flexi_daily_scheds.nfds_day = '{$theDay}' 
							) ";


					// if ($counter != count($sched_days)) {
					// 	$eir_qry .= " ) ";
					// }

					foreach ($department_sched as $key2 => $value2) {
						$theDay = date('D', strtotime($value));

						if (get_class($value2) == "Depts_Def_Sched_Nfds") {
							if (strtolower($theDay) == strtolower($value2->nfds_day)) {
								$schedIn 	= strtotime($value2->nfds_time_in);
								$schedOut 	= strtotime($value2->nfds_time_out);

								$in_range 		= $this->funcs->range($in,  $schedIn, $schedOut);
								$out_range 		= $this->funcs->range($out, $schedIn, $schedOut);
								$schedIn_range 	= $this->funcs->range($schedIn,  $in, $out);
								$schedOut_range = $this->funcs->range($schedOut, $in, $out);

								if ($in_range || $out_range || $schedIn_range || $schedOut_range) {
									$conflicts[]  = $value2;
								}
							}
						}


					}
				}

				// has conflict on employee regular schedule
				$qry .= ")";
				$hasConflict = $eecnfds->search($qry);

				// has conflict on employee irregular schedule
				$eir_qry .= ")";
				$hasConflict2 = $eir->search($eir_qry);



				$conflicts = array_merge($conflicts,$hasConflict);
				$conflicts = array_merge($conflicts, $hasConflict2);
			}

			return $conflicts;
		}
 
		public function cal_scheds($date = false)
		{
			
			$this->load->model('department');
			$this->load->model('eec_nfds');
			$this->load->model('emp_irreg_sched');

			$dept = new Department;

			$dept->load($this->department_id);

			$deptSched 	= $dept->calendar_sched($date);
			$empSched 	= $this->emp_scheds($date);


			// trim department schedule
			foreach ($deptSched as $key => $value) {
				if (get_class($value) == "Depts_Def_Sched_Nfds") {
					$eecNfds = new Eec_Nfds;
					$hasDeleted = $eecNfds->search([
													'eec_id'  => $this->eec_id,
													'nfds_id' => $value->nfds_id,
													'status'  => 0,
													'start'   => $value->start,
													'end'     => $value->end
													]);
					
				}
				elseif (get_class($value) == "Department_irregular_sched") {
					$eis = new Emp_irreg_sched;


					$hasDeleted = $eis->search(['emp_irreg_sched_date'     => date('Y-m-d', strtotime($value->sched_from_date)),
												'emp_irreg_sched_time_in'  => date('H:i', strtotime($value->sched_from_date)), 
												'emp_irreg_sched_time_out' => date('H:i', strtotime($value->sched_to_date)),
												'employee_id'              => $this->employee_id,
												'emp_irreg_sched_status'   => 0]);

				}

				if ($hasDeleted) {
						unset($deptSched[$key]);
				}

			}



			$allSched = array_merge(  $deptSched, $empSched);
			return $allSched;
		}

		// for headers
		public function has_log_on_shift($date =false, $shift = false)
		{
			$eec_nfds = $this->has_shift_on_day($date, $shift);

			if ($eec_nfds && $eec_nfds->nfds_id != "") {
				$this->load->model('non_flexi_daily_scheds');
				$nfds = new Non_Flexi_Daily_Scheds;
				$nfds->load($eec_nfds->nfds_id);

				return $nfds->log($date, $this->employee_id);
			}
			else{
				return false;
			}
		}
		// check if employee has this specific shift on specific day
		public function has_shift_on_day($date=false, $shift = false)
		{
			$day = date('D', strtotime($date));
			$shiftSpan = explode('-', $shift);

			foreach ($this->scheds() as $key => $value) {
				if (strtolower($value->nfds_day) == strtolower($day) 
						&& date('H:i', strtotime($shiftSpan[0])) == date('H:i', strtotime($value->nfds_time_in))
						&& date('H:i', strtotime($shiftSpan[1])) == date('H:i', strtotime($value->nfds_time_out))
					) {
					return $value;
				}
			}
			return false;
		}
		public function sched_shifts($from = false, $to = false)
		{
			// hold possible time span combinations to check if the header has already been displayed
			$shifts = [];
			foreach ($this->scheds() as $key => $value) {
				// check if it is a non flexible sched
				if (get_class($value) == 'Non_Flexi_Daily_Scheds' && !in_array( date('h:i a', strtotime($value->nfds_time_in)) ." - ". date('h:i a', strtotime($value->nfds_time_out)), $shifts)) {
					$shifts[date('Hi',strtotime($value->nfds_time_in)).date('Hi',strtotime($value->nfds_time_out))] = date('h:i a', strtotime($value->nfds_time_in)) ." - ". date('h:i a', strtotime($value->nfds_time_out));
				}
			}
			ksort($shifts);
			return $shifts;
		}
		public function load_with_employment_info($emp_id)
		{
			$this->load->model('employee_est_classifications');

			$eec = new Employee_Est_Classifications;
			$eec = $eec->pop(['employee_id' => $emp_id]);

			if ($eec->eec_id == "") {
				$eec = new Employee_Est_Classifications;
				$eec->est_id = 1;
				$eec->employee_id = $emp_id;
				$eec->save();
			}
			$this->toJoin = array('employment' 	=> 'employee' , 
								'department' 	=> 'employment',
								'employee_est_classifications' => 'employee');
			$this->load($emp_id);
		}
		public function sched_on_day($date = false)
		{
			$scheds = $this->scheds();
			$allSched = [];

			foreach ($scheds as $key => $value) {
				if (get_class($value) == "Non_Flexi_Daily_Scheds") {
					if ( strtolower(date('D', strtotime($date))) == $value->nfds_day ) {
						$allSched[] = $value;
					}
				}
			}
			return $allSched;
		}
		public function overtime($date = false)
		{
			$this->load->model('emp_overtime');
			$overtime 		 = new Emp_overtime;
			$overtime_on_day = $overtime->search(" '{$date}' = emp_ot_date  AND employee_id = '{$this->employee_id}' ");

			return $overtime_on_day;
		}
		public function ot_logs($ot_obj)
		{
			$this->load->model('checklog');

			$this->checklog->sqlQueries['order_field'] = 'log_time';
			$this->checklog->sqlQueries['order_type'] = 'desc';

			$theIn = $this->checklog->search("DATE(log_time) = '{$ot_obj->emp_ot_date}' AND TIME(log_time) < '{$ot_obj->emp_ot_to}' AND badgenumber = {$this->biometric_id} AND logType = 'I' ", 1);
			if($theIn){

				$theIn = reset($theIn);
				$this->checklog->sqlQueries['order_type'] = 'asc';


				$theOut = $this->checklog->search("DATE(log_time) = '{$ot_obj->emp_ot_date}' AND TIME(log_time) >= '{$ot_obj->emp_ot_from}' AND badgenumber = {$this->biometric_id} AND logType = 'O'", 1);

				if ($theOut) {
					$theOut = reset($theOut);
					$theLogs = new stdClass;

					$theLogs->emp_ot_in = date('H:i', strtotime($theIn->log_time));
					$theLogs->emp_ot_out = date('H:i', strtotime($theOut->log_time));

					
					return $theLogs;

				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		
			// $this->load->model('employee_log');
			// 	$shift_log = new Employee_log;
			// 	$shift_log->selects = ['*',
			// 							"CONCAT(emp_log_date,' ',emp_log_in) as log_datetime_in",
			// 							"CONCAT(emp_log_date,' ',emp_log_out) as log_datetime_out"];
  	// 			$log = $shift_log->having("  CONVERT('{$ot_obj->emp_ot_date} {$ot_obj->emp_ot_from}', DATETIME) BETWEEN CONVERT(log_datetime_in, DATETIME) AND CONVERT(log_datetime_out, DATETIME)  AND (employee_id = '{$this->employee_id}')");
  	// 			if ($log) {
  	// 				return array_shift($log);
  	// 			}
  	// 			else{
  	// 				return false;
  	// 			}
		}
		public function ot_rendered_on_dates($fromDate, $toDate)
		{
			$this->load->model('events');


			$dates 						= $this->funcs->datesInArray($fromDate,$toDate);
			$total_rendered 			= 0;
			$total_nd 					= 0;
			$total_spec_holiday_ot_hrs 	= 0;
			$total_spec_holiday_otnd 	= 0;
			$total_reg_holiday_ot_hrs 	= 0;
			$total_reg_holiday_otnd 	= 0;


			foreach ($dates as $key => $value) {
				$date 		= $value->format('Y-m-d');
				$ot_on_day 	= $this->overtime($date);

				foreach ($ot_on_day as $key2 => $value2) {
					$ot_logs = $this->ot_logs($value2);
					$otTo = strtotime($value2->emp_ot_from) > strtotime($value2->emp_ot_to) ? date('Y-m-d H:i', strtotime($value2->emp_ot_to."+ 1 day")) : $value2->emp_ot_to;

					// kung naay logs
					if ($ot_logs) {
						$holidays = [];

						if (get_class($ot_logs) == "Shift_log") {
							if ($ot_logs->sl_in == "" || $ot_logs->sl_out == "") {
								continue;
							}

							$sl_in 	= $ot_logs->sl_date." ".$ot_logs->sl_in;
							$sl_out = $ot_logs->sl_date." ".$ot_logs->sl_out;

							if (strtotime($sl_out) < strtolower($sl_in)) {
								$sl_out = date('Y-m-d H:i', strtotime($sl_out." + 1 day"));
							}
							$start_time 	= strtotime($value2->emp_ot_from) > strtotime($ot_logs->sl_in) ? $value2->emp_ot_from : $ot_logs->sl_in ;
							$end_time 		= strtotime($otTo) > strtotime($sl_out) ? $sl_out : $otTo;

						}else{
							if ($ot_logs->emp_ot_in == "" || $ot_logs->emp_ot_out == "") {
								continue;
							}
							$start_time 	= strtotime($value2->emp_ot_from) > strtotime($ot_logs->emp_ot_in) ? $value2->emp_ot_from : $ot_logs->emp_ot_in ;
							$end_time 		= strtotime($otTo)   > strtotime($ot_logs->emp_ot_out) ? $ot_logs->emp_ot_out : $otTo;
						}
						if (date('Y-m-d', strtotime($end_time)) != date('Y-m-d', strtotime($start_time))) {
							$events 		=	new Events;
							$start_date 	= date('Y-m-d', strtotime($start_time));
							$end_date 		= date('Y-m-d', strtotime($end_time));
		

							$weeks_in_month = ["1st","2nd","3rd","4th","5th"];
							$nth_day_start 	= $weeks_in_month[floor(date('d', strtotime($start_date)) / 7.2)];
							$nth_day_start 	=  date(' l \of F', strtotime($nth_day_start));
							$nth_day_end 	= $weeks_in_month[floor(date('d', strtotime($end_date)) / 7.2)];
							$nth_day_end 	=  date(' l \of F', strtotime($nth_day_end));

							$is_holliday1 = $events->pop("( ('{$start_date}' BETWEEN start_date AND end_date  )
													or
													( DATE_FORMAT('{$start_date}','%m-%d') BETWEEN DATE_FORMAT(start_date,'%m-%d') AND DATE_FORMAT(end_date,'%m-%d') AND `repeat` = 'date')
													or
													( `string` = '{$nth_day_start}' AND `repeat` = 'string')
													  )
													  AND  work = 0
													 ");

							$is_holliday2 = $events->pop("( ('{$end_date}' BETWEEN start_date AND end_date  )
													or
													( DATE_FORMAT('{$end_date}','%m-%d') BETWEEN DATE_FORMAT(start_date,'%m-%d') AND DATE_FORMAT(end_date,'%m-%d') AND `repeat` = 'date')
													or
													( `string` = '{$nth_day_end}' AND `repeat` = 'string')
													  )
													  AND  work = 0
													 ");
							if ($is_holliday1->event_id != "") {
								$holidays[] = $is_holliday1;
							}
							if ($is_holliday2->event_id != "" ) {
								if ($is_holliday1->event_id != "" && $is_holliday1->event_id == $is_holliday2->event_id) {

								}else{
									$holidays[] = $is_holliday2;
								}
							}
						}

						$span 			= $this->funcs->time_interval($start_time,$end_time);

						$hours_rendered = 0;

						$hours_rendered += $span->h;
						$hours_rendered += ($span->i / 60);


						$total_rendered += $hours_rendered;

						// calculate ot/nd
							$log_in 	= strtotime($start_time);
							$log_out 	= strtotime($end_time);
							$start_log  = date('Y-m-d' , strtotime($start_time));
							$end_log 	= date('Y-m-d', strtotime($end_time));


							$night_hours_from 	= strtotime($start_log. " 6:00 pm");
							$dawn_hours_from = strtotime($start_log." 05:00 am");
							$night_hours_to 	= date('Y-m-d', strtotime($end_log)) == date('Y-m-d', strtotime($start_log)) ? strtotime($end_log.   " 5:00 am + 1 day") : strtotime($end_log.   " 5:00 am");

							$has_diff = false;

							$t1 = $this->funcs->range($log_in, $night_hours_from,$night_hours_to);
							$t2 = $this->funcs->range( $log_out, $night_hours_from, $night_hours_to);
							$t3 = $log_in < $dawn_hours_from;

							$rendered_nd_from = false;
							$rendered_nd_to   = false;

							if($t1){
								$has_diff 			= $t1;
								$rendered_nd_from 	= $night_hours_from < $log_in ? $log_in : $night_hours_from;
								$rendered_nd_to 	= $night_hours_to > $log_out ? $log_out : $night_hours_to;
							}
							elseif($t2){
								$has_diff = $t2;
								$rendered_nd_from = $night_hours_from < $log_in ? $log_in : $night_hours_from;
								$rendered_nd_to 	= $night_hours_to > $log_out ? $log_out : $night_hours_to;
							}
							elseif($t3){
								$has_diff = $t3;
								$rendered_nd_from  = $dawn_hours_from;
								$rendered_nd_to 	= $log_out > $dawn_hours_from ? $log_in : $log_out;
							}
							if ($rendered_nd_from) {
								$rendered_nd_from = date('Y-m-d H:i', $rendered_nd_from);
								$rendered_nd_to   = date('Y-m-d H:i', $rendered_nd_to);

								$interval = $this->funcs->time_interval($rendered_nd_from,$rendered_nd_to);


								$total_nd += $interval->h;
								$total_nd += ($interval->i / 60);


							}
						// end calculate ot/nd

						// calculate holiday ot
							foreach ($holidays as $key3 => $value3) {

								$next_day 			= $value3->end_date." + 1 day";
								$holiday_range_from = strtotime($value3->start_date." 00:00");
								$holiday_range_to   = strtotime($next_day." 00:00");
								$log_range_from   	= $log_in;
								$log_range_to 		= $log_out;


								$range_covered_from = $log_range_from < $holiday_range_from ? $holiday_range_from : $log_range_from;
								$range_covered_to 	= $log_range_to > $holiday_range_to ? $holiday_range_to : $log_range_to;

								$range_covered_from_datetime 	= date('Y-m-d H:i', $range_covered_from);
								$range_covered_to_datetime   	= date('Y-m-d H:i', $range_covered_to);
								$range_covered_from_date 		= date('Y-m-d', $range_covered_from);
								$range_covered_to_date 			= date('Y-m-d', $range_covered_to);
								$holiday_interval				= $this->funcs->time_interval($range_covered_from_datetime, $range_covered_to_datetime);



								// calculate holiday nd
								$holiday_span = $this->funcs->datesInArray($range_covered_from_date,$range_covered_to_date);
								$total_holiday_nd_rendered = 0;

								foreach ($holiday_span as $key3 => $hDate) {
									$hDate = $hDate->format('Y-m-d');
									$holiday_end = date('Y-m-d', strtotime($hDate." + 1 day"));

									$holiday_nd_from_datetime 	= $hDate." 6:00 pm";
									$holiday_nd_to_datetime  	= $holiday_end." 00:00";


									$fromIsInRange =  $this->funcs->range($range_covered_from, strtotime($holiday_nd_from_datetime) , strtotime($holiday_nd_to_datetime));
									$toIsInRange = $this->funcs->range($range_covered_to, strtotime($holiday_nd_from_datetime) , strtotime($holiday_nd_to_datetime));


									if ( $fromIsInRange || $toIsInRange ){

										$holiday_rendered_from  	= $range_covered_from > strtotime($holiday_nd_from_datetime) ? date('Y-m-d H:i',$range_covered_from) : $holiday_nd_from_datetime;
										$holiday_rendered_to 		= $range_covered_to > strtotime($holiday_nd_to_datetime) ? $holiday_nd_to_datetime : date('Y-m-d H:i', $range_covered_to);

										$rendered_holiday_nd = $this->funcs->time_interval($holiday_rendered_from, $holiday_rendered_to);

									}
									else{
										$holiday_nd_from_datetime 	= $hDate." 00:00";
										$holiday_nd_to_datetime  	= $hDate." 5:00 am";
										$fromIsInRange 				=  $this->funcs->range($range_covered_from, strtotime($holiday_nd_from_datetime) , strtotime($holiday_nd_to_datetime));
										$toIsInRange 				= $this->funcs->range($range_covered_to, strtotime($holiday_nd_from_datetime) , strtotime($holiday_nd_to_datetime));

											if ( $fromIsInRange || $toIsInRange ){

												$holiday_rendered_from  	= $range_covered_from > strtotime($holiday_nd_from_datetime) ? date('Y-m-d H:i',$range_covered_from) : $holiday_nd_from_datetime;
												$holiday_rendered_to 		= $range_covered_to > strtotime($holiday_nd_to_datetime) ? $holiday_nd_to_datetime : date('Y-m-d H:i', $range_covered_to);

												$rendered_holiday_nd = $this->funcs->time_interval($holiday_rendered_from, $holiday_rendered_to);

											}
									}
									if (isset($rendered_holiday_nd)) {
										$total_holiday_nd_rendered += $rendered_holiday_nd->h;
										$total_holiday_nd_rendered += ($rendered_holiday_nd->i / 60);
									}


								}

								// end calculate holiday nd


								// record holiday rendered hours, ND hours
								if (strtolower($value3->event_type) == "special non-working holiday") {

									$total_spec_holiday_ot_hrs += $holiday_interval->h;
									$total_spec_holiday_ot_hrs += ($holiday_interval->i / 60);
										$total_spec_holiday_otnd += $total_holiday_nd_rendered;

								}else{
									$total_reg_holiday_ot_hrs += $holiday_interval->h;
									$total_reg_holiday_ot_hrs += ($holiday_interval->i / 60);
										$total_reg_holiday_otnd   += $total_holiday_nd_rendered;
								}
								// end record holiday rendered hours, ND hours

								

							}
					}

				}

			}
			$data = ['ot_hours' 			=> $total_rendered,
					'ot_nd' 				=> $total_nd,
					'special_holiday' 		=> $total_spec_holiday_ot_hrs,
					'special_holiday_nd' 	=> $total_spec_holiday_otnd,
					'reg_holiday_hrs' 		=> $total_reg_holiday_ot_hrs,
					'reg_holiday_nd' 		=> $total_reg_holiday_otnd ];

			return $data;
		}
		// public function get_rates()
		// {
		// 	if (isset($this->employment_rate)) {
		// 		$this->daily_rate = number_format(round(($this->employment_rate * 12) / 314,2),2);
		// 		$this->weekly_rate = number_format(floatval($this->daily_rate) * 5,2);
		// 		$this->semi_monthly_rate = number_format(round(($this->employment_rate / 2),2),2);
		// 		$this->monthly_rate = number_format(round(($this->employment_rate),2),2);
		// 	}
		// }
		// public function tax_bracket($term,$rate)
		// {
		// 	if (isset($this->employment_rate)) {
		// 		$this->load->model('wtax');
		// 		$wtax = new Wtax;

		// 		return $wtax->pop("wtax_bracket_base <= {$this->daily_rate} && wtax_bracket_term = 'daily' ");
		// 	}
		// 	return false;
		// }
		public function tenure()
		{
			if (!isset($this->employment_hired_date)) {
				$this->toJoin = array('employment' => 'employee' , 
									'department'   => 'employment');
				$this->load($this->employee_id);
			}
			$interval = $this->funcs->time_interval(date('Y-m-d'),$this->employment_hired_date);

			$tenure = [];
			$tenure['years'] 	= floor($interval->days / 365);
			$tenure['months'] 	= floor( ( $interval->days - ($tenure['years'] * 365) ) / 30);
			$tenure['days'] 	= ($interval->days - ( ($tenure['years'] * 365) + ($tenure['months'] * 30 ) ));

			return $tenure;
		}
		public function employment_application_info()
		{
			$this->load->model('employment_application_form');
			$eaf = new Employment_application_form;

			$eaf = $eaf->pop(['employee_id' => $this->employee_id]);

			return $eaf;
		}
		public function get_rates()
		{
			if (isset($this->employment_rate)) {

				$this->daily_rate 			= round(($this->employment_rate * 12) / 314,2);
				$this->weekly_rate 			= round(($this->daily_rate) * 5,2);
				$this->semi_monthly_rate 	= round(($this->employment_rate / 2),2);
				$this->monthly_rate 		= round(($this->employment_rate),2);
				$this->hourly_rate 			= round(($this->daily_rate / 8),2);
				$this->minute_rate 			= round(($this->hourly_rate / 60),2);
				$this->ot_rate 				= round((($this->hourly_rate / 100) * 125 ),2);
			}
			return $this;
		}
		public function tax_bracket($term)
		{
			$termCheck = str_replace('-', '_', $term);
			$rateTerm = $termCheck."_rate";
			$status = $this->wtax_bracket_status();
			if($this->employment_rate == ""){
				return "Employee rate undefined";
			}
			else {
					$this->load->model('wtax');
					$rate = doubleval($this->$rateTerm);
					$wtax = new Wtax;
					$wtax->sqlQueries['order_type'] = 'desc';
					$wtax->sqlQueries['order_field'] = 'wtax_bracket_base';
					return $wtax->pop("wtax_bracket_base <= {$rate} && wtax_bracket_term = '{$term}'");

			}
			return false;
		} 
		public function load_with_employment_record($employee_id)
		{
			$this->employee_id;
			$this->toJoin = ['employment' => 'employee'];
			parent::load($employee_id);
			$this->get_rates();
		}
		private function wtax_bracket_status()
		{
			$wtax_status = "";
			$this->load->model('employee_dependent');
			$dependents = new Employee_Dependent;
			$allDependents = $dependents->search(['employee_id' => $this->employee_id,
													'emp_dependent_dependency' => 1]);

			$totalDependents = count($allDependents);

			if($totalDependents == 0){
				$wtax_status = "S/ME";
			}
			else {
				$wtax_status = "ME".$totalDependents."/S".$totalDependents;
			}
			return $wtax_status;
		}
		public function has_leave_on_sched($date, $nfds_id) {
			$this->load->model('employee_leave');
			$this->load->model('non_flexi_daily_scheds');
			
			$leave = new Employee_Leave;
			$nfds = new Non_Flexi_Daily_Scheds;


			$nfds->load($nfds_id);

			$dateFrom = date('Y-m-d H:i:s'	,strtotime("{$date} {$nfds->nfds_time_in}"));
			$dateTo   = date('Y-m-d H:i:s'	,strtotime("{$date} {$nfds->nfds_time_out}"));

			$all_leave = $leave->pop("((emp_leave_from BETWEEN '{$dateFrom}' AND '{$dateTo}' OR emp_leave_to BETWEEN '{$dateFrom}' AND '{$dateTo}'  OR '{$dateFrom}' BETWEEN emp_leave_from and emp_leave_to OR '{$dateTo}' BETWEEN emp_leave_from and emp_leave_to )) AND (employee_id = '{$this->employee_id}')");
			if ($all_leave) {
				return $all_leave->employee_id == "" ? false : $all_leave;
			}
		}
		public function has_fail_log($date, $nfds_id, $log_type){
			$this->load->model('emp_log_fail_requests');
			$this->load->model('non_flexi_daily_scheds');

			$log_request 	= new Emp_Log_Fail_Requests;
			$nfds 			= new Non_Flexi_Daily_Scheds;

			$nfds->load($nfds_id);
			$date = date('Y-m-d', strtotime($date));

			$logReqs = $log_request->search("( DATE(emp_lfr_log_in) = '{$date}' OR DATE(emp_lfr_log_out) = '{$date}') AND employee_id = '{$this->employee_id}' ");

			if ($logReqs) {
				foreach ($logReqs as $key => $value) {
					$scOut 	= strtotime($date." ".$nfds->nfds_time_out);
					$scIn 	= strtotime($date." ". $nfds->nfds_time_in);

					if ($log_type == 'in') {
						if ($value->emp_lfr_log_in == "") {
							return false;
						}

						$frIn 	= strtotime($value->emp_lfr_log_in);

						if ($scIn >= $frIn AND $scIn <= $scOut) {
							return $value;
						}
						elseif ($frIn >= $scIn && $frIn <= $scOut) {
							return $value;
						}
						else{
							return false;
						}
					}
					elseif ($log_type == 'out') {
						if ($value->emp_lfr_log_out == "") {
							return false;
						}

						$frOut = strtotime($value->emp_lfr_log_out);
						
						if ($scOut >= $scIn && $scOut <= $frOut) {
							return $value;
						}
						elseif($frOut >= $scIn && $frOut <= $scOut){
							return $value;
						}
						else{
							return false;
						}
					}
				}
			}else{
				return false;
			}
		}
		public function sss_share()
		{
			$this->load->model('sss');
			$shares = ['employee' => 0.0,
						'employer' => 0];
			$sss = new Sss;
			$sss = $sss->pop("{$this->employment_rate} BETWEEN sss_range_from AND sss_range_to");
			if ($sss->sss_id != "") {
				$shares['employee'] = $sss->sss_ee_cont;
				$shares['employer'] = $sss->sss_er_cont;
				$shares['compensation'] = $sss->sss_range_from . " - " . $sss->sss_range_to;
			}
			return $shares;
		}
		public function philhealth_share()
		{
			$this->load->model('philhealth');
			$phic = new Philhealth;
			$share = ['employee' => 0,
						'employer' => 0];

			$phic = $phic->pop("{$this->employment_rate} BETWEEN phic_salary_range_from AND phic_salary_range_to");
			if ($phic->phic_id != "") {
				$percentage = explode('%', $phic->phic_monthly_premium);
				$mp = 0;
				if($this->employment_rate > 10000){
					$mp = ($this->employment_rate / 100) * $percentage[0];
					$total_share = $mp / 2;
				}
				else{
					$total_share = $phic->phic_monthly_premium / 2;
				}
				$share['employee'] = $total_share;
				$share['employer'] = $total_share;
				$share['salary_bracket'] = $phic->phic_salary_range_from . " - " . $phic->phic_salary_range_to;
			}

			return $share;
		}
		public function pagibig_share()
		{
			$this->load->model('pagibig');
			$pagibig = new Pagibig;
			$emp_pagibig = $pagibig->pop(['employee_id' => $this->employee_id]);

			if ($emp_pagibig->pagibig_id != '') {
				return $emp_pagibig->pagibig_share;
			}			
			return 100;
		}
		public function cash_advance()
		{
			$this->load->model('emp_cash_advance');
			$ca = new Emp_Cash_Advance;
			$ca->toJoin 					= ['emp_ca_payment' => 'emp_cash_advance'];
			$ca->selects 					= ['emp_cash_advances.*',"emp_ca_payments.ca_payment_amt","emp_ca_payments.ca_payment_option","emp_ca_payments.ca_payment_date","SUM(emp_ca_payments.ca_payment_amt) as paid", "(emp_ca_amount - SUM(emp_ca_payments.ca_payment_amt) ) as ca_balance"];
			$ca->sqlQueries['toGroup'] 		= "emp_cash_advances.emp_ca_id";
			$ca->sqlQueries['join_type'] 	= "LEFT";

			$allCa = $ca->having("(paid < emp_cash_advances.emp_ca_amount OR paid is NULL) AND emp_cash_advances.employee_id = '{$this->employee_id}' ");

			return $allCa;
		}
		public function loans()
		{
			$this->load->model('emp_loan');
			$loan = new Emp_Loan;
			$loan->toJoin 				= ['emp_loan_payment' => 'emp_loan'];
			$loan->selects 				= ['emp_loan_payments.*', 'emp_loans.*', "SUM(emp_loan_payments.el_payment_amount) as paid", "(emp_loans.emp_loan_amt - SUM(emp_loan_payments.el_payment_amount)) as loan_balance"];
			$loan->sqlQueries['toGroup'] 	= "emp_loans.emp_loan_id";
			$loan->sqlQueries['join_type'] 	= "LEFT";

			return $loan->having("(paid < emp_loans.emp_loan_amt OR paid is NULL) AND emp_loans.employee_id = '{$this->employee_id}' ");
		}
		public function other_deductions()
		{
			if (!isset($this->other_deductions)) {
				$this->load->model('emp_other_deduction');
				$eod = new Emp_Other_Deduction;

				$this->other_deductions = $eod->search(['employee_id' => $this->employee_id]);
			}

			return $this->other_deductions;


			// $this->load->model('emp_other_deduction');
			// $eod = new Emp_Other_Deduction;

			// $eod->toJoin 	= ['emp_other_deduction_payment' => 'emp_other_deduction',
			// 					'other_deduction' => 'emp_other_deduction'];
			// $eod->sqlQueries['join_type'] = 'left';
			// $eod->selects 	= ['emp_other_deductions.*',
			// 					'other_deductions.*',
			// 					'emp_other_deduction_payments.eod_payment_id',
			// 					'emp_other_deduction_payments.eod_payment_date',
			// 					'emp_other_deduction_payments.eod_payment_option',
			// 					'emp_other_deduction_payments.eod_payment_amount',
			// 					'SUM(emp_other_deduction_payments.eod_payment_amount) as total_paid',
			// 					'(emp_other_deductions.eod_amt_total - SUM(emp_other_deduction_payments.eod_payment_amount)) as balance'];
			// $other_deds = $eod->having("employee_id =  '{$this->employee_id}' AND MONTH(DATE_ADD(other_ded_start_date,INTERVAL other_ded_duration_months MONTH)) <= '". date('m')."' AND ( balance >= 0 OR balance is NULL)");
			// return $other_deds;
		}
		public function rematch_logs($from = false, $to = false)
		{
			$this->load->model('checklog');
			$cl = new Checklog;

			$dates = $this->funcs->datesInArray($from, $to);

			foreach ($dates as $key => $value) {
				$theDate = $value->format('Y-m-d');
				$clsOnDay = $cl->search(['badgenumber' => $this->biometric_id, 'DATE(log_time)' => $theDate]);
				$this->clear_logs_on($theDate);
				foreach ($clsOnDay as $key => $value) {
					$matched = $this->log_match($theDate, $value->logtype);

					if ($matched) {
						$hasLoggedOnSched = $this->logs_on_sched($theDate,$matched);

						$theLog = $hasLoggedOnSched ? reset($hasLoggedOnSched) : false;


						if ($value->logtype == 'O' && $theLog) {
							$theLog->emp_log_out = date('H:i', strtotime($value->log_time));
							$theLog->save();
						}
						elseif (!$hasLoggedOnSched) {

							$newLog = new Employee_log;
							$newLog->employee_id 		= $this->employee_id;
							$newLog->emp_log_sched_type = get_class($matched);
							$newLog->emp_log_sched_id	= $matched->{$matched::DB_TABLE_PK};
							$newLog->emp_log_date 		= date('Y-m-d', strtotime($value->log_time));
							
							if ($value->logtype == 'O') {
								$newLog->emp_log_out = date('H:i', strtotime($value->log_time));				
							}
							else{
								$newLog->emp_log_in = date('H:i', strtotime($value->log_time));				
							}
							$newLog->save();
						}
					}
				}				
			}
		}
		public function clear_logs_on($date = false)
		{
			$this->load->model('employee_log');	
			$emp_logs = new Employee_log;
			$allLogs = $emp_logs->search(['employee_id' => $this->employee_id,
										'emp_log_date' => $date]);
			foreach ($allLogs as $key => $value) {
				$value->delete();
			}
		}
		public function logs_on_sched($day = false, $schedObj = false)
		{
			$this->load->model('employee_log');	
			
			$empLog = new Employee_log;

			return $empLog->search([
									'employee_id'      => $this->employee_id,
									'emp_log_sched_id' => $schedObj->{$schedObj::DB_TABLE_PK},
									'emp_log_date'     => $day,
									'emp_log_sched_type' => get_class($schedObj)
									]);
		}
		public function log_match($date,$logType)
		{
			
			$schedOnDay = $this->scheds($date);

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
	}
?>
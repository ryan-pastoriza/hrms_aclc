<?php
/**
 * @Author: Gian
 * @Date:   2015-08-26 17:21:16
 * @Last Modified by:   Gian
 * @Last Modified time: 2019-07-24 09:41:15
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Schedule extends MY_Controller {


	public function test()
	{
		$emp = new Employee;
		$emp->load_with_employment_info("BTN-2018-03105");

		$objs = $emp->check_sched_conflict("reg", ['mon'], '09:30:00 am', '12:00:00 pm', '09-09-2019', null);

		echo "<pre>";
			print_r($objs);
		echo "</pre>";

	}
	public function index()
	{
		$allEmps = $this->basic_emp_json();

		$this->create_head_and_navi([
										asset_url("plugins/jQueryUI/jquery-ui.min.js"),
										asset_url("plugins/iCheck/icheck.min.js"),
										asset_url('plugins/daterangepicker/moment.js'),
										asset_url('plugins/fullcalendar/fullcalendar.min.js'),
										asset_url('plugins/multidatespicker/jquery-ui.multidatespicker.js'),
										asset_url('plugins/select2/select2.full.min.js'),
									],
									[
										asset_url('plugins/fullcalendar/fullcalendar.min.css'),
										asset_url('plugins/select2/select2.min.css'),
										asset_url("plugins/iCheck/all.css"),
										asset_url('plugins/datatables/dataTables.bootstrap.css'),
										asset_url('plugins/jQueryUI/jquery-ui.structure.css'),
										asset_url('plugins/jQueryUI/jquery-ui.theme.css'),
										asset_url('plugins/multidatespicker/jquery-ui.multidatespicker.css'),
									]);
		create_content([
							'contentHeader' => "Employee Schedule",
							'content' 		=> $this->load->view('admin/Schedule/Employee_Schedule/main',array('allEmps' => $allEmps), TRUE)
						]);
		$this->create_footer();
	}
	public function index2(){

			$allEmps = $this->basic_emp_json();

			$this->create_head_and_navi([
											asset_url('plugins/datatables/jquery.dataTables.min.js'),
											asset_url('plugins/datatables/dataTables.bootstrap.min.js'),
										],
										[
											asset_url('plugins/datatables/dataTables.bootstrap.css'),
										]);

			
			create_content([
							'contentHeader' => "Employee Schedule",
							'content' => $this->load->view('admin/Schedule/Employee_Schedule/employee_schedule',array('allEmps' => $allEmps), TRUE)
							]);
			$this->create_footer();
	}
	public function cal_events()
	{
		$objs = [];
		
		if ($this->input->post('employee_id') != "") {
			$emp = new Employee;
			$emp->load_with_employment_info($this->input->post('employee_id'));
			$objs = $this->objectify_schedule($emp->cal_scheds());
		}

		echo json_encode($objs);
	}
	public function objectify_schedule($schedule)
	{
		$objs = [];
		$dows = ['mon' => 1,'tue' => 2,'wed' => 3,'thu' => 4,'fri' => 5,'sat' => 6,'sun' => 7];

		foreach ($schedule as $key => $value) {

			$anObj = [];

			switch (get_class($value)) {
				case 'Depts_Def_Sched_Nfds':
					$anObj = [	'title' 			=> date('h:i a', strtotime($value->nfds_time_in))." - ". date('h:i a', strtotime($value->nfds_time_out))."<br> Department Regular Schedule" ,
							'dow' 				=> [$dows[$value->nfds_day]],
							'start' 			=> date("H:i", strtotime($value->nfds_time_in)),
							'end' 				=> date("H:i", strtotime($value->nfds_time_out)),
							'sched_id' 			=> $value->ddsnfds_id,
							'schedType' 		=> "reg",
							'ranges' 			=> [[
													'start' => date('Y-m-d', strtotime($value->start)),
													'end' 	=> $value->end != "" ? date('Y-m-d', strtotime($value->end)) : date('Y-m-d', strtotime('next year'))
													]
													],
							'allDay' 			=> false,
							'color' 			=> '#33cc33',
							'displayEventTime' 	=> false,
							'obj_name' 			=> "Depts_Def_Sched_Nfds",
							'sched_obj' 		=> $value ];
					break;
				case 'Department_irregular_sched':
					$anObj = [	'title' 			=> date('h:i a', strtotime($value->sched_from_date))." - ". date('h:i a', strtotime($value->sched_to_date))."<br> Department Irregular Schedule"  ,
							'start' 			=> date("Y-m-d H:i", strtotime($value->sched_from_date)),
							'end' 				=> date("Y-m-d H:i", strtotime($value->sched_to_date)),
							'sched_id' 			=> $value->dis_id,
							'schedType' 		=> "irreg",
							'allDay' 			=> false,
							'color' 			=> '#ff6633',
							'displayEventTime' 	=> false,
							'obj_name' 			=> "Department_irregular_sched",
							'sched_obj' 		=> $value ];
					break;
				case 'Eec_Nfds':
					$anObj = [	'title' 			=> date('h:i a', strtotime($value->nfds_time_in))." - ". date('h:i a', strtotime($value->nfds_time_out))."<br> Employee Regular Schedule"  ,
							'dow' 				=> [$dows[$value->nfds_day]],
							'start' 			=> date("H:i", strtotime($value->nfds_time_in)),
							'end' 				=> date("H:i", strtotime($value->nfds_time_out)),
							'sched_id' 			=> $value->eec_nfds_id,
							'schedType' 		=> "reg",
							'ranges' 			=> [[
													'start' => date('Y-m-d', strtotime($value->start)),
													'end' 	=> $value->end != "" ? date('Y-m-d H:i', strtotime($value->end." ".$value->nfds_time_out)) : date('Y-m-d', strtotime('next year'))
													]],
							'allDay' 			=> false,
							'color' 			=> '#3399ff',
							'displayEventTime' 	=> false,
							'obj_name' 			=> "Eec_Nfds",
							'sched_obj' 		=> $value ,
							'deleted' 			=> $value->deleted_dept_sched];
					break;
				case 'Emp_irreg_sched':
					$anObj = [	'title' 			=> date('h:i a', strtotime($value->emp_irreg_sched_time_in))." - ". date('h:i a', strtotime($value->emp_irreg_sched_time_out))."<br> Employee Irregular Schedule"  ,
							'start' 			=> date("Y-m-d H:i", strtotime($value->emp_irreg_sched_date." ".$value->emp_irreg_sched_time_in)),
							'end' 				=> date("Y-m-d H:i", strtotime($value->emp_irreg_sched_date." ".$value->emp_irreg_sched_time_out)),
							'sched_id' 			=> $value->emp_irreg_sched_id,
							'schedType' 		=> "irreg",
							'allDay' 			=> false,
							'color' 			=> '#ff3333',
							'displayEventTime' 	=> false,
							'obj_name' 			=> "Emp_irreg_sched",
							'sched_obj' 		=> $value ];
					break;
				
				default:
					continue;
					break;
			}


			
			

			$objs[] = $anObj;

		}
		return $objs;
	}
	private function get_table_data($all_sched = FALSE, $emp_id = false){
		$dataTable = array();
		if ($all_sched || $all_sched != "") {
			foreach ($all_sched as $key => $value) {
				// if (isset($value->status) && !$value->status) {
				// 	continue;
				// }
				$day             = date('l',strtotime($value->nfds_day));
				$time_in         = date('g:i:s a', strtotime($value->nfds_time_in));
				$time_out        = date('g:i:s a', strtotime($value->nfds_time_out));

				$data            = array();
				$editableTimeIn  = array();
				$editableTimeOut = array();

				$data['id']       = isset($value->ddsnfds_id) ? $value->ddsnfds_id : $value->eec_nfds_id;
				$data['table']    = isset($value->ddsnfds_id) ? "dept" :"eec";
				$data['emp_id']   = $emp_id;

				$editableTimeIn['timeIn'] = $time_in;
				$editableTimeIn['nfds_id'] = $value->nfds_id;

				$editableTimeOut['timeOut'] = $time_out;
				$editableTimeOut['nfds_id'] = $value->nfds_id;

				$buttons = $this->load->view('admin/widgets/employee_schedule/buttons', $data, TRUE);
				$time_in = $this->load->view('admin/widgets/employee_schedule/editable_time_in', $editableTimeIn, TRUE);
				$time_out = $this->load->view('admin/widgets/employee_schedule/editable_time_out', $editableTimeOut, TRUE);



				$dataTable['data'][] = array($day,
											 $time_in,
											 $time_out,
											 $buttons);
			}
		}
		else{
			$dataTable['data'][] = array("Employee has no Schedule",
										 "",
										 "",
										 "");
		}
		
		return $dataTable;
	}
	public function update_schedule()
	{
			$toret     = array();
			$emp_id    = $this->input->post('employee_id');
			$allScheds = $this->emp_schedule($emp_id);
			$found     = $this->funcs->search_in_array($allScheds,'nfds_id',$this->input->post('pk'));
			$found     = reset($found);
			if (isset($found->eec_nfds_id)) {
				$this->load->model('eec_nfds');
				$eec_nfds = new Eec_Nfds;
				$eec_nfds->load($found->eec_nfds_id);
				$eec_nfds->delete();
			}
			$time = array(
						'time_in' => $found->nfds_time_in,
						'time_out' => $found->nfds_time_out
						);
				if ($this->input->post('name') == 'timeIn') {
					$time['time_in'] = $this->input->post('value');
				}
				else{
					$time['time_out'] = $this->input->post('value');
				}

			$this->set_schedule(false, $emp_id, $time, array($found->nfds_day));
			// $this->set_emp_sched(array($found->nfds_day),$time,$emp_id);
	}
	public function employee_sched_data($emp_id = false){
		$tableData = array();
		if (!$emp_id) {
			$emp_id = $this->input->post('employee_id');
			
		}
		if ($emp_id == "") {
				$tableData['data'][] = array(
										"Select an employee.",
										"",
										"",
										"");
		}
		else{
			$empSched = $this->emp_schedule($emp_id);
			if (!$empSched) {
				$tableData['data'][] = array("Employee has no schedule.",
											 "",
											 "",
											 "");
			}
			else{
				$tableData = $this->get_table_data($empSched,$emp_id);
			}
		}

		echo json_encode($tableData);
	}
	private function check_conflict2($days = false, $time = false, $empId = false){
		$empSched = $this->emp_schedule($empId);
		$conflicts = [];

		foreach ($days as $key => $value) {
			foreach ($empSched as $key2 => $value2) {
				if ($value2->nfds_day == $value) {
					$existingIn 	= strtotime($value2->nfds_time_in);
					$existingOut 	= strtotime($value2->nfds_time_out);
					$newIn 			= strtotime($time['time_in']);
					$newOut 		= strtotime($time['time_out']);

					if ( ($newIn > $existingIn && $newIn < $existingOut) || ($newOut > $existingIn && $newOut < $existingOut) ) {
						$conflicts[] = $value2;
					}
				}
			}
		}
		return $conflicts;
	}
	public function remove_sched(){

		switch ($this->input->post('table')) {
			case 'eec':
				$this->load->model('eec_nfds');
				$this->eec_nfds->load($this->input->post('table_id'));
				$this->eec_nfds->delete();
				break;
			case 'dept':
				$this->load->model('depts_def_sched_nfds');
				$this->load->model('eec_nfds');
				$this->load->model('employee_est_classifications');

				$eec = new Employee_Est_Classifications;

				$eec = $eec->save_or_get(['employee_id' => $this->input->post('emp_id'), 'est_id' => 1],['employee_id' => $this->input->post('emp_id'), 'est_id' => 1], 'employee_est_classifications');

				$ddsn = new Depts_Def_Sched_Nfds;				
				$ddsn->load($this->input->post('table_id'));

				$eec_sched = new Eec_Nfds;
				$eec_sched->eec_id 	= $eec->eec_id;
				$eec_sched->nfds_id = $ddsn->nfds_id;
				$eec_sched->status 	= 0;
				$eec_sched->save();

				break;
			default:
				# code...
				break;
		}
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
			$data = array('	' => $value->employee_id,
						'fullName' => "<b class='red-text'>".$value->fullName()."</b>",
						'age' => $value->age(),
						'department' => $value->department_name,
						'status' => $value->employment_status);
			$json[] = $data;
		}

		return json_encode($json);
	}
	public function set_emp_sched($days = false, $time = false, $empId = false)
	{
			$this->load->model('employee_est_classifications');
			$this->load->model('non_flexi_daily_scheds');
			$this->load->model('eec_nfds');

			$eec = new Employee_Est_Classifications;
			$eec = $eec->search(array('employee_id' => $empId));
			$eec = reset($eec);

			if(!$eec){
				$eec = new employee_est_classifications;
				$eec->est_id = 1;
				$eec->employee_id = $empId;
				$eec->save();
			}

			foreach ($days as $key => $value) {
				$nfds = new Non_Flexi_Daily_Scheds;
				$timeIn = date('H:i:s', strtotime($time['time_in']));
				$timeOut = date('H:i:s', strtotime($time['time_out']));

				$searchArray = array('nfds_day' => $value,
									 'nfds_time_in' => $timeIn,
									 'nfds_time_out' => $timeOut);

				$nfds = $nfds->save_or_get($searchArray,$searchArray,'non_flexi_daily_scheds');
				
				$eec_nfds = new Eec_Nfds;
				$eec_nfds->eec_id = $eec->eec_id;
				$eec_nfds->nfds_id = $nfds->nfds_id;
				$eec_nfds->status = 1;
				$eec_nfds->save();
			}
	}
	public function view_edit_event()
	{
		$this->load->model($this->input->post('event_type'));
		$class = $this->input->post('event_type');

		$sched = new $class();

		if ($class == "Eec_Nfds") {
			$sched->toJoin = ['non_flexi_daily_scheds' => 'eec_nfds'];
		}

		$sched->load($this->input->post('id'));

		$data = ['sched' => $sched];
		$this->load->view('admin/Schedule/Employee_Schedule/modals/edit_sched_body', $data, FALSE);
	}
	public function edit_sched()
	{
		$this->load->model('employee');


		$toret = ['success' => true,
				  'text'    => "Schedule Updated Successfully!"];

		if ($this->input->post('sched_type') == "irreg") {
			$this->load->model('Emp_irreg_sched');

			$eir = new Emp_irreg_sched;
			$eir->load($this->input->post('emp_irreg_sched_id'));

			$emp = new Employee;
			$emp->load_with_employment_info($eir->employee_id);

			$has_conflict = $emp->check_sched_conflict("irreg", $this->input->post('sched_date'), $this->input->post('time_in'), $this->input->post('time_out') );

			$conflict_obj = false;

			foreach ($has_conflict as $key => $value) {
				if (get_class($value) == 'Emp_irreg_sched') {
					$conflict_obj = $value;
				}
			}


			if ($has_conflict  && $this->input->post('edit_sched_overwrite') == 0 && ( ($conflict_obj && $conflict_obj->emp_irreg_sched_id != $this->input->post('emp_irreg_sched_id')) OR !$conflict_obj )  ) {
				$toret['success'] = false;
				$toret['text'] 	  = "A conflicting schedule has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success override-edit-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";
			}
			else{
				if ($has_conflict) {
					foreach ($has_conflict as $key => $value) {
						if (get_class($value) == "Emp_irreg_sched" && $value->emp_irreg_sched_id != $eir->emp_irreg_sched_id) {

							$eirD = new Emp_irreg_sched;
							$eirD->load($value->emp_irreg_sched_id);
							$eirD->delete();
						}
					}
				}
				$eir->emp_irreg_sched_date     = $this->input->post('sched_date');
				$eir->emp_irreg_sched_time_in  = $this->input->post('time_in');
				$eir->emp_irreg_sched_time_out = $this->input->post('time_out');
				$eir->save();

			}
		}else{
				$this->load->model('eec_nfds');
				$this->load->model('non_flexi_daily_scheds');
				$eecNfds = new Eec_Nfds;
				$eecNfds->load($this->input->post('eec_nfds_id'));

				$eecNfds->start = $this->input->post('date_start');
				// $eecNfds->end = $this->input->post('date_end');

				$nfds = new Non_Flexi_Daily_Scheds;
				$nvals = ['nfds_day' => $this->input->post('day'),
							'nfds_time_in' => $this->input->post('time_in'),
							'nfds_time_out' => $this->input->post('time_out')
						];
				$newNfds = $nfds->save_or_get($nvals,$nvals, 'Non_Flexi_Daily_Scheds');

				$eecNfds->nfds_id = $newNfds->nfds_id;				
				$eecNfds->save();

			}

		echo json_encode($toret);
	}
	public function delete_sched()
	{

		$this->load->model($this->input->post('sched_type'));

		$class    = $this->input->post('sched_type');
		$instance = new $class();
		$instance->load($this->input->post('id'));

		$emp = new Employee;
		$emp->load_with_employment_info($this->input->post('employee_id'));

		if ( $class == 'Depts_Def_Sched_Nfds' ) {

			$this->load->model('eec_nfds');

			$eec_nfds 			= new Eec_Nfds;
			$eec_nfds->eec_id 	= $emp->eec_id;
			$eec_nfds->nfds_id 	= $instance->nfds_id;
			$eec_nfds->status 	= 1;
			$eec_nfds->start 	= $this->input->post('delete_start_date');
			$eec_nfds->end 		=  $this->input->post('delete_end_date') == "" ? $instance->end : $this->input->post('delete_end_date');
			$eec_nfds->deleted_dept_sched = 1;

			$eec_nfds->save();

		}
		elseif ($class == "Department_irregular_sched") {
			$this->load->model('emp_irreg_sched');
			$eir = new Emp_irreg_sched;
			$eir->emp_irreg_sched_date = date('Y-m-d', strtotime($instance->sched_from_date));
			$eir->emp_irreg_sched_time_in = date('H:i', strtotime($instance->sched_from_date));
			$eir->emp_irreg_sched_time_out = date('H:i', strtotime($instance->sched_to_date));
			$eir->employee_id = $this->input->post('employee_id');
			$eir->emp_irreg_sched_status = 0;
			$eir->save();
		}
		else{
			$instance->delete();
		}
 
	}
	public function set_sched($emp_id = false, $schedType = false)
	{
		$emp_id 	= $emp_id ? $emp_id : $this->input->post('employee_id');
		$schedType 	= $schedType ? $schedType : $this->input->post('reg_irreg');

		$this->load->model('eec_nfds');

		$emp = new Employee;
		$emp->load_with_employment_info($emp_id);

		$toret = ['success' => true,
					'txt' 	=> "Schedule has been set successfully!"];

		if ($schedType == 'reg') {
			// check conflicting regular schedule

			$has_conflict = $emp->check_sched_conflict("reg", $this->input->post('days'), $this->input->post('time_in'), $this->input->post('time_out'), $this->input->post('sched_start'), $this->input->post('sched_end') );

			if ($has_conflict && $this->input->post('overwrite') == 0) {
				$theConflict = reset($has_conflict);

				if(date('H:i', strtotime($theConflict->nfds_time_in)) == date('H:i', strtotime($this->input->post('time_in'))) && date('H:i', strtotime($theConflict->nfds_time_out)) == date('H:i', strtotime($this->input->post('time_out'))) ){
					$toret['success'] = false;
					$toret['text'] 		= "Employee's shift already exists.";
				}
				else{
					$toret['success'] = false;
					$toret['text'] 		= "A conflicting shift has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success override-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";
				}

			}
			else{
				if ($has_conflict) {

						$this->load->model('eec_nfds');
						$this->load->model('non_flexi_daily_scheds');
						// overwrite here
						foreach ($has_conflict as $key => $value) {
							if (get_class($value) == "Eec_Nfds") {


								$theSched = new Eec_Nfds;
								$theSched->load($value->eec_nfds_id);

								// $newSchedStartBetween = $this->funcs->range(strtotime($this->input->post('sched_start')), strtotime($value->start), strtotime($value->end));
								// $newSchedEndBetween   = $this->funcs->range(strtotime($this->input->post('sched_end')), strtotime($value->start), strtotime($value->end));

								// if ($this->input->post('sched_end') != "" && $newSchedStartBetween && $newSchedEndBetween) {

								// }
								if ($this->input->post('sched_start') >= $value->start) {
									$theSched->delete();
								}
								else{
									$theSched->end = date('Y-m-d',strtotime($this->input->post('sched_start')." - 1 day"));
									$theSched->save();
								}
							}
						}
					}

					foreach ($this->input->post('days') as $key => $value) {
						$nfds = new Non_Flexi_Daily_Scheds;
						$searched = ['nfds_day' 		=> $value,
									 'nfds_time_in' 	=> $this->input->post('time_in'),
									 'nfds_time_out' 	=> $this->input->post('time_out')];


						$sched = $nfds->save_or_get($searched,$searched,'Non_Flexi_Daily_Scheds');

						// search if just disabled in eecNfds
						$forSearch = new Eec_Nfds;
						$disabled = $forSearch->pop([   'eec_id'  => $emp->eec_id,
														'nfds_id' => $sched->nfds_id,
														'start'   => $this->input->post('sched_start'),
														'status'  => 0
														]);

						if ($disabled->eec_nfds_id != "") {
							$disabled->status = 1;
							$disabled->save();
						}
						else{
							

							$eec_nfds 			= new Eec_Nfds;
							$eec_nfds->eec_id 	= $emp->eec_id;
							$eec_nfds->nfds_id 	= $sched->nfds_id;
							$eec_nfds->start    = $this->input->post('sched_start');
							$eec_nfds->end  	= $this->input->post('sched_end') != "" ? $this->input->post('sched_end') : null;
							$eec_nfds->status 	= 1;
							$eec_nfds->save();

							
														

						}
					}
					$endDate = $this->input->post('sched_end') != "" ? $this->input->post('sched_end') : date('Y-m-d');
					$emp->rematch_logs($this->input->post('sched_start'), $endDate);
			}

		}
		else{
			$this->load->model('Emp_irreg_sched');
			$has_conflict = $emp->check_sched_conflict("irreg", $this->input->post('irreg_dates'), $this->input->post('time_in'), $this->input->post('time_out'), $this->input->post('sched_start') );

			if ($has_conflict && $this->input->post('overwrite') == 0) {
				$toret['success'] = false;
				$toret['text'] 		= "A conflicting schedule has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success override-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";
			}
			else{
				if ($has_conflict) {
					foreach ($has_conflict as $key => $value) {
						if (get_class($value) == "Emp_irreg_sched") {
							$eirD = new Emp_irreg_sched;
							$eirD->load($value->emp_irreg_sched_id);
							$eirD->delete();
						}
					}
				}

				$sched_days = explode(',', $this->input->post('irreg_dates'));

				foreach ($sched_days as $key => $value) {
					$eir = new Emp_irreg_sched;
					$eir->emp_irreg_sched_date = date('Y-m-d',strtotime($value));
					$eir->emp_irreg_sched_time_in = $this->input->post('time_in');
					$eir->emp_irreg_sched_time_out = $this->input->post('time_out');
					$eir->employee_id = $emp->employee_id;
					$eir->emp_irreg_sched_status = 1;
					$eir->save();

					$emp->rematch_logs(date('Y-m-d',strtotime($value)), date('Y-m-d',strtotime($value)));
				}

			}

		}

		echo json_encode($toret);
	}
	// karaan
	public function set_schedule($override = false, $emp_id = false, $time = false, $days = false)
	{
		$toret  = array();
		$emp_id = $emp_id 	!= false ? $emp_id : $this->input->post('employee_id');
		$time   = $time 	!= false ? $time : $this->input->post('sched');
		$days   = $days 	!= false ? $days : $this->input->post('days');

		if ($override) {
			$hasConflict = $this->check_conflict($days, $time, $emp_id);
			foreach ($hasConflict as $key => $value) {
					if (isset($value->eec_nfds_id)) {
						$this->load->model('eec_nfds');
						$eecNfds = new Eec_Nfds;
						$eecNfds->load($value->eec_nfds_id);
						$eecNfds->delete();
					}
			}
			$this->set_emp_sched($days, $time, $emp_id);
			$toret['success'] = true;
			$toret['view'] = $this->load->view('shared/success', array('successMsg' => "Employee Schedule Updated!"), TRUE);
		}
		else{
			if (!$emp_id) {
				$toret['success'] = false;
				$toret['view'] = "No Employee Selected.";
			}
			elseif (!$time) {
				$toret['success'] = false;
				$toret['view'] = "Invalid Time Value";
			}
			elseif (!$days) {
				$toret['success'] = false;
				$toret['view'] = "Select Day/s of Schedule";
			}
			elseif (strtotime($time['time_in']) >= strtotime($time['time_out'])) {
				$toret['success'] = false;
				$toret['view'] =  "Invalid Time Span";
			}
			else{
				$hasConflict = $this->check_conflict($days,$time,$emp_id);
				if ($hasConflict) {
					$toret['success'] = false;
					$toret['view'] = "Conflict found in employee's schedule set on ".  count($hasConflict) ." other shifts<br>
											<a class='btn btn-warning btn-flat overrideBTN' href='#'>Override Existing Schedule</a> <a class='btn btn-info btn-flat' href='#'>Cancel</a>";
				}
				else{
					$this->set_emp_sched($days, $time, $emp_id);
					$toret['success'] = true;
					$toret['view'] = $this->load->view('shared/success', array('successMsg' => "Employee Schedule Updated!"), TRUE);
				}
			}
		}
		echo json_encode($toret);
	}
	public function override_sched()
	{
		$this->set_schedule(true);
	}
	public function revert_to_department()
	{
		$toret = array();
		$this->load->model('eec_nfds');
		$empSched = new Eec_Nfds;
		$empSched->toJoin = array('employee_est_classifications' => 'eec_nfds');
		$scheds = $empSched->search(array('employee_est_classifications.employee_id' => $this->input->post('employee_id')));
		foreach ($scheds as $key => $value) {
			$value->delete();
		}
		$toret['success'] = true;
		$toret['view'] = $this->load->view('shared/success', array('successMsg' => 'Employee Schedule Reverted!'), TRUE);
		echo json_encode($toret);
	}
	public function revert_entire_dept()
	{
		$toret = array();
		$this->load->model('employee');
		$this->load->model('eec_nfds');

		$deptOfEmp = new Employee;
		$deptOfEmp->toJoin = array('employment' => 'employee',
									'department' => 'employment');
		$employmentInfo = $deptOfEmp->search(array('employees.employee_id' => $this->input->post('employee_id')));
		$empInfo = reset($employmentInfo);

		$allEmps = new Eec_Nfds;
		$allEmps->toJoin = array('employee_est_classifications' => 'eec_nfds',
								'employee' => 'employee_est_classifications',
								'employment' => 'employee');
		$allInDept = $allEmps->search(array('employment.department_id' => $empInfo->department_id));

		foreach ($allInDept as $key => $value) {
			$value->delete();
		}

		$toret['success'] = true;
		$toret['view'] = $this->load->view('shared/success', array('successMsg' => "All Schedule of Employees in {$empInfo->department_name} Department Have Been Reverted to Their Department's Schedule!"), TRUE);
		echo json_encode($toret);
	}
	public function revert_all()
	{
		$toret = array();

		$this->load->model('eec_nfds');
		$eecNfds = new Eec_Nfds;
		$eecNfds->empty_table();

		$toret['success'] = true;
		$toret['view'] = $this->load->view('shared/success', array('successMsg' => "All Employees' Schedule Have Been Reverted Back to Their Department's Schedule!"), TRUE);
		echo json_encode($toret);
	}
}
?>
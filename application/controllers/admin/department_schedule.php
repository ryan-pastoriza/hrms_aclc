<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_Schedule extends MY_Controller {



	public function test()
	{
		$this->load->model('department');
		$dept = new Department;
		$dept->load(15);

		$sched = $dept->check_sched_conflict("09/14/2017", ['time_in' => '08:00 am', 'time_out' => '12:00 pm'], "irreg");

		echo "<pre>";
		print_r ($sched);
		echo "</pre>";

	}
	// updated on September 4, 2017
	public function index()
	{
		$this->load->model('department');

		$allDepts = $this->department->search(array('department_status' => "active"));
		$data = array('allDepts' => $allDepts,
					'deptSched' => array());

		$this->create_head_and_navi([
										// asset_url('plugins/momentjs/moment.js'),
										asset_url("plugins/jQueryUI/jquery-ui.min.js"),
										asset_url("plugins/iCheck/icheck.min.js"),
										asset_url('plugins/daterangepicker/moment.js'),
										asset_url('plugins/fullcalendar/fullcalendar.min.js'),
										// asset_url('plugins/datatables/jquery.dataTables.min.js'),
										// asset_url('plugins/datatables/dataTables.bootstrap.min.js'),
										asset_url('plugins/multidatespicker/jquery-ui.multidatespicker.js'),
										asset_url('plugins/select2/select2.full.min.js'),
									],
									[
										asset_url('plugins/fullcalendar/fullcalendar.min.css'),
										asset_url('plugins/select2/select2.min.css'),
										// asset_url('plugins/fullcalendar/fullcalendar.print.css'),
										asset_url("plugins/iCheck/all.css"),
										asset_url('plugins/datatables/dataTables.bootstrap.css'),
										asset_url('plugins/jQueryUI/jquery-ui.structure.css'),
										asset_url('plugins/jQueryUI/jquery-ui.theme.css'),
										asset_url('plugins/multidatespicker/jquery-ui.multidatespicker.css'),
									]);
		create_content([
							'contentHeader' => "Department Schedule",
							'content' => $this->load->view('admin/Schedule/Department_Schedule/main',$data,TRUE)
						]);
		$this->create_footer([
								// $this->load->view('admin/Schedule/Department_Schedule/jscripts',[], TRUE),
								// $this->load->view('admin/Schedule/Department_Schedule/widget/jscripts',[], TRUE),
								]);
	}
	// end of updated on September 4, 2017
	public function cal_events()
	{
		
		$objs = [];
		
		if ($this->input->post('department_id') != "") {
			$this->load->model('department');
			$dept = new Department;
			$dept->load($this->input->post('department_id'));
			$objs = $this->objectify_schedule($dept->calendar_sched());
		}

		echo json_encode($objs);
	}
	public function objectify_schedule($schedule)
	{
		$objs = [];
		$dows = ['mon' => 1,'tue' => 2,'wed' => 3,'thu' => 4,'fri' => 5,'sat' => 6,'sun' => 7];

		foreach ($schedule as $key => $value) {

			$anObj = [];

			if (get_class($value) == "Depts_Def_Sched_Nfds") {
				$anObj = [	'title' 			=> date('h:i a', strtotime($value->nfds_time_in))." - ". date('h:i a', strtotime($value->nfds_time_out)) ,
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
							'displayEventTime' 	=> false,
							'color' 			=> '#33cc33',
							'objectClass' 		=> "Depts_Def_Sched_Nfds",
							'sched_obj' 		=> $value ];
			}
			else{
				$anObj = [	'title' 			=> date('h:i a', strtotime($value->sched_from_date))." - ". date('h:i a', strtotime($value->sched_to_date))." <br> Irregular Schedule" ,
							'start' 			=> date("Y-m-d H:i", strtotime($value->sched_from_date)),
							'end' 				=> date("Y-m-d H:i", strtotime($value->sched_to_date)),
							'sched_id' 			=> $value->dis_id,
							'schedType' 		=> "irreg",
							'color'				=> "#ff6633",
							'allDay' 			=> false,
							'displayEventTime' 	=> false,
							'objectClass' 		=> get_class($value),
							'sched_obj' 		=> $value ];
			}

			$objs[] = $anObj;

		}
		return $objs;
	}
	public function edit_sched()
	{
		$this->load->model('department');
		$this->load->model('depts_def_sched_nfds');
		$this->load->model('non_flexi_daily_scheds');
		$this->load->model('department_irregular_sched');

		$dept = new Department;
		$dept->load($this->input->post('department_id'));

		$toret = ['success' => true,
					'txt' => 'Schedule successfully!'];


		if ($this->input->post('sched_type') == 'reg') {

			$hasConflict = $dept->check_sched_conflict([$this->input->post('day')],['time_in' => $this->input->post('time_in'), 'time_out' => $this->input->post('time_out')], "reg");

			if ($hasConflict && $this->input->post('edit_sched_overwrite') == 0) {
				$toret['success'] = false;
				$toret['txt'] 	= "A conflicting schedule has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success update-override-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";

			}
			else{

				if ($hasConflict && $this->input->post('edit_sched_overwrite') == 1 ) {
					foreach ($hasConflict as $key => $value) {
						if ( $value->ddsnfds_id != $this->input->post('ddsnfds_id')) {
							$toOverwrite = new Depts_Def_Sched_Nfds;
							$toOverwrite->load($value->ddsnfds_id);
							$toOverwrite->end = date('Y-m-d', strtotime($this->input->post('date_start')." - 1 day" ));
							$toOverwrite->save();
						}
					}
					
				}
				$ddsnfds = new Depts_Def_Sched_Nfds;
				$ddsnfds->toJoin = ['non_flexi_daily_scheds' => 'depts_def_sched_nfds'];

				$ddsnfds->load($this->input->post('ddsnfds_id'));

				$ddsNfds = new Depts_Def_Sched_Nfds;
				$ddsNfds->load($this->input->post('ddsnfds_id'));


				if ($ddsnfds->nfds_time_in != $this->input->post('time_in') || $ddsnfds->nfds_time_out != $this->input->post('time_out') || $ddsnfds->nfds_day != $this->input->post('day')) {
					$nfds = new Non_Flexi_Daily_Scheds;
					$nfds = $nfds->save_or_get([
												'nfds_day' 		=> $this->input->post('day'),
												'nfds_time_in' 	=> $this->input->post('time_in'),
												'nfds_time_out' => $this->input->post('time_out')
												],
												[
												'nfds_day' 		=> $this->input->post('day'),
												'nfds_time_in' 	=> $this->input->post('time_in'),
												'nfds_time_out' => $this->input->post('time_out')
												],'Non_Flexi_Daily_Scheds');

					$ddsNfds->nfds_id  = $nfds->nfds_id;
				}

					$ddsNfds->start = $this->input->post('date_start');
					$ddsNfds->save();

			}
		}
		else{
			$hasConflict = $dept->check_sched_conflict($this->input->post('sched_from_date'), ['time_in' => $this->input->post('sched_time_in'), 'time_out' => $this->input->post('sched_time_out')], "irreg");

			if ($hasConflict && $this->input->post('edit_sched_overwrite') == 0) {
				$toret['success'] = false;
				$toret['txt'] 	= "A conflicting schedule has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success update-override-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";
			}
			else{

				foreach ($hasConflict as $key => $value) {
					if (get_class($hasConflict) == 'Department_irregular_sched') {
					// delete conflicting schedule
						$dis = new Department_irregular_sched;
						$dis->load($hasConflict->dis_id);
						$dis->delete();
					}

				}
					// set scehdule
					$dis = new Department_irregular_sched;
					$dis->load($this->input->post('dis_id'));
					$dis->sched_from_date = $this->input->post('sched_from_date')." ".$this->input->post('sched_time_in');
					$dis->sched_to_date   = $this->input->post('sched_from_date')." ".$this->input->post('sched_time_out');
					$dis->save();
			}

		}

		echo json_encode($toret);
	}
	public function delete_sched()
	{
		if ($this->input->post('sched_type') == "reg") {
			$this->load->model('depts_def_sched_nfds');
			$ddsnfds = new Depts_Def_Sched_Nfds;
			$ddsnfds->load($this->input->post('id'));
			$ddsnfds->delete();
		}
		else{
			$this->load->model('department_irregular_sched');
			$dis = new Department_irregular_sched;
			$dis->load($this->input->post('id'));
			$dis->delete();

		}
	}
	public function edit_schedule_view()
	{

		if ($this->input->post('event_type') == "Depts_Def_Sched_Nfds") {
			$this->load->model('depts_def_sched_nfds');
			$ddsnfds = new Depts_Def_Sched_Nfds;
			$ddsnfds->toJoin = ['non_flexi_daily_scheds' => 'depts_def_sched_nfds'];
			$ddsnfds->load($this->input->post('id'));
		}else{
			$this->load->model('department_irregular_sched');
			$ddsnfds = new Department_irregular_sched;
			$ddsnfds->load($this->input->post('id'));

		}



		$data = ['sched' => $ddsnfds];
		$this->load->view('admin/schedule/Department_Schedule/modals/edit_sched_body', $data, FALSE);
	}
	public function set_sched()
	{
		$this->load->model('department');
		$dept = new Department;
		$dept->load($this->input->post('department_id'));

		$toret = ['success' => true];

		$sched_time = ['time_in' 	=> $this->input->post('time_in'),
						'time_out' 	=> $this->input->post('time_out')];

		if ($this->input->post('regirreg')) {
			$this->load->model('depts_def_sched_nfds');
			$this->load->model('non_flexi_daily_scheds');


			$hasConflict = $dept->check_sched_conflict( $this->input->post('sched_days'), $sched_time, 'reg' );

			if ($hasConflict && $this->input->post('overwrite') == 0) {

				$toret['success'] 	= false;
				$toret['text'] 		= "A conflicting schedule has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success override-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";
			}
			else{

				if ($hasConflict) {
					foreach ($hasConflict as $key => $value) {
						$conflict = new Depts_Def_Sched_Nfds;
						$conflict->load($value->ddsnfds_id);
						$conflict->end = date("Y-m-d", strtotime($this->input->post('date_start')." - 1 day"));
						$conflict->save();
					}


				}

				foreach ($this->input->post('sched_days') as $key => $value) {
					$nfds = new Non_Flexi_Daily_Scheds;
					$nfds = $nfds->save_or_get([
												'nfds_day' 		=> $value,
												'nfds_time_in' 	=> $this->input->post('time_in'),
												'nfds_time_out' => $this->input->post('time_out')
												],
												[
												'nfds_day' 		=> $value,
												'nfds_time_in' 	=> $this->input->post('time_in'),
												'nfds_time_out' => $this->input->post('time_out')
												],
												'Non_Flexi_Daily_Scheds');


					$ddnfds = new Depts_Def_Sched_Nfds;

					$ddnfds->nfds_id 		= $nfds->nfds_id;
					$ddnfds->department_id 	= $this->input->post('department_id');
					$ddnfds->start 			= $this->input->post('date_start');
					$ddnfds->end 			= $this->input->post('date_end') != "" ? $this->input->post('date_end') : null;

					$ddnfds->save();
					
					$endDate = $this->input->post('date_end') != "" ? $this->input->post('date_end') : date('Y-m-d');

					$this->update_logs($dept, $this->input->post('date_start'), $endDate);
				}
			}
		}
		else{
			$hasConflict = $dept->check_sched_conflict($this->input->post('irreg_dates'), $sched_time, "irreg");

			if ($hasConflict && $this->input->post('overwrite') == 0) {

				$toret['success'] 	= false;
				$toret['text'] 		= "A conflicting schedule has been detected.<br>Would you like to override the existing schedule? <hr><button class='btn btn-xs btn-success override-btn'>YES</button> <button class='btn btn-xs btn-danger'>NO</button>";
			}
			else{
				foreach ($hasConflict as $key => $value) {
					if (get_class($value) == "Department_irregular_sched") {
						$value->delete();
					}
				}

				$this->load->model('department_irregular_sched');
				$dates = explode(",", $this->input->post('irreg_dates'));

				foreach ($dates as $key => $value) {
					$date = date('Y-m-d', strtotime($value));

					$dis = new Department_irregular_sched;
					$dis->department_id = $this->input->post('department_id');
					$dis->sched_from_date = $date." ".$this->input->post('time_in');
					$dis->sched_to_date = $date." ".$this->input->post('time_out');
					$dis->save();

					$this->update_logs($dept, $date, $date);

				}

				


			}
		}

		echo json_encode($toret);
	}
	public function index2(){
		$this->load->model('department');

		$allDepts = $this->department->search(array('department_status' => "active"));
		$data = array('allDepts' => $allDepts,
					'deptSched' => array());

		$this->create_head_and_navi([
										asset_url('plugins/datatables/jquery.dataTables.min.js'),
										asset_url('plugins/datatables/dataTables.bootstrap.min.js'),
									],
									[
										asset_url('plugins/datatables/dataTables.bootstrap.css'),
									]);
		create_content([
							'contentHeader' => "Department Schedule",
							'content' => $this->load->view('admin/Schedule/Department_Schedule/department_schedule',$data,TRUE)
						]);
		$this->create_footer([
								$this->load->view('admin/Schedule/Department_Schedule/jscripts',[], TRUE),
								$this->load->view('admin/Schedule/Department_Schedule/widget/jscripts',[], TRUE),
								]);
		// $this->load->view('admin/header');
		// $this->load->view('admin/navigation');
		// $this->load->view('admin/Schedule/Department_Schedule/department_schedule',$data);
	}
	public function save_nonflexi_sched($sched_days = FALSE, $sched_time = FALSE, $department_id = FALSE, $est_id = FALSE){
		$toret = array();

		$this->load->model('depts_def_sched_nfds');
		$this->load->model('non_flexi_daily_scheds');

		$ddsnfds = new Depts_Def_Sched_Nfds;
		
		
		if(!$sched_days){

			$sched_days = $this->input->post('sched_days');
			$sched_time = $this->input->post('sched_time');
			$department_id = $this->input->post('department_id');
			$est_id = $this->input->post('est_id');

		}
		$sched_time['time_in'] = date('H:i:s',strtotime($sched_time['time_in']));
		$sched_time['time_out'] = date('H:i:s',strtotime($sched_time['time_out']));

		$foundConflict = $this->check_schedule_conflict($department_id,$sched_days,$sched_time);

		if ($foundConflict) {

			$time_in = date('g:i:s a',strtotime($foundConflict->nfds_time_in));
			$time_out = date('g:i:s a',strtotime($foundConflict->nfds_time_out));
			$day = date('l',strtotime($foundConflict->nfds_day));

			$data['errorMsg'] = "There is a conflict with {$foundConflict->department_name} department's schedule on {$day} at {$time_in} to {$time_out} ";
			$toret['success'] = false;
			$toret['view'] = $this->load->view('shared/error',$data,TRUE);
			echo json_encode($toret);
		}else{

			if(empty($sched_days)){
				$data['errorMsg'] = 'Setting schedule failed, <br/>
						no day selected.';
				$toret['success'] = false;
				$toret['view'] = $this->load->view('shared/error',$data,TRUE);
				echo json_encode($toret);
			}
			else if(strtotime($sched_time['time_out']) < strtotime($sched_time['time_in']) || strtotime($sched_time['time_out']) == strtotime($sched_time['time_in'])) {
				$data['errorMsg'] = 'Setting schedule failed,<br />
						invalid time span.';
				$toret['success'] = false;
				$toret['view'] = $this->load->view('shared/error',$data,TRUE);

				echo json_encode($toret);

			}else if($department_id == FALSE || $department_id == "" ){
				$data['errorMsg'] = 'Setting schedule failed,<br />
						no department selected.';
				$toret['success'] = false;
				$toret['view'] = $this->load->view('shared/error',$data,TRUE);
				echo json_encode($toret);

			}else{
				foreach ($sched_days as $key => $value) {
					$nfds = new Non_Flexi_Daily_Scheds;
					$nfds = $nfds->save_or_get(array('nfds_day' => $value,'nfds_time_in' => $sched_time['time_in'],'nfds_time_out' => $sched_time['time_out']),
									   array('nfds_day' => $value,'nfds_time_in' => $sched_time['time_in'],'nfds_time_out' => $sched_time['time_out']),
									   'Non_Flexi_Daily_Scheds');
					$ddsnfds = new Depts_Def_Sched_Nfds;
					$ddsnfds->department_id = $department_id;
					$ddsnfds->nfds_id = $nfds->nfds_id;
					$ddsnfds->save();
				}
				$data['successMsg'] = "Department Schedule Saved.";
				$toret['success'] = true;
				$toret['view'] = $this->load->view('shared/success',$data,TRUE);
				echo json_encode($toret);
			}
		}
				

				/*
					TODO: check if department is to be assigned a new sched type. if to be assigned, ask if user agrees; 
					if user agrees, then change sched type before saving schedule. If not, then do nothing
				*/
	}
	private function check_sched_conflict($department_id = false, $sched_days = false, $sched_time = false, $sched_type = false)
	{
		$this->load->model('department');

		$dept = new Department;
		$dept->load($department_id);

		$in 	= strtotime($sched_time['time_in']);
		$out 	= strtotime($sched_time['time_out']);

		if ($sched_type == 'reg') {
			$reg_sched = $dept->reg_sched();

			foreach ($reg_sched as $key => $value) {
				if ( in_array($value->nfds_day, $sched_days) ) {
					$schedIn = strtotime($value->nfds_time_in);
					$schedOut = strtotime($value->nfds_time_out);

					$in_range = $this->funcs->range($in, $schedIn, $schedOut);
					$out_range = $this->funcs->range($out, $schedIn, $schedOut);

					if ($in_range || $out_range) {
						return $value;
					}
				}
			}

		}
		else{
			foreach ($sched_days as $key => $value) {
				$sched = $dept->sched($value, $value);

				foreach ($sched as $key2 => $value2) {
					if (get_class($value2) == "Department_irregular_sched") {
						$schedIn = date('H:i', strtotime($value2->sched_from_date));
						$schedOut = date('H:i', strtotime($value2->sched_to_date));

						$schedIn = strtotime($schedIn);
						$schedOut = strtotime($schedOut);

					}else{
						$schedIn = strtotime($value2->nfds_time_in);
						$schedOut = strtotime($value2->nfds_time_out);						
					}

					$in_range = $this->funcs->range($schedIn, $in, $out);
					$out_range = $this->funcs->range($schedOut, $in, $out);

					if ($in_range || $out_range) {
						return $value2;
					}
				}

			}
		}
		return false;
	}
	// private function check_schedule_conflict($department_id = FALSE, $sched_days = FALSE, $sched_time = FALSE) {
	// 	$this->load->model('depts_def_sched_nfds');

	// 	if (!empty($sched_days)) {
	// 		foreach ($sched_days as $key => $value) {
	// 			$ddsnfds = new Depts_Def_Sched_Nfds;
	// 			$ddsnfds->toJoin = array('non_flexi_daily_scheds' => 'depts_def_sched_nfds',
	// 									'department' => 'depts_def_sched_nfds' );
	// 			$ddsnfds->db->order_by("depts_def_sched_nfds.start","desc");
	// 			$ddsnfds->db->where("depts_def_sched_nfds.department_id = {$department_id}")
	// 					->where("((non_flexi_daily_scheds.nfds_time_in BETWEEN '{$sched_time['time_in']}' AND '{$sched_time['time_out']}') OR (non_flexi_daily_scheds.nfds_time_out BETWEEN '{$sched_time['time_in']}' AND '{$sched_time['time_out']}'))")
	// 					->where("(non_flexi_daily_scheds.nfds_day = '{$value}')");
	// 			$allDdsnfds = $ddsnfds->get();
	// 			if(count($allDdsnfds) > 0 ){
	// 				return reset($allDdsnfds);
	// 			}
	// 		}
	// 	}
	// 		return false;
	// }
	public function update_schedule($ddnfds_id = FALSE, $sched_days = FALSE, $sched_time = FALSE) {
		$toret = array();
		$this->load->model('depts_def_sched_nfds');
		$this->load->model('non_flexi_daily_scheds');

		$ddsnfds = new Depts_Def_Sched_Nfds;
		$nfds = new Non_Flexi_Daily_Scheds;

		

		$foundConflict = $this->check_schedule_conflict($ddnfds_id,$sched_days,$sched_time);
		if($foundConflict){
			$time_in = date('g:i:s a',strtotime($foundConflict->nfds_time_in));
			$time_out = date('g:i:s a',strtotime($foundConflict->nfds_time_out));
			$day = date('l',strtotime($foundConflict->nfds_day));

			$msg = "There is a conflict with {$foundConflict->department_name} department's schedule on {$day} at {$time_in} to {$time_out} ";
			$toret['success'] = false;
			$toret['view'] = $msg;
			return $toret;
		}else{
			$ddsnfds->load($ddnfds_id);
			foreach ($shed_days as $key => $value) {
				$nfds->nfds_day = $value;
				$nfds->nfds_time_in = $sched_time['time_in'];
				$nfds->nfds_time_out = $sched_time['time_out'];
				$nfds->save();
			}
			$msg = "Department Schedule Updated!";
			$toret['success'] = true;
			$toret['view'] = $msg;
			return $toret;
		}
	}
	public function remove_sched()
	{
		$this->load->model('depts_def_sched_nfds');
		$ddsn = new Depts_Def_Sched_Nfds;
		$ddsn->load($this->input->post('ddsnfds_id'));
		$ddsn->delete();
	}
	public function view_sched() {
		$this->load->model('non_flexi_daily_scheds');
		$deptSched = array();
		if ($this->input->post('department_id')) {
			$nfds = new Non_Flexi_Daily_Scheds();
			$nfds->toJoin = array("depts_def_sched_nfds" => "non_flexi_daily_scheds",
								 "department" => "depts_def_sched_nfds");
			$deptSched = $nfds->search("departments.department_id = {$this->input->post('department_id')}");
		}

		echo json_encode($this->data_table($deptSched));
	}
	private function data_table($deptSched)
	{
		$data = array();
		if ($deptSched) {
			
			foreach ($deptSched as $key => $value) {
			$menu = $this->load->view('admin/Schedule/Department_Schedule/widget/dropdown_menu', array('ddsnfds_id' => $value->ddsnfds_id), TRUE);
			$day  = date('l',strtotime($value->nfds_day));
			$time_in = date('g:i:s a',strtotime($value->nfds_time_in));
			$time_out = date('g:i:s a', strtotime($value->nfds_time_out));

			$data['data'][] = array(
								$day,
								$time_in,
								$time_out,
								$menu
								);
			}
		}else{
			$dept = "SELECT DEPARTMENT";
			if ($this->input->post('department_id')) {
				$dept = "DEPARTMENT HAS NO SCHEDULE YET";
			}
			$data['data'][] = array($dept,
									"",
									"",
									"");
		}

		return $data; 
	}
	public function update_logs($dept_object = false, $from = false, $to = false)
	{
		set_time_limit(0);
		$emps = $dept_object->employees();
		foreach ($emps as $key => $value) {
			$emp = new Employee;
			$emp->load_with_employment_info($value->employee_id);
			$emp->rematch_logs($from, $to);
		}
	}

}
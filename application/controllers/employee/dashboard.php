<?php
/**
 * @Author: gian
 * @Date:   2016-07-18 09:10:33
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-25 15:30:38
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Dashboard extends MY_Controller{
	public function index(){
		$data["credits"] = $this->emp_json();
		$data["requirement"] = $this->disp_emp_requirement();
		$data["has_requirement"] = $this->has_requirement();
		$this->create_head_and_navi(
									[
										asset_url("plugins/datatables/jquery.dataTables.js"),
										asset_url("plugins/datatables/dataTables.bootstrap.js"),
										asset_url('plugins/momentjs/moment.js'),
										asset_url("plugins/iCheck/icheck.min.js"),
										asset_url("plugins/fullcalendar/fullcalendar.js"),
										asset_url("plugins/fullcalendar/fullcalendar.print.js")

									],
									[
										asset_url("plugins/datatables/dataTables.bootstrap.css"),
										asset_url("plugins/morris/morris.css"),
										asset_url("plugins/fullcalendar/fullcalendar.css"),
										asset_url("plugins/iCheck/all.css"),

									]
								   );
		$req_cal = "<div class='col-sm-12 row'>".
												$this->load->view("employee/dashboard_widget/requirement_preview",$data,TRUE).
							  					$this->load->view("employee/dashboard_widget/calendar_preview",[],TRUE)	."
					</div>";
		create_content(
						array( "contentHeader" => "Home",
							  "breadCrumbs" => true,
							  "content" => 
							  				[
							  					$this->load->view("employee/dashboard_widget/absence_preview",[],TRUE),
							  					$this->load->view("employee/dashboard_widget/leave_preview",$data,TRUE),
							  					$this->load->view("employee/dashboard_widget/logfailure_preview",[],TRUE),
							  					$req_cal
							  					
							  				]
						)
				  	  );
		$this->create_footer();
	}

	


	public function get_emp_logfailure(){
		$this->load->model("emp_log_fail_requests");
		$lfr = new Emp_Log_Fail_Requests;
		$data = array("data" => array());
		$empLfr = $lfr->search(
						[
							"employee_id" => $this->session->userdata("DP_USER_ID")
						]
					);
		foreach ($empLfr as $key => $value) {
			$data["data"][] = array(
										$value->emp_lfr_filed,
										$value->emp_lfr_login == "" ? "<span style='color:red;'>Empty</span>" : $value->emp_lfr_login,
										$value->emp_lfr_logout == "" ? "<span style='color:red;'>Empty</span>" : $value->emp_lfr_logout,
										$value->emp_lfr_reason
								   );
		}
		echo json_encode($data);
	}


	// leave widget

	public function emp_json()
	{
		
		$earned = $this->fetch_emp_leave_info($this->session->userdata("DP_USER_ID"));
		
		$data = array(
					'vac_earned' 		=> $earned['vacation']['earned'],
					'vac_used' 			=> $earned['vacation']['used'],
					'vac_balance'		=> $earned['vacation']['earned'] - $earned['vacation']['used'],
					'sick_earned' 	=> $earned['sick']['earned'],
					'sick_used'		=> $earned['sick']['used'],
					'sick_balance' 	=> $earned['sick']['earned'] - $earned['sick']['used'],
					);
		return $data;
		// return json_encode($data);
	}
	public function fetch_emp_leave_info($emp_id)
	{
		$this->load->model('employee');
		$this->load->model('employee_leave');

		$emp 	= new Employee;
		$emp->load($emp_id);
		$tenure = $emp->tenure();

		$leave 		= new Employee_Leave;
		$leaveUsed 	= $leave->search(
										[
											'employee_id' 			=> $emp_id,
											'YEAR(emp_leave_from)' 	=> date('Y'),
											'emp_leave_with_pay' 	=> 1
										]
									);


		$leave_info 	= [];
		$totalUsed 		= 0;
		$totalSickUsed 	= 0;

		foreach ($leaveUsed as $key => $value) {
			if ($value->emp_leave_availment == 'Vacation Leave') {
				$totalUsed += $value->emp_leave_days;
				$totalUsed += round($value->emp_leave_hours / 8,2); 
			}
			elseif($value->emp_leave_availment == 'Sick Leave'){
				$totalSickUsed += $value->emp_leave_days;
				$totalSickUsed += round($value->emp_leave_hours / 8,2);
			}
		}

		$leave_info['vacation']['used'] = $totalUsed;
		$leave_info['sick']['earned'] 	= 15;
		$leave_info['sick']['used'] 	= $totalSickUsed;

		if($tenure['years'] >= 1 || $tenure['months'] > 6 ){
			if (date('Y',strtotime($emp->employment_hired_date)) == date('Y') ) {
				$leave_info['vacation']['earned'] = $tenure['months'] * 1.25;
			}
			else{
				$leave_info['vacation']['earned'] = (date('m') - 1) * 1.25 ;
			}
		}
		else{
			$leave_info['vacation']['earned'] = 0; 
		}

		return $leave_info;
	}
	// checklist requirement
	public function disp_emp_requirement(){

		$this->load->model("employee_requirement");
		$er = new employee_requirement;
		$requirement = $er->get();
		return $requirement;

	}

	public function has_requirement(){
		$this->load->model("employment_requirement_checklist");
		$erc = new Employment_Requirement_Checklist;
		$data = $erc->search(
						[
							"employee_id"	=> $this->session->userdata("DP_USER_ID")
						]
					);
		// echo "<pre>";
		// print_r($data);
		return $data;

	}


	// CALENDAR !
public function show_event(){
		$this->load->model("events");
		$event = new Events;

		$data = array();
		$ret = array();
		$mData = array();
		$getAllEvents = $event->get();

		foreach ($getAllEvents as $key => $value) {
			if($value->type == "one day"){
				$data = [
							'title' => $value->title,
							'start' => $value->start_date,
							'end' => $value->end_date,
							'backgroundColor' => $value->backgroundColor,
							'event_id'	=> $value->event_id,
							"allDay" => false,
						];
				$ret[]  = $data;
			}
			if($value->type == "long event"){
				$endD = new DateTIme($value->end_date);
				$endD->modify("+1 day");

				$data = [
							'title' => $value->title,
							'start' => $value->start_date,
							'end'	=> $endD->format("Y-m-d"),
							'backgroundColor' => $value->backgroundColor,
							'event_id' => $value->event_id,
							"allDay" => false,
						];
				$ret[] = $data;
			}

			if($value->repeat == "monthly"){

				$frm_date = explode("-", $value->start_date);
				$nd_date = explode("-", $value->end_date);
				for($i = 1 ; $i <= 12;$i++){
					if($value->repeat == "monthly"){
							$data = [
										"title" => $value->title,
										"start"	=> date("Y-m-d",strtotime($frm_date[0]."-".$i."-".$frm_date[2])),//."T20:00:00",
										"end"	=> date("Y-m-d",strtotime($nd_date[0]."-".$i."-".$nd_date[2])),//."T02:00:00",
										"backgroundColor" => $value->backgroundColor,
										"event_id" => $value->event_id,
										"allDay" => false,
									];
							$ret[] = $data;
					}
				}

			}


			if($value->repeat == "string"){
				for($i = 2015; $i <= date("Y")+10;$i++){
					if($value->repeat == "string"){
						$rep = new DateTime($value->string . " " .$i);
						$data = [
									'title' => $value->title,
									'start'	=> date("Y-m-d",strtotime($rep->format("Y-m-d"))),
									'end' => date("Y-m-d",strtotime($rep->format("Y-m-d"))),
									'backgroundColor' => $value->backgroundColor,
									'event_id' => $value->event_id,
									"allDay" => false,

								];
						$ret[] = $data;
					}
				}
			}

			if($value->repeat == "date"){
				$frm = explode("-", $value->start_date);
				$nd = explode("-", $value->end_date);
				for($i = 2015; $i <= date("Y")+10;$i++){
					if($value->repeat == "date"){
						$data = [
									"title" => $value->title,
									"start" => date("Y-m-d",strtotime($i."-".$frm[1]."-".$frm[2])),
									"end"   => date("Y-m-d",strtotime($i."-".$nd[1]."-".$nd[2])),
									"backgroundColor" => $value->backgroundColor,
									"event_id" => $value->event_id,
									"allDay" => false,
								];
						$ret[] = $data;		
					}
				}
			}
		}
		echo json_encode($ret);

	}











	public function logout(){
		$sec = new Securitys;
		$sec->logout();
	}
	
}
<?php
/**
 * @Author: gian
 * @Date:   2016-04-05 16:13:59
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-11 15:15:46
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Failure_To_Log extends MY_Controller{
	
	public function test()
	{
		$this->emp_failure_logs();
	}
	public function index()
	{
		$data = array();
		$data['empData'] = $this->emp_json_data();

		$curYear = date('Y');

		$tableVars = array('tableHeaders' 		=> array('Employee Name',"Log Date",'Time in','Time out','Reason','Actions'),
					       'tableRows' 	  		=> array(),
						   'tableOptions' 		=> array('ajax' => base_url('index.php/admin/Failure_To_Log/emp_failure_logs')),
						   'tableId' 	  		=> 'ftl-table',
						   'tblCallBacks' 		=> array('fnDrawCallback' => 'function(){
						   														$(".lfr-editable").editable(opts);
						   													  }',

						   								),
						  	'tblVarName'		=> 'ftl_table'
						   );

		$tbl = lte_table($tableVars);

		$tableWidget = lte_widget(4,array('header' 	=> 'Log Failures Table',
										  'body' 	=> $tbl,
										  'col_grid'=> col_grid(12,12,10)));

		$this->create_head_and_navi(
									array( 
											asset_url('plugins/momentjs/moment.js'),
											asset_url('plugins/daterangepicker/daterangepicker.js')
										 )
										
									);

		$addFailureLog = $this->load->view('admin/Daily_Time_Record/Failure_To_Log/file_logs/failure_log',$data, TRUE);

		create_content(array('contentHeader' => 'Failure to Log',
							'breadCrumbs' => true,
							'content' => array($addFailureLog,$tableWidget)));

		$this->create_footer(array(
									$this->load->view('admin/daily_time_record/Failure_To_Log/file_logs/jscripts', FALSE, TRUE),
									$this->load->view('admin/Daily_Time_Record/Failure_To_Log/failure_table/jscripts',FALSE,TRUE)
								  ));
	}
	public function emp_failure_logs()
	{
		$this->load->model('emp_log_fail_requests');
		$empLfr = new Emp_Log_Fail_Requests;

		$empLfr->toJoin = array('employee' => 'emp_log_fail_requests' ) ;
		$allEmps = $empLfr->get();

		$data = array('data' => array());
		
			foreach ($allEmps as $key => $value) {
				$data['data'][] = array(  $value->fullName('l, f m.'),
										  '<a class="lfr-editable" nfds-id = "'.$value->sched_id.'" data-name="emp_lfr_date" data-type="date" data-template="HH:mm" data-format="YYYY-MM-DD" data-pk="'.$value->emp_lfr_id.'">'. $value->emp_lfr_date.'</a>',
										  '<a class="lfr-editable" nfds-id = "'.$value->sched_id.'" data-name="emp_lfr_log_in" data-type="time"  data-format="HH:mm" data-pk="'.$value->emp_lfr_id.'">'. $value->emp_lfr_log_in.'</a>',
										  '<a class="lfr-editable" nfds-id = "'.$value->sched_id.'" data-name="emp_lfr_log_out" data-type="time"  data-format="HH:mm" data-pk="'.$value->emp_lfr_id.'">'. $value->emp_lfr_log_out.'</a>',
										  '<a class="lfr-editable" nfds-id = "'.$value->sched_id.'" data-name="emp_lfr_reason" data-mode="inline" data-pk="'.$value->emp_lfr_id.'">'. $value->emp_lfr_reason.'</a>',
										  lte_load_view('button_groups',['buttons' => ['<span class="fa fa-trash"></span>' => ['link' => ["Delete Record?" => ['attr' => 'class="bg-info"', 'link' => '#'],
										  																									"Yes" => ['attr' => 'delete-efl="'.$value->emp_lfr_id.'"', 'link' => "#"],
										  																									'No' => ['attr' => '', 'link' => "#"]],'attr' => 'class="btn btn-xs btn-flat btn-danger"']]])
									    );
			}
		echo json_encode($data);
	}
	public function add_failure_logs()
	{
		$ret = array('success' => true);

		$this->load->model('emp_log_fail_requests');
		$this->load->model('employee_log' );


		foreach ($this->input->post('emp_log_in') as $key => $value) {

			if ($value == "" && $this->input->post('emp_log_out')[$key] = "") {
			
			}
			else{
			// if ($this->input->post('log_out')[$key] != "" && $value != "") {
				$empLfr = new Emp_Log_Fail_Requests;

				$cl = $this->input->post('sched_class')[$key];
				$this->load->model($cl);

				$schedClass = new $cl();

				$schedClass->load($key);

			 	$hasLogged = $schedClass->log($this->input->post('empId'), $this->input->post('emp_lfr_date'));

				$empLfr->employee_id 		= $this->input->post('empId');
				$empLfr->emp_lfr_filed   	=  date("Y-m-d",strtotime($this->input->post('fileDate')));
				$empLfr->sched_id 			= $key;
				$empLfr->emp_lfr_date 		= $this->input->post('emp_lfr_date');
				$empLfr->emp_lfr_log_in  	= $value != "" ?  $value : null;
				$empLfr->emp_lfr_log_out 	= $this->input->post('emp_log_out')[$key] == "" ? null : $this->input->post('emp_log_out')[$key] ;
			 	$empLfr->emp_lfr_reason  	= $this->input->post('failReason');
			 	$empLfr->emp_lfr_request_status  	= 1;

		 		
			 	$empLfr->save();

			 	$empLogs = new Employee_log;	
			 	if ($hasLogged->emp_log_id != "") {
			 		$empLogs->load($hasLogged->emp_log_id);
			 	}
			 	else{
			 		$empLogs->emp_log_sched_type = $this->input->post('sched_class')[$key];
			 		$empLogs->employee_id = $this->input->post('empId');
			 		$empLogs->emp_log_sched_id  = $key;
			 		$empLogs->emp_log_date = $this->input->post('emp_lfr_date');
			 	}
			 	$empLogs->emp_log_in = $value != "" ? $value : null;
			 	$empLogs->emp_log_out = $this->input->post('emp_log_out')[$key] != "" ? $this->input->post('emp_log_out')[$key] : null;
			 	$empLogs->save();
		 		// $nLog = new Nfds_logs;
			 	// if ($hasLogged->nfds_id != "") {
			 	// 	$nLog->load($hasLogged->nfds_log_id);
			 	// }
			 	// else{
			 	// 	$nLog->nfds_id = $key;
			 	// 	$nLog->log_date = $this->input->post('emp_lfr_date');
			 	// 	$nLog->employee_id = $this->input->post('empId');
			 	// }
			 	// $nLog->log_in 	= $value;
			 	// $nLog->log_out  = $this->input->post('log_out')[$key];
			 	// $nLog->save();

			// }
			}
		}
		echo json_encode($ret);
	}
	public function update_fail_log()
	{

		$ret = array();

		$this->load->model('emp_log_fail_requests');
		$empLfr = new Emp_Log_Fail_Requests;
		$empLfr->load($this->input->post('pk'));
		$ret = ['success' => true];

		$empLfr->{$this->input->post('name')} = $this->input->post('value');
		if($this->input->post('name') == "emp_lfr_log_in"){
			$this->load->model('nfds_logs');
			$nl = new Nfds_Logs;
			$nl->load($this->input->post('nfds_id'));
			$nl->log_in = $this->input->post('value');
			$nl->save();
		}
		elseif($this->input->post('name') == "emp_lfr_log_out"){
			$this->load->model('nfds_logs');
			$nl = new Nfds_Logs;
			$nl->load($this->input->post('nfds_id'));
			$nl->log_out = $this->input->post('value');
			$nl->save();
		}
		$empLfr->save();
		echo json_encode($ret);
	}
	public function fetch_attendance()
	{
		$emp = new Employee;
		$emp->load_with_employment_info($this->input->post('emp_id'));
		$sched = $emp->scheds($this->input->post('date'));

		$data = ['sched' => $sched,
				 'date'  => $this->input->post('date'),
				 'employee_id' => $this->input->post('emp_id')];

		$this->load->view('admin/Daily_Time_Record/Failure_To_Log/file_logs/sched_view', $data, FALSE);		
	}
	public function delete_flr()
	{
		$this->load->model('emp_log_fail_requests');
		$this->load->model('nfds_logs');

		$theELFR 		= new Emp_Log_Fail_Requests;
		$theActualLog 	= new Nfds_Logs;

		$theELFR->load($this->input->post('id'));
		$theActualLog = $theActualLog->pop(['nfds_id' => $theELFR->nfds_id, 'log_date' => $theELFR->emp_lfr_date,
											'employee_id' => $theELFR->employee_id]);

		if ($theELFR->emp_lfr_changed == "in") {
			$theActualLog->log_in = null;
			$theActualLog->save();
		}
		elseif ($theELFR->emp_lfr_changed == "out") {
			$theActualLog->log_out = null;
			$theActualLog->save();
		}
		elseif ($theELFR->emp_lfr_changed == "inout") {
			// $theActualLog->delete();
		}
		// print_r($theELFR);
		// print_r($theActualLog);
		$theELFR->delete();
	}
}
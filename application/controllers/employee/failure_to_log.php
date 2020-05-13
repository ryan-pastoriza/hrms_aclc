<?php
/**
 * @Author: gian
 * @Date:   2016-07-13 15:03:21
 * @Last Modified by:   gian
 * @Last Modified time: 2016-07-28 09:52:24
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Failure_To_Log extends MY_Controller {
	public function index(){
		$data = array();
		$data['empData'] = $this->emp_json_data();
		$curYear = date('Y');

		$tableVars = array('tableHeaders' 		=> array('Employee Name','Date Filed','Time in','Time out','Reason'),
					       'tableRows' 	  		=> array(),
						   'tableOptions' 		=> array('ajax' => base_url('index.php/employee/failure_to_log/emp_failure_logs')),
						   'tableId' 	  		=> 'ftl-table',
						   'tblCallBacks' 		=> array('fnDrawCallback' => 'function(){
						   														$(".lfr-editable").editable({
						   															combodate: {maxYear:'.$curYear.'}
						   														});
						   													  }',

						   								),
						   'tblVarName'			=> "ftlTbl"
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

		$this->create_footer();

	}


	public function emp_failure_logs(){
		
		$this->load->model('emp_log_fail_requests'); 
		$empLfr = new Emp_Log_Fail_Requests;
		$data = array('data' => array());

		$empLfr->toJoin = array('employee' => 'emp_log_fail_requests' );
		if($this->userInfo->user_privilege == "admin"){
			$allEmps = $empLfr->get();	
		
			foreach ($allEmps as $key => $value) {
				$data['data'][] = array(  $value->fullName('l, f m.'),
										  '<span class="lfr-editable" data-type="combodate" data-placement="right">'.$value->emp_lfr_filed.'</span>',
										  '<span class="lfr-editable" data-type="combodate" data-template="D MMM YYYY  HH:mm">'. $value->emp_lfr_login.'</span>',
										  '<span class="lfr-editable" data-type="combodate" data-template="D MMM YYYY  HH:mm">'. $value->emp_lfr_logout.'</span>',
										  '<span class="lfr-editable" data-mode="inline">'. $value->emp_lfr_reason.'</span>'
									    );
			}
		}
		if($this->userInfo->user_privilege == "employee"){
			$fltLogs = $empLfr->search(
								[
									"employees.employee_id" => $this->userInfo->employee_id 
								]
							);
			foreach ($fltLogs as $key => $value) {
				$data['data'][] = array(  $value->fullName('l, f m.'),
										  '<span data-type="combodate" data-placement="right">'.$value->emp_lfr_filed.'</span>',
										  '<span data-type="combodate" data-template="D MMM YYYY  HH:mm">'. $value->emp_lfr_login.'</span>',
										  '<span data-type="combodate" data-template="D MMM YYYY  HH:mm">'. $value->emp_lfr_logout.'</span>',
										  '<span data-mode="inline">'. $value->emp_lfr_reason.'</span>'
									    );
			}
		}
		
			
		echo json_encode($data);
	}
	
	public function add_failure_logs(){
		$ret = array('success' => true);

		$this->load->model('emp_log_fail_requests');
		$empLfr = new Emp_Log_Fail_Requests;
		
		$empLfr->employee_id = $this->input->post('empId');
		$empLfr->emp_lfr_filed   =  date("Y-m-d",strtotime($this->input->post('fileDate')));

		if(!$this->input->post('in') && !$this->input->post('out')){
			$ret['success'] = false;
		}else {
				$empLfr->employee_id = $this->userInfo->employee_id;
			 	$empLfr->emp_lfr_login   = $this->input->post('in') ? date("Y-m-d H:i:s",strtotime($this->input->post('inFailDate')." ".$this->input->post('inFailTime'))) : NULL;
			 	$empLfr->emp_lfr_logout  = $this->input->post('out') ? date("Y-m-d H:i:s",strtotime($this->input->post('outFailDate')." ".$this->input->post('outFailTime'))) : NULL;
			 	$empLfr->emp_lfr_reason  =  $this->input->post('failReason');
			 	$empLfr->emp_lfr_request_status = 0;
				$empLfr->save();
		}
		echo json_encode($ret);
	}

}
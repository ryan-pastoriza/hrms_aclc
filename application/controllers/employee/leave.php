<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends MY_Controller {

	public function index()
	{

		$this->create_head_and_navi(
			array(
				asset_url('plugins/jquery.printThis.js'),
				asset_url('plugins/timepicker/bootstrap-timepicker.min.js'),
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js'),
				asset_url('plugins/tautocomplete/tautocomplete.js'),
				asset_url('plugins/datatables/jquery.datatables.min.js'),
				asset_url('plugins/datatables/datatables.bootstrap.min.js'),
				asset_url('plugins/select2/select2.full.min.js'),
				asset_url('plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js'),
				asset_url('plugins/datatables/extensions/buttons/js/buttons.bootstrap.min.js'),
				asset_url('plugins/datatables/extensions/buttons/js/buttons.print.min.js'),
				asset_url('plugins/datatables/jszip.min.js'),
				asset_url('plugins/datatables/datatableTools.min.js'),
				asset_url('plugins/datatables/pdfmake.min.js'),
				asset_url('plugins/datatables/vfs_fonts.js'),
				asset_url('plugins/datatables/buttons.html5.min.js'),
				asset_url('plugins/datatables/weekdays-sorter.js'),
				),
			array(
				asset_url('plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css'),
				asset_url('plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css'),
				asset_url('plugins/timepicker/bootstrap-timepicker.min.css'),
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url('plugins/datatables/datatables.bootstrap.css'),
				asset_url('plugins/tautocomplete/tautocomplete.css'),
				asset_url('plugins/select2/select2.min.css'),
				)
		);	
		

		$data  = array(
				"feli" => $this->fetch_emp_leave_info($this->userInfo->employee_id),
				);

		$leave_form = "<div class='".col_grid(12)."'>".$this->load->view('admin/leave/form/main', $data , TRUE)."</div>";
		$content = "<div class='".col_grid(12)."'>" . $this->load->view('employee/leave/main', FALSE, TRUE) . "</div>";

		$leave_records = lte_load_view('datatable',
									['tableId' 		=> 'payment_records',
									 'tblVarName'   => 'payment_records',
									 'tableHeaders'	=> ['Payment Date', 
									 					'Requested Amount', 
									 					'Purpose', 
									 					'Payment Amount',
									 					], 
									 'tableRows'	=> [],
									 'tableOptions'	=> ['ajax' =>  base_url('index.php/employee/cash_advance/ca_history'),],

									 ]);

		create_content(array('contentHeader' => 'Leave',
							 'breadCrumbs'	 => true,
							 'content'       => [$leave_form,
							 					 $content,]
							)
					  );

		$this->create_footer();
	}

	public function leave_request(){

		$emp_id = $this->userInfo->employee_id;

		$this->load->model('employee_leave');
		$employee_leave = new Employee_Leave;
		
		$employee_leave->employee_id				=	$emp_id;
		$employee_leave->emp_leave_filed 			=	$this->input->post('date_filed');
		$employee_leave->emp_leave_availment		=	$this->input->post('availed');
		$employee_leave->emp_leave_from				=	$this->input->post('date_from');
		$employee_leave->emp_leave_to				=	$this->input->post('date_to');
		$employee_leave->emp_leave_days				=	$this->input->post('days');
		$employee_leave->emp_leave_hours			=	$this->input->post('hours');
		$employee_leave->emp_leave_with_pay			=	$this->input->post('pay');
		$employee_leave->emp_leave_remark			=	$this->input->post('remarks');
		$employee_leave->emp_leave_request_status	=	'0';
		$employee_leave->save();
		if($employee_leave->db->affected_rows() > 0){
			echo json_encode(array("leave_request" => true));
		}
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

	public function leave_list(){
		$emp_id = $this->userInfo->employee_id;
		$this->load->model('employee_leave');
		$emp_leave = new Employee_Leave;
		$emp_leave_list = $emp_leave->search(array('employee_leave.employee_id' => $emp_id));

		$data = ['data' => [] ];

		foreach ($emp_leave_list as $key => $value) {

			$withPay = "";
			$rqst_status = "";

			if($value->emp_leave_with_pay=='1'){
				$withPay = "With Pay";
			}if($value->emp_leave_with_pay == '0'){
				$withPay = "Without Pay";
			}if($value->emp_leave_request_status=='0'){
				$rqst_status = "Pending.."; 
			}if($value->emp_leave_request_status=='1'){
				$rqst_status = "Approved"; 
			}

			$data['data'][]= [$value->emp_leave_remark,
							  $value->emp_leave_filed,
							  $value->emp_leave_availment,
							  $value->emp_leave_from,
							  $value->emp_leave_to,
							  $value->emp_leave_days,
							  $value->emp_leave_hours,
							  $withPay,
							  $rqst_status,
							  ];
		}
 		echo json_encode($data);
	}


}

//  $this->userInfo->employee_id

// echo "<pre>";
// 	print_r($);
// echo "<pre>";

/* End of file leave.php */
/* Location: ./application/controllers/employee/leave.php */
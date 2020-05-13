<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_advance extends MY_Controller {

public function index()
	{

		$this->create_head_and_navi(	array(
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js'),
				asset_url('plugins/datatables/jquery.dataTables.min.js'),
				asset_url('plugins/datatables/dataTables.bootstrap.js')
				),
			array(
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url('plugins/datatables/dataTables.bootstrap.css')
				));

		$ca_list = lte_load_view('datatable',
									['tableId' 		=> 'ca_list_tbl',
									 'tblVarName'   => 'ca_list_tbl',
									 'tableHeaders'	=> ['Date Filed', 
									 					'Requested Amount', 
									 					'Purpose', 
									 					'Repayment Term', 
									 					'Repayment Amount', 
									 					'Balance',
									 					'status'], 
									 'tableRows'	=> [],
									 'tableOptions'	=> ['ajax' =>  base_url('index.php/employee/cash_advance/ca_history'),],

									 ]);
		
		$ca_records = lte_load_view('datatable',
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

		$content = lte_load_view('simple_tab',[
												'tabs' => ['Cash Advance List' => $ca_list,
														   'Payment Records' => $ca_records],
												'tab_id' =>  'myTabs',
												]);

		$ca_rqst_form = "<div class='col-sm-12'> " . $this->load->view('admin/cash_advance/form/main', [], TRUE) . "</div>";

		create_content(array('contentHeader' => 'Cash Advance',
							 'breadCrumbs'	 => true,
							 'content'       => [$ca_rqst_form,
							 					 $content]
							)
					  );

		$this->create_footer();
	}

	public function emp_id(){
		$emp_id = $this->session->userdata['DP_USER_ID'];		
		return $emp_id;
	}

	public function employment_info(){
		$emp_id = $this->session->userdata['DP_USER_ID'];		
		$this->load->model('employment');
		$employment = new Employment;
		$get_employment = $employment->pop("employment.employee_id = $emp_id");
		return $get_employment;
	}

	public function get_dept(){
		$emp_info = $this->employment_info();
		$dept_id = $emp_info->department_id;
		$this->load->model('department');
		$department = new Department;
		$dept = $department->pop("departments.department_id = $dept_id");
		$department_name = $dept->department_name;
		return $department_name;
	}

	public function request_form(){
		$emp_id = $this->session->userdata['DP_USER_ID'];		
		$this->load->model('emp_cash_advance');
		$ca = new Emp_Cash_Advance;

		$ca->employee_id			= $emp_id;
		$ca->emp_ca_filed 			= $this->input->post('date_filed');
		$ca->emp_ca_amount 			= $this->input->post('req_amount');
		$ca->emp_ca_purpose 		= $this->input->post('purpose');
		$ca->emp_ca_repayment_term  = $this->input->post('term');
		$ca->emp_ca_repayment_amt 	= $this->input->post('amount');
		$ca->emp_ca_request_status 	= '0';
		$ca->save();

		if($ca->db->affected_rows() > 0){
			echo json_encode(array("result" => true));
		}
	}

	public function ca_history(){
		$emp_id = $this->emp_id();
		$this->load->model('emp_cash_advance');
		$cash_advance = new Emp_Cash_Advance;
		$ca_history = $cash_advance->search("emp_cash_advances.employee_id = '$emp_id'");
		
		$data = ['data' => [] ];

		foreach ($ca_history as $key => $value) {
			$id = $value->emp_ca_id;
			$status = "";
			if($value->emp_ca_request_status == 0){
				$status = "Pending..";
			}else{
				$status = "Approved";
			}
			$data['data'][] = [$value->emp_ca_filed,
							   $value->emp_ca_amount,
							   $value->emp_ca_purpose, 
							   $value->emp_ca_repayment_term,
							   $value->emp_ca_repayment_amt,
							   number_format($this->payment_balance($id), 2),
							   $status];
 		}
 		echo json_encode($data);
	}

	public function ca_advance_paid(){
		$emp_id = $this->emp_id();
		$this->load->model('emp_ca_payment');
		$payments = new Emp_Ca_Payment;
		$payments->toJoin = array('emp_cash_advance' => 'emp_ca_payment');
		$ca_payment_records = $payments->search(array('emp_cash_advances.employee_id' => $emp_id));

		foreach ($ca_payment_records as $key => $value) {
			echo $value->ca_payment_amt."<br>";
		}

	}

	public function ca_payment_records(){
		$emp_id = $this->emp_id();
		$this->load->model('emp_ca_payment');
		$payments = new Emp_Ca_Payment;
		$payments->toJoin = array('emp_cash_advance' => 'emp_ca_payment');
		$ca_payment_records = $payments->search(array('emp_cash_advances.employee_id' => $emp_id));

		$data2 = ['data' => [] ];

		foreach ($ca_payment_records as $key => $value) {
			$data2['data'][] = [$value->ca_payment_date,
							   $value->emp_ca_purpose, 
							   $value->emp_ca_amount,
							   $value->ca_payment_amt,
							   ucfirst($value->ca_payment_option)
							   ];
 		}
 		echo json_encode($data2);

	}

	public function payment_balance($id) {
		$this->load->model('emp_cash_advance');
		$eca = new Emp_Cash_Advance;
		$this->load->model('emp_ca_payment');
		$ecap = new Emp_Ca_Payment;
		$total_amount = 0;
		$amount_paid = 0;
		$eca = $eca->search(array('emp_ca_id' => $id));
		foreach ($eca as $key => $value) {
			$total_amount = $value->emp_ca_amount;
		}
		$payments = $ecap->search(array('emp_ca_id' => $id));
		foreach ($payments as $key => $value) {
			$amount_paid += $value->ca_payment_amt;
		}
		return ($total_amount - $amount_paid);
	}

}

/* End of file cash_advance_history.php */
/* Location: ./application/controllers/employee/cash_advance_history.php */

	// echo "<pre>";
	// 	print_r();
	// echo "<pre>";
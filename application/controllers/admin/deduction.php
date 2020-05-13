<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deduction extends MY_Controller {

	public function index() {	
		$allEmp = $this->basic_emp_json();

		$data  = array(
				"allEmp" => $allEmp
				);

		$contents = array(
				$this->load->view('admin/other_deduction/main', $data, true)
			);
		
		$this->create_head_and_navi(
			array(
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js'),
				asset_url('plugins/jquery.form.min.js'),
				asset_url('plugins/datatables/jquery.dataTables.min.js'),
				asset_url('plugins/datatables/dataTables.bootstrap.min.js'),
				),
			array(
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url('plugins/datatables/dataTables.bootstrap.css'),
				)
		);

		create_content(array(
			'contentHeader' => 'Other Deductions',
			'breadCrumbs' => true,
			'content' => $contents
			));

		$this->create_footer();
	}

	public function add() {
		$this->load->model('emp_other_deduction');
		$this->load->model('other_deduction');
		$od = new Other_Deduction;

		$od->other_ded_name = $this->input->post('ded_name');
		$od->other_ded_description = $this->input->post('ded_desc');
		$od->other_ded_start_date = $this->input->post('ded_start');
		$od->other_ded_term = $this->input->post('term');
		$od->other_ded_duration_months = $this->input->post('ded_duration');
		$od->save();

		foreach ($this->input->post('emp-id') as $key => $value) {
			$amt_total 		= preg_replace('/[^0-9.]/', '', $this->input->post('emp-amt-total')[$key]);
			$deduction_amt 	= preg_replace('/[^0-9.]/', '', $this->input->post('emp-term-deduction-amt')[$key]);

			$eod 							= new Emp_Other_Deduction;
			$eod->employee_id 				= $value;
			$eod->eod_date_filed 			= $this->input->post('ded_date');
			$eod->other_ded_id 				= $od->other_ded_id;
			$eod->eod_amt_total 			= $amt_total;
			$eod->eod_term_deduction_amt 	= $deduction_amt;
			$eod->save();
		}
	}

	public function add_payment() {
		$this->load->model('emp_other_deduction_payment');
		$eodp = new Emp_Other_Deduction_Payment;
		$eodp->eod_id = $this->input->post('eod_id');
		$eodp->eod_payment_date = $this->input->post('date_paid');
		$eodp->eod_payment_option = 'Personal';
		$eodp->eod_payment_amount = preg_replace('/[^0-9.]/', '', $this->input->post('amount_paid'));
		$eodp->save();
	}

	public function delete() {
		$id = $this->input->post('id');
		$this->db->where('eod_id', $id);
		$this->db->delete('emp_other_deductions');
	}

	public function update() {
		$this->load->model('emp_other_deduction');
		$eod = new Emp_Other_Deduction;
		$name = $this->input->post('name');
		$value = $this->input->post('value');
		if($name === 'eod_amt_total' || $name === 'eod_term_deduction_amt') {
			$value = preg_replace('/[^0-9.]/', '', $value);
		}
		$eod->load($this->input->post('pk'));
		$eod->{$name} = $value;
		$eod->save();
	}

	public function payment_balance($id) {
		$this->load->model('emp_other_deduction');
		$eod = new Emp_Other_Deduction;
		$this->load->model('emp_other_deduction_payment');
		$eodp = new Emp_Other_Deduction_Payment;
		$total_amount = 0;
		$amount_paid = 0;
		$eod = $eod->search(array('eod_id' => $id));
		foreach ($eod as $key => $value) {
			$total_amount = $value->eod_amt_total;
		}
		$payments = $eodp->search(array('eod_id' => $id));
		foreach ($payments as $key => $value) {
			$amount_paid += $value->eod_payment_amount;
		}
		return ($total_amount - $amount_paid);
	}

	public function eod_json(){
		$this->load->model('emp_other_deduction');
		$eod 			= new Emp_Other_Deduction;
		$eod->toJoin 	= array('employee' => 'emp_other_deduction');
		$all 			= $eod->get();
		$data 			= array('data' => array());


		foreach ($all as $key => $value) {
			$other_ded_info = $value->belongs_to('Other_Deduction');

			$id = $value->eod_id;
			$data['data'][] = array(
									$value->fullName('f m. l'), 
									"<span class='eod-date-filed' data-pk='{$id}' data-name='eod_date_filed' data-value='{$value->eod_date_filed}'>".$value->eod_date_filed."</span>",
									"<span class='other-ded' data-pk='{$id}' data-name='other_ded_id' data-value='{$other_ded_info->other_ded_name}'>".$other_ded_info->other_ded_name."</span>",
									"<span class='eod-amt-total' id='amt_total{$id}' data-pk='{$id}' data-name='eod_amt_total' data-value='{$value->eod_amt_total}'>".number_format($value->eod_amt_total, 2)."</span>",
									"<span class='other-ded-term' id='ded_term{$id}' data-pk='{$id}' data-name='other_ded_term' data-value='{$other_ded_info->other_ded_term}'>".$other_ded_info->other_ded_term."</span>",
									"<span class='other-ded-duration-months' id='ded_duration{$id}' data-pk='{$id}' data-name='other_ded_duration_months' data-value='{$other_ded_info->other_ded_duration_months}'>".$other_ded_info->other_ded_duration_months."</span>",
									"<span class='eod-term-deduction-amt' data-pk='{$id}' data-name='eod_term_deduction_amt' data-value='{$value->eod_term_deduction_amt}'>".number_format($value->eod_term_deduction_amt, 2)."</span>",
									"<span>".number_format($value->balance($id), 2)."</span>",
									"<button data-toggle='modal' data-target='#payment' onclick='paymentModal({$id})' type='button' class='btn btn-flat btn-xs btn-success' title='Payment'>
				        				<span class='fa fa-money'></span>
				        			</button>
									<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' onclick='delete_eod({$id}); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

	public function eodp_json(){
		$this->load->model('emp_other_deduction_payment');
		$eodp = new Emp_Other_Deduction_Payment;
		$eodp->toJoin = array('emp_other_deduction' => 'emp_other_deduction_payment', 'employee' => 'emp_other_deduction', 'other_deduction' => 'emp_other_deduction');
		$all = $eodp->get();
		$data = array('data' => array());
		foreach ($all as $key => $value) {
			$data['data'][] = array(
									$value->fullName('f m. l'),
									$value->eod_payment_date,
									$value->other_ded_name,
									number_format($value->eod_amt_total, 2),
									number_format($value->eod_payment_amount, 2),
									ucfirst($value->eod_payment_option)
								);
		}
		echo json_encode($data);
	}

	public function get_eod_json() {
		$id = $this->input->post('id');
		$this->load->model('emp_other_deduction');
		$eod = new Emp_Other_Deduction;
		$eod->toJoin = array('employee' => 'emp_other_deduction', 'other_deduction' => 'emp_other_deduction');	
		$get_eod = $eod->search(array('eod_id' => $id));
		$data = array('data' => array());
		foreach ($get_eod as $key => $value) {
			$data['data'][] = array(
									'eod_id' => $value->eod_id,
									'fullName' => $value->fullName('f m. l'),
									'eod_date_filed' => $value->eod_date_filed,
									'other_ded_name' => $value->other_ded_name,
									'eod_amt_total' => number_format($value->eod_amt_total, 2),
									'eod_term_deduction_amt' => number_format($value->eod_term_deduction_amt, 2),
									'other_ded_duration_months' => $value->other_ded_duration_months,
									'other_ded_term' => $value->other_ded_term,
									'balance' => number_format($this->payment_balance($id), 2)
								);
		}
		echo json_encode($data);
	}
}
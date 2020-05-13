<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_Advance extends MY_Controller {

	public function index() {	
		$allEmp = $this->basic_emp_json();
		$data  = array(
				"allEmp" => $allEmp
				);
		$contents = array(
				$this->load->view('admin/cash_advance/main', $data, true)
			);
		$this->create_head_and_navi(
			array(
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js'),
				asset_url('plugins/datatables/jquery.dataTables.min.js'),
				asset_url('plugins/datatables/dataTables.bootstrap.js')
				),
			array(
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url('plugins/datatables/dataTables.bootstrap.css')

				)
		);
		create_content(array(
			'contentHeader' => 'Cash Advance',
			'breadCrumbs' => true,
			'content' => $contents
			));
		$this->create_footer();
	}

	public function add() {
		$this->load->model('emp_cash_advance');
		$emp_ca = new Emp_Cash_Advance;

		$req_amount = preg_replace('/[^0-9.]/', '', $this->input->post('req_amount'));
		$amount = preg_replace('/[^0-9.]/', '', $this->input->post('amount'));

		$emp_ca->employee_id = $this->input->post('emp_id');
		$emp_ca->emp_ca_filed = $this->input->post('date_filed');
		$emp_ca->emp_ca_amount = $req_amount;
		$emp_ca->emp_ca_purpose = $this->input->post('purpose');
		$emp_ca->emp_ca_repayment_term = $this->input->post('term');
		$emp_ca->emp_ca_repayment_amt = $amount;
		$emp_ca->emp_ca_request_status = 1;
		$emp_ca->emp_ca_deduct_start = $this->input->post('emp_ca_deduct_start');
		$emp_ca->save();
	}

	public function add_payment() {
		$this->load->model('emp_ca_payment');
		$ecap = new Emp_Ca_Payment;
		$ecap->emp_ca_id = $this->input->post('emp_ca_id');
		$ecap->ca_payment_date = $this->input->post('date_paid');
		$ecap->ca_payment_option = 'Personal';
		$ecap->ca_payment_amt = preg_replace('/[^0-9.]/', '', $this->input->post('amount_paid'));
		$ecap->save();
	}

	public function update() {
		$this->load->model('emp_cash_advance');
		$emp_ca = new Emp_Cash_Advance;

		$name = $this->input->post('name');
		$value = $this->input->post('value');

		if($name === 'emp_ca_repayment_amt' || $name === 'emp_ca_amount') {
			$value = preg_replace('/[^0-9.]/', '', $value);
		}

		$emp_ca->load($this->input->post('pk'));
		$emp_ca->{$name} = $value;
		$emp_ca->save();
	}

	public function delete() {
		$id = $this->input->post('id');
		$this->db->where('emp_ca_id', $id);
		$this->db->delete('emp_cash_advances');
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

	public function ca_json() {
		$this->load->model('emp_cash_advance');
		$emp_ca = new Emp_Cash_Advance;
		$emp_ca->toJoin = array('employee' => 'emp_cash_advance');
		$all = $emp_ca->get();
		$data = array('data' => array());
		foreach ($all as $key => $value) {
			$id = $value->emp_ca_id;
			$status = "";
			if($value->emp_ca_request_status == 0) {
						$status = "pending";
					}if($value->emp_ca_request_status == 1){
						$status = "approved";
					}else{
						$status = "rejected";
					}
					
			$data['data'][] = array(
					
									$value->fullName('f m. l'),
									"<span class='emp-ca-filed' data-pk='{$id}' data-name='emp_ca_filed' data-value='{$value->emp_ca_filed}'>".$value->emp_ca_filed."</span>",
									"<span class='emp-ca-amount' data-pk='{$id}' data-name='emp_ca_amount' data-value='{$value->emp_ca_amount}'>".number_format($value->emp_ca_amount, 2)."</span>",
									"<span class='emp-ca-purpose' data-pk='{$id}' data-name='emp_ca_purpose' data-value='{$value->emp_ca_purpose}'>".$value->emp_ca_purpose."</span>",
									"<span class='emp-ca-repayment-term' data-pk='{$id}' data-name='emp_ca_repayment_term' data-value='{$value->emp_ca_repayment_term}'>".$value->emp_ca_repayment_term."</span>",
									"<span class='emp-ca-repayment-start' data-pk='{$id}' data-name='emp_ca_deduct_start' data-value='{$value->emp_ca_deduct_start}'>".$value->emp_ca_deduct_start."</span>",
									"<span class='emp-ca-repayment-amt' data-pk='{$id}' data-name='emp_ca_repayment_amt' data-value='{$value->emp_ca_repayment_amt}'>".number_format($value->emp_ca_repayment_amt, 2)."</span>",
									"<span>".number_format($this->payment_balance($id), 2)."</span>",
									"<span>". ucfirst($status) ." </span",
									"
									<div class='visible-lg visible-md hidden-xs hidden-sm'>
										<button type='button' class='btn btn-flat btn-xs btn-success' title='Approve' onclick='approve({$id})' id='approve'>
					        				<span class='fa fa-check'></span>
					        			</button>
					        			<button onclick='reject({$id})' type='button' class='btn btn-flat btn-xs btn-warning' title='Reject'>
					        				<span class='fa fa-times'></span>
					        			</button><br>
										<button data-toggle='modal' data-target='#payment' onclick='paymentModal({$id})' type='button' class='btn btn-flat btn-xs btn-success' title='Payment'>
					        				<span class='fa fa-money'></span>
					        			</button>
										<div class='btn-group'>
											<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
												<span class='glyphicon glyphicon-trash'></span>
											</button>
											<ul class='dropdown-menu pull-right' role='menu'>
												<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
												<li class='text-center'><a href='#' onclick='delete_ca({$id}); return false;'>Yes</a></li>
												<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
											</ul>
										</div>
									</div>".

									"<div class='btn-group visible-xs visible-sm hidden-md hidden-lg'>
				                      	<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' onclick='delete_ca({$id}); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>

				                      <div class='btn-group'>
				                        <button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>
				                          <span class='caret'></span>
				                        </button>
				                        <ul class='dropdown-menu'>
				                          <li>
											<a href='#' type='button' title='Approve' onclick='approve({$id})' ca-id='$value->emp_ca_id' id='approve'>
					        					<span class='fa fa-check'></span> Approve
					        				</a>
				                          </li>
				                          <li>
											<a href='#' onclick='reject({$id})' type='button' title='Reject'>
					        					<span class='fa fa-times'></span> Reject
					        				</a>
				                          </li>
				                          <li>
				                          	<a href='#' data-toggle='modal' data-target='#payment' onclick='paymentModal({$id})' type='button' title='Payment'>
					        					<span class='fa fa-money'></span> Payment
					        				</a>
				                          </li>
				                        </ul>
				                      </div>
				                    </div>"
								);
		}
		echo json_encode($data);
	}

	public function ecap_json(){
		$this->load->model('emp_ca_payment');
		$ecap = new Emp_Ca_Payment;
		$ecap->toJoin = array('emp_cash_advance' => 'emp_ca_payment', 'employee' => 'emp_cash_advance');
		$all = $ecap->get();
		$data = array('data' => array());
		foreach ($all as $key => $value) {
			$data['data'][] = array(
									$value->fullName('f m. l'),
									$value->ca_payment_date,
									$value->emp_ca_purpose,
									number_format($value->emp_ca_amount, 2),
									number_format($value->ca_payment_amt, 2),
									ucfirst($value->ca_payment_option),
									ucfirst($value->emp_ca_request_status == 1 ? "approved" : "pending")
								);
		}
		echo json_encode($data);
	}

	public function get_ca_json() {
		$id = $this->input->post('id');
		$this->load->model('emp_cash_advance');
		$emp_ca = new Emp_Cash_Advance;
		$emp_ca->toJoin = array('employee' => 'emp_cash_advance');	
		$all = $emp_ca->search(array('emp_ca_id' => $id));
		$data = array('data' => array());
		foreach ($all as $key => $value) {
			$data['data'][] = array(
									'emp_ca_id' => $value->emp_ca_id,
									'fullName' => $value->fullName('f m. l'),
									'emp_ca_filed' => $value->emp_ca_filed,
									'emp_ca_amount' => number_format($value->emp_ca_amount, 2),
									'emp_ca_purpose' => $value->emp_ca_purpose,
									'emp_ca_repayment_term' => $value->emp_ca_repayment_term,
									'emp_ca_repayment_amt' => number_format($value->emp_ca_repayment_amt, 2),
									'balance' => number_format($this->payment_balance($id), 2)
								);
		}
		echo json_encode($data);
	}

	public function approve(){
		$this->load->model('emp_cash_advance');
		$emp_ca = new Emp_Cash_Advance;
		$emp_ca->load($this->input->post('id'));
		$emp_ca->emp_ca_request_status = 1;
		$emp_ca->save();
	}

	public function reject(){
		$this->load->model('emp_cash_advance');
		$emp_ca = new Emp_Cash_Advance;
		$emp_ca->load($this->input->post('id'));
		$emp_ca->emp_ca_request_status = 2;
		$emp_ca->save();
	}
}
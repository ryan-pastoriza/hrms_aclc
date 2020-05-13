<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends MY_Controller {

	public function index() {	
		$allEmp = $this->basic_emp_json();

		$data  = array(
				"allEmp" => $allEmp
				);

		$contents = array(
				$this->load->view('admin/loan/main', $data, true)
			);
		
		$this->create_head_and_navi(
			array(
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js'),
				asset_url('plugins/datatables/jquery.dataTables.min.js'),
				asset_url('plugins/datatables/extensions/ColVis/js/dataTables.colVis.js'),
				asset_url('plugins/datatables/dataTables.bootstrap.min.js'),
				asset_url('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'),
				),
			array(
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url('plugins/datatables/dataTables.bootstrap.css'),
				asset_url('plugins/datatables/extensions/ColVis/css/datatables.colVis.css'),
				asset_url('plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css'),
				// asset_url('plugins/datatables/colvis.min.css'),
				)
		);

		create_content(array(
			'contentHeader' => 'Loan',
			'breadCrumbs' => true,
			'content' => $contents
			));

		$this->create_footer();
	}

	function print_form(){
		$month = $this->input->post("month");
		$search = "";

		if($month == "All"){
			$month = date("m");
			$search == "SSS";
		}
		else{
			$month = explode(" - ", $month);
			$month = date("m",strtotime($month[0]));
		}

		

		if(strlen($this->input->post("search")) == 0 ){
			$search = "sss";
		}else{
			$search = $this->input->post("search");
		}

		$data = [];

		$this->load->model('emp_loan_payment');
		$elp = new Emp_Loan_Payment;
		$elp->toJoin = ["emp_loan" => "emp_loan_payment",
						"employee" => "emp_loan",
						"employment" => "employee",
						"employment_application_form" => "employee"];
		$searchElp = $elp->search("emp_loans.emp_loan_type LIKE '%{$search}%' AND MONTH(emp_loan_payments.el_payment_date) = {$month} ");
		$pagibigNo = [];
		$monthOf = [];
		$loan_type = "";
		foreach ($searchElp as $key => $value) {
			$monthOf =  [
							"monthOf" => date("Y-m",strtotime($value->el_payment_date))
						];
			$loan_type = $value->emp_loan_type;
		}

		$this->load->model("employment");

		$data = [

					"monthOf" => $monthOf,
					"loans" => $searchElp,
					"loan_type" => $loan_type,
				];


		$this->load->view('admin/loan/print/main',$data);
	}

	public function add() {
		$this->load->model('emp_loan');
		$loan = new Emp_Loan;

		$loan->employee_id = $this->input->post('emp_id');
		$loan->emp_loan_filed = $this->input->post('date_filed');
		$loan->emp_loan_type = $this->input->post('loan_type');
		$loan->emp_loan_term = $this->input->post('term');
		$loan->emp_loan_amt = preg_replace('/[^0-9.]/', '', $this->input->post('amount'));
		$loan->emp_loan_deduct = preg_replace('/[^0-9.]/', '', $this->input->post('deduct'));
		$loan->emp_loan_request_status = "1";
		$loan->save();
	}

	public function add_payment() {
		$this->load->model('emp_loan_payment');
		$elp = new Emp_Loan_Payment;
		$elp->emp_loan_id = $this->input->post('loan_id');
		$elp->el_payment_date = $this->input->post('date_paid');
		$elp->el_payment_option = 'Personal';
		$elp->el_payment_amount = preg_replace('/[^0-9.]/', '', $this->input->post('amount_paid'));
		$elp->save();
	}

	public function delete() {
		$loan_id = $this->input->post('id');
		$this->db->where('emp_loan_id', $loan_id);
		$this->db->delete('emp_loans');
	}

	public function update() {
		$this->load->model('emp_loan');
		$loan = new Emp_Loan;

		$name = $this->input->post('name');
		$value = $this->input->post('value');

		if($name === 'emp_loan_amt' || $name === 'emp_loan_deduct') {
			$value = preg_replace('/[^0-9.]/', '', $value);
		}

		$loan->load($this->input->post('pk'));
		$loan->{$name} = $value;
		$loan->save();
	}

	public function payment_balance($loan_id) {
		$this->load->model('emp_loan');
		$loan = new Emp_Loan;
		$this->load->model('emp_loan_payment');
		$elp = new Emp_Loan_Payment;
		$loan_amount = 0;
		$amount_paid = 0;
		$loan = $loan->search(array('emp_loan_id' => $loan_id));
		foreach ($loan as $key => $value) {
			$loan_amount = $value->emp_loan_amt;
		}
		$payments = $elp->search(array('emp_loan_id' => $loan_id));
		foreach ($payments as $key => $value) {
			$amount_paid += $value->el_payment_amount;
		}
		return ($loan_amount - $amount_paid);
	}

	public function loan_json(){
		$this->load->model('emp_loan');
		$emp_loan = new Emp_Loan;
		$emp_loan->toJoin = array('employee' => 'emp_loan');
		$all_ots = $emp_loan->get();
		$data = array('data' => array());
		foreach ($all_ots as $key => $value) {
			$id = $value->emp_loan_id;
			if($value->emp_loan_request_status == 1){
				$status = 'approved';
			}if($value->emp_loan_request_status == 2){
				$status = 'rejected';
			}if($value->emp_loan_request_status == 0){
				$status = "<div class='btn-group'>
							<a href='#' class='dropdown-toggle'  data-toggle='dropdown'><span class='fa fa-hourglass-start text-secondary'></span></a>
							<ul class='dropdown-menu'>
                                <li><a href='#' class='cancel-request-btn' loan-id = '".$value->emp_loan_id."'>Cancel Request</a></li>
                              </ul>
                            </div>	";
			}
			$data['data'][] = array(
									$value->fullName('f m. l'), 
									"<span class='emp-loan-filed' data-pk='{$id}' data-name='emp_loan_filed' data-value='{$value->emp_loan_filed}'>".$value->emp_loan_filed."</span>",
									"<span class='emp-loan-type' data-pk='{$id}' data-name='emp_loan_type' data-value='{$value->emp_loan_type}'>".$value->emp_loan_type."</span>",
									"<span class='emp-loan-amt' data-pk='{$id}' data-name='emp_loan_amt' data-value='{$value->emp_loan_amt}'>".number_format($value->emp_loan_amt, 2)."</span>",
									"<span class='emp-loan-term' data-pk='{$id}' data-name='emp_loan_term' data-value='{$value->emp_loan_term}'>".$value->emp_loan_term."</span>",
									"<span class='emp-loan-deduct' data-pk='{$id}' data-name='emp_loan_deduct' data-value='{$value->emp_loan_deduct}'>".number_format($value->emp_loan_deduct, 2)."</span>",
									"<span>".number_format($this->payment_balance($id), 2)."</span>",
									ucfirst($status) ,
									"<div class='hidden-xs hidden-sm visible-md visible-lg'>
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
												<li class='text-center'><a href='#' onclick='delete_loan({$id}); return false;'>Yes</a></li>
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
												<a href='#' type='button' title='Approve' onclick='approve({$id})' id='approve'>
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

	public function elp_json(){
		$this->load->model('emp_loan_payment');
		$elp = new Emp_Loan_Payment;
		$elp->toJoin = array('emp_loan' => 'emp_loan_payment', 'employee' => 'emp_loan');
		$all = $elp->get();
		$data = array('data' => array());
		foreach ($all as $key => $value) {
			$data['data'][] = array(
									$value->fullName('f m. l'),
									$value->el_payment_date,
									$value->emp_loan_type,
									number_format($value->emp_loan_amt, 2),
									number_format($value->el_payment_amount, 2),
									ucfirst($value->el_payment_option)
								);
		}
		echo json_encode($data);
	}

	public function get_el_json() {
		$id = $this->input->post('id');
		$this->load->model('emp_loan');
		$el = new Emp_Loan;
		$el->toJoin = array('employee' => 'emp_loan');	
		$get_el = $el->search(array('emp_loan_id' => $id));
		$data = array('data' => array());
		foreach ($get_el as $key => $value) {
			$data['data'][] = array(
									'emp_loan_id' => $value->emp_loan_id,
									'fullName' => $value->fullName('f m. l'),
									'emp_loan_filed' => $value->emp_loan_filed,
									'emp_loan_type' => $value->emp_loan_type,
									'emp_loan_term' => $value->emp_loan_term,
									'emp_loan_amt' => number_format($value->emp_loan_amt, 2),
									'emp_loan_deduct' => number_format($value->emp_loan_deduct, 2),
									'balance' => number_format($this->payment_balance($id), 2)
								);
		}
		echo json_encode($data);
	}

	public function approve(){
		$this->load->model('emp_loan');
		$emp_loan = new Emp_Loan;
		$emp_loan->load($this->input->post('id'));
		$emp_loan->emp_loan_request_status = 1;
		$emp_loan->save();
	}

	public function reject(){
		$this->load->model('emp_loan');
		$emp_loan = new Emp_Loan;
		$emp_loan->load($this->input->post('id'));
		$emp_loan->emp_loan_request_status = 2;
		$emp_loan->save();
	}
}
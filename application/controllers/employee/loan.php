<?php
/**
 * @Author: gian
 * @Date:   2016-07-13 16:51:54
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-10 11:09:25
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Loan extends MY_Controller{
	
	public function index(){

		$allEmp = $this->basic_emp_json();

		$data  = [
						"allEmp" => $allEmp
				 ];

		$contents = array(
				$this->load->view('admin/loan/main', $data, true)
			);
		
		$this->create_head_and_navi(
			array(
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js'),
				asset_url('plugins/datatables/jquery.dataTables.min.js'),
				asset_url('plugins/datatables/dataTables.bootstrap.min.js'),
				),
			array(
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url('plugins/datatables/dataTables.bootstrap.css'),
				)
		);

		create_content(array(
			'contentHeader' => 'Loan',
			'breadCrumbs' => true,
			'content' => $contents
			));

		$this->create_footer();
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
		if($this->userInfo->user_privilege == "employee"){
			$all_ots = $emp_loan->search(
										 	[
										 		"employees.employee_id" => $this->userInfo->employee_id
										 	]
										);
			foreach ($all_ots as $key => $value) {
				$id = $value->emp_loan_id;
				$data['data'][] = array(
										$value->fullName('f m. l'), 
										"<span data-pk='{$id}' data-name='emp_loan_filed' data-value='{$value->emp_loan_filed}'>".$value->emp_loan_filed."</span>",
										"<span data-pk='{$id}' data-name='emp_loan_type' data-value='{$value->emp_loan_type}'>".$value->emp_loan_type."</span>",
										"<span data-pk='{$id}' data-name='emp_loan_amt' data-value='{$value->emp_loan_amt}'>".number_format($value->emp_loan_amt, 2)."</span>",
										"<span data-pk='{$id}' data-name='emp_loan_term' data-value='{$value->emp_loan_term}'>".$value->emp_loan_term."</span>",
										"<span data-pk='{$id}' data-name='emp_loan_deduct' data-value='{$value->emp_loan_deduct}'>".number_format($value->emp_loan_deduct, 2)."</span>",
										"<span>".number_format($this->payment_balance($id), 2)."</span>",
										$value->emp_loan_request_status == 1 ? ucfirst("approved") : ucfirst("pending")
									);
			}
		}

		echo json_encode($data);
	}

	public function elp_json(){
		$this->load->model('emp_loan_payment');
		$elp = new Emp_Loan_Payment;
		$data = array('data' => array());

		$elp->toJoin = array('emp_loan' => 'emp_loan_payment',
							 'employee' => 'emp_loan');
		if($this->userInfo->user_privilege == "admin"){
			$all = $elp->get();
			foreach ($all as $key => $value) {
				$data['data'][] = array(
										$value->fullName('f m. l'),
										$value->el_payment_date,
										$value->emp_loan_type,
										number_format($value->emp_loan_amt, 2),
										number_format($value->el_payment_amount, 2)
									);
			}
		}
		if($this->userInfo->user_privilege == "employee"){
			$all = $elp->search(
									[
										"employees.employee_id" => $this->userInfo->employee_id
									]
							   );
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

}
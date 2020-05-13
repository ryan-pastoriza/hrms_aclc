<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Overtime extends MY_Controller {

	public function index() {	
		$allEmp = $this->basic_emp_json();
		$overtime = $this->get_overtime();

		$data  = array(
				"allEmp" => $allEmp,
				"overtime" => $overtime
				);

		$contents = array(
				$this->load->view('admin/overtime/main', $data, true)
			);
		
		$this->create_head_and_navi(
			array(
				asset_url("plugins/datatables/jquery.dataTables.min.js"),
				asset_url("plugins/datatables/dataTables.bootstrap.min.js"),
				asset_url('plugins/timepicker/bootstrap-timepicker.min.js'),
				asset_url('plugins/daterangepicker/moment.min.js'),
				asset_url('plugins/daterangepicker/daterangepicker.js')
				),
			array(
				asset_url('plugins/timepicker/bootstrap-timepicker.min.css'),
				asset_url('plugins/daterangepicker/daterangepicker-bs3.css'),
				asset_url("plugins/datatables/dataTables.bootstrap.css"),
				)

		);
		create_content(array(
			'contentHeader' => 'Overtime',
			'breadCrumbs' => true,
			'content' => $contents
			));

		$this->create_footer();
	}
	
	public function add() {
		foreach ($this->input->post('id') as $key => $value) {
			$this->load->model('emp_overtime');
			$empOvertime = new Emp_Overtime;
			$empOvertime->employee_id = $value;
			$empOvertime->emp_ot_date = $this->input->post('date')[$key];
			$empOvertime->emp_ot_from = date("H:i", strtotime($this->input->post('fromTime')[$key]));
			$empOvertime->emp_ot_to = date("H:i", strtotime($this->input->post('toTime')[$key]));
			$empOvertime->emp_ot_total_hours = $this->input->post('totalHours')[$key];
			$empOvertime->emp_ot_work_shift_in = date("H:i", strtotime($this->input->post('fromWorkShift')[$key]));
			$empOvertime->emp_ot_work_shift_out = date("H:i", strtotime($this->input->post('toWorkShift')[$key]));
			$empOvertime->emp_ot_purpose = $this->input->post('purpose')[$key];
			$empOvertime->emp_ot_actual_worked = $this->input->post('actualHours')[$key];
			$empOvertime->emp_ot_date_filed = $this->input->post('dateFiled');
			$empOvertime->save();
		}
	}

	public function update() {
		$this->load->model('emp_overtime');
		$ot = new Emp_Overtime;
		$ot->load($this->input->post('pk'));
		$ot->{$this->input->post('name')} = $this->input->post('value');
		$ot->save();
	}

	public function delete() {
		$this->load->model('emp_overtime');
		$ot = new Emp_Overtime;
		$ot_id = $this->input->post('id');
		$this->db->where('emp_ot_id', $ot_id);
		$this->db->delete('emp_overtime');
	}

	public function get_overtime() {
		$this->load->model('emp_overtime');
		$empOvertime = new Emp_Overtime;
		$empOvertime->toJoin = array('employee' => 'emp_overtime');
		return $empOvertime->get();
	}

	public function ot_json(){
		$this->load->model('emp_overtime');
		$emp_ots = new Emp_Overtime;

		$emp_ots->toJoin 	= array('employee' => 'emp_overtime');
		$all_ots 			= $emp_ots->get();
		$data 				= array('data' => array());

		foreach ($all_ots as $key => $value) {
			$id 		= $value->emp_ot_id;
			$from 		= date("H:i", strtotime($value->emp_ot_from));
			$to 		= date("H:i", strtotime($value->emp_ot_to));
			$shiftIn 	= date("H:i", strtotime($value->emp_ot_work_shift_in));
			$shiftOut 	= date("H:i", strtotime($value->emp_ot_work_shift_out));

			$data['data'][] = array(
									$value->fullName('f m. l'),
									"<span class='emp-ot-date-filed' data-pk='{$id}' data-name='emp_ot_date_filed' data-value='{$value->emp_ot_date_filed}'>".$value->emp_ot_date_filed."</span>", 
									"<span class='emp-ot-date' data-pk='{$id}' data-name='emp_ot_date' data-value='{$value->emp_ot_date}'>".$value->emp_ot_date."</span>",
									"<span class='emp-ot-from' data-pk='{$id}' data-name='emp_ot_from' id='from{$id}' data-value='{$from}'>".date("g:i A", strtotime($value->emp_ot_from))."</span>",
									"<span class='emp-ot-to' data-pk='{$id}' data-name='emp_ot_to' id='to{$id}' data-value='{$to}'>".date("g:i A", strtotime($value->emp_ot_to))."</span>",
									"<span class='emp-ot-total-hours' data-pk='{$id}' data-name='emp_ot_total_hours' data-value='{$value->emp_ot_total_hours}'>".$value->emp_ot_total_hours."</span>",
									"<span class='emp-ot-work-shift-in' data-pk='{$id}' data-name='emp_ot_work_shift_in' data-value='{$shiftIn}'>".date("g:i A", strtotime($value->emp_ot_work_shift_in))."</span>",
									"<span class='emp-ot-work-shift-out' data-pk='{$id}' data-name='emp_ot_work_shift_out' data-value='{$shiftOut}'>".date("g:i A", strtotime($value->emp_ot_work_shift_out))."</span>",
									"<span class='emp-ot-purpose' data-pk='{$id}' data-name='emp_ot_purpose' data-value='{$value->emp_ot_purpose}'>".$value->emp_ot_purpose."</span>",
									"<span class='emp-ot-actual-worked' data-pk='{$id}' data-name='emp_ot_actual_worked' data-value='{$value->emp_ot_actual_worked}'>".$value->emp_ot_actual_worked."</span>",
									"<div class='btn-group'>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' onclick='delete_ot({$id}); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div>"
								);
		}
		echo json_encode($data);
	}

}
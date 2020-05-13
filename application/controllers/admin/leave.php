<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends MY_Controller {


	
	public function index()
	{	
		$allEmp = $this->emp_json();

		$data  = array(
				"allEmp" => $allEmp
				);

		$contents = array(
				$this->load->view('admin/leave/main', $data, true)
			);
		
		$this->create_head_and_navi(
			array(
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

		create_content(array(
			'contentHeader' => 'Leave',
			'breadCrumbs' => true,
			'content' => $contents
			));

		$this->create_footer();
	}
	public function add() {
		$this->load->model('employee_leave');
		$leave = new Employee_Leave;
		$availed = $this->input->post('availed');
		if($availed === 'Others') {
			$availed = $this->input->post('others');
		}
		$leave->employee_id = $this->input->post('emp_id');
		$leave->emp_leave_filed = $this->input->post('date_filed');
		$leave->emp_leave_availment = $availed;
		$leave->emp_leave_days = $this->input->post('days');
		$leave->emp_leave_hours = $this->input->post('hours');
		$leave->emp_leave_from = date("Y-m-d H:i", strtotime($this->input->post('date_from')." ".$this->input->post('date_from_time')));
		$leave->emp_leave_to = date("Y-m-d H:i", strtotime($this->input->post('date_to')." ".$this->input->post('date_to_time')));
		$leave->emp_leave_with_pay = $this->input->post('pay');
		$leave->emp_leave_remark = $this->input->post('remarks');
		$leave->save();
	}
	public function update() {
		$this->load->model('employee_leave');
		$ot = new Employee_Leave;
		$ot->load($this->input->post('pk'));
		$ot->{$this->input->post('name')} = $this->input->post('value');
		$ot->save();
	}
	public function delete() {
		$this->load->model('employee_leave');
		$table = new Employee_Leave;
		$table->load($this->input->post('id'));
		$table->delete();
	}

	public function emp_json()
	{
		$this->load->model('employee');
		$emps         = new Employee;
		$emps->toJoin = array('employment' 		=> 'employee',
								'department' 	=> 'employment');
		$json = array();
		$all  = $emps->get();
		foreach ($all as $key => $value) {
			$earned = $this->fetch_emp_leave_info($value->employee_id);
			$data = array(
						'' 				=> $value->employee_id,
						'fullName' 		=> "<b class='red-text'>".$value->fullName()."</b>",
						'age' 			=> $value->age(),
						'department' 	=> $value->department_name,
						'status' 		=> $value->employment_status,
						'position' 		=> $value->employment_job_title,
						'hired_date'	=> $value->employment_hired_date,
						'gender' 		=> $value->employee_gender,
						'earned' 		=> $earned['vacation']['earned'],
						'used' 			=> $earned['vacation']['used'],
						'balance'		=> $earned['vacation']['earned'] - $earned['vacation']['used'],
						'sick_earned' 	=> $earned['sick']['earned'],
						'sick_used'		=> $earned['sick']['used'],
						'sick_balance' 	=> $earned['sick']['earned'] - $earned['sick']['used'],
						'sil_earned' 	=> $earned['SIL']['earned'],
						'sil_used'		=> $earned['SIL']['used'],
						'sil_balance' 	=> $earned['SIL']['earned'] - $earned['SIL']['used'],
						'ml_earned'		=> $earned['ML']['earned'],
						'ml_used'		=> $earned['ML']['used'],
						'ml_balance'	=> $earned['ML']['earned'] - $earned['ML']['used']
						);

			$json[] = $data;
		}

		return json_encode($json);
	}
	public function fetch_emp_leave_info($emp_id)
	{
		$this->load->model('employee');
		$this->load->model('employee_leave');

		$emp 	= new Employee;
		$emp->load_with_employment_info($emp_id);
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
		$totalSILUsed 	= 0;
		$totalMenstrualUsed = 0;

		foreach ($leaveUsed as $key => $value) {
			if ($value->emp_leave_availment == 'Vacation Leave') {
				$totalUsed += $value->emp_leave_days;
				// $totalUsed += round($value->emp_leave_hours / 8,2); 
			}
			elseif($value->emp_leave_availment == 'Sick Leave'){
				$totalSickUsed += $value->emp_leave_days;
				// $totalSickUsed += round($value->emp_leave_hours / 8,2);
			}
			elseif($value->emp_leave_availment == 'Service Incentive Leave'){
				$totalSILUsed += $value->emp_leave_days;
				// $totalSILUsed += round($value->emp_leave_hours / 8,2);
			}
			elseif($value->emp_leave_availment == 'Menstrual Leave'){

				$dateArray = $this->funcs->datesInArray($value->emp_leave_from,$value->emp_leave_to);
				foreach ($dateArray as $key2 => $value2) {
					if($value2->format('m') == date('m')){
						$totalMenstrualUsed += 1;
					}
				}

			}
		}

		$leave_info['vacation']['used'] = $totalUsed;
		$leave_info['vacation']['earned'] = 0;
		$leave_info['sick']['earned'] 	= strtolower($emp->employment_type) == 'regular' ? 15 : 0;
		$leave_info['sick']['used'] 	= $totalSickUsed;
		$leave_info['SIL']['earned'] 	= 0;
		$leave_info['SIL']['used'] 		= $totalSILUsed;
		$leave_info['ML']['earned'] 	= 0.5;
		$leave_info['ML']['used'] 		= $totalMenstrualUsed;

		// if employee is a year and above in tenure and is not regular he/she can only avail SIL

		if($tenure['years'] >= 1 && strtolower($emp->employment_type) != "regular" ){
			$leave_info['SIL']['earned'] = 5;
		}
		elseif(strtolower($emp->employment_type) == "regular"){
			$leave_info['vacation']['earned'] = (date('m') - 1) * 1.25 ;
		}

		return $leave_info;
	}
	public function leave_json() {
		$this->load->model('employee_leave');
		$leave = new Employee_Leave;

		$leave->toJoin = array('employee' => 'employee_leave');
		$all = $leave->get();

		$data = array('data' => array());


		// echo "{ data : [";


		foreach ($all as $key => $value) {
			$id = $value->emp_leave_id;
			$pay = $value->emp_leave_with_pay;
			if($pay == 1) {
				$pay = "With Pay";
			}elseif($pay == 0){
				$pay = "Without Pay";
			}if($value->emp_leave_request_status == 0){
				$status = 'pending';
			}if($value->emp_leave_request_status == 1){
				$status = 'approved';
			}if($value->emp_leave_request_status == 2){
				$status = 'rejected';
			}
			

			$data['data'][] = array(
									$value->fullName('f m. l'), 
									"<span class='emp-leave-filed' data-pk='{$id}' data-name='emp_leave_filed' data-value='{$value->emp_leave_filed}'>".$value->emp_leave_filed."</span>",
									"<span class='emp-leave-availment' data-pk='{$id}' data-name='emp_leave_availment' data-value='{$value->emp_leave_availment}'>".$value->emp_leave_availment."</span>",
									"<span class='emp-leave-from' data-pk='{$id}' data-name='emp_leave_from' data-value='{$value->emp_leave_from}'>".$value->emp_leave_from."</span>",
									"<span class='emp-leave-to' data-pk='{$id}' data-name='emp_leave_to' data-value='{$value->emp_leave_to}'>".$value->emp_leave_to."</span>",
									"<span class='emp-leave-days' data-pk='{$id}' data-name='emp_leave_days' data-value='{$value->emp_leave_days}'>".$value->emp_leave_days."</span>",
									"<span class='emp-leave-hours' data-pk='{$id}' data-name='emp_leave_hours' data-value='{$value->emp_leave_hours}'>".$value->emp_leave_hours."</span>",
									"<span class='emp-leave-with-pay' data-pk='{$id}' data-name='emp_leave_with_pay' data-value='{$value->emp_leave_with_pay}'>".$pay."</span>",
									"<span class='emp-leave-remark' data-pk='{$id}' data-name='emp_leave_remark' data-value='{$value->emp_leave_remark}'>".$value->emp_leave_remark."</span>",
									ucfirst($status),
									"<div class='btn-group hidden-xs hidden-sm visible-md visible-lg'>
										<button type='button' class='btn btn-flat btn-xs btn-success' title='Approve' onclick='approve({$id})' id='approve'>
					        				<span class='fa fa-check'></span>
					        			</button>
					        			<button onclick='reject({$id})' type='button' class='btn btn-flat btn-xs btn-warning' title='Reject'>
					        				<span class='fa fa-times'></span>
					        			</button>
										<button type='button' class='btn btn-flat btn-xs btn-danger dropdown-toggle' data-toggle='dropdown' aria-expanded='false' title='Delete'>
											<span class='glyphicon glyphicon-trash'></span>
										</button>
										<ul class='dropdown-menu pull-right' role='menu'>
											<li class='text-center'><span class='label alert-warning'>Are you sure?</span></li>
											<li class='text-center'><a href='#' onclick='delete_leave({$id}); return false;'>Yes</a></li>
											<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
										</ul>
									</div><div class='btn-group visible-xs visible-sm hidden-md hidden-lg'>
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
												<li><a href='#' type='button' title='Approve' onclick='approve({$id})' id='approve'><span class='fa fa-check'></span> Approve</a></li>
				                        		<li>
													<a href='#' onclick='reject({$id})' type='button' title='Reject'>
							        					<span class='fa fa-times'></span> Reject
							        				</a>
					                            </li>
				                        	</ul>

										</div>		
									 </div>"
									
								);
		}
			echo json_encode($data);


	}

	public function approve(){
		$this->load->model('employee_leave');
		$el = new Employee_Leave;
		$el->load($this->input->post('id'));
		$el->emp_leave_request_status = 1;
		$el->save();
	}

	public function reject(){
		$this->load->model('employee_leave');
		$el = new Employee_leave;
		$el->load($this->input->post('id'));
		$el->emp_leave_request_status = 2;
		$el->save();
	}
} 
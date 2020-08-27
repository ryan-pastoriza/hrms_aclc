<?php
/**
 * @Author: gian
 * @Date:   2015-12-09 10:22:39
 * @Last Modified by:   Gian Carl Anduyan
 * @Last Modified time: 2020-08-19 11:17:47
 */
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Payroll extends MY_Controller {

	public function test()
	{
		$emp = new Employee;

		$emp->load_with_employment_info("BTN-2014-0271");
		$emp->get_rates();

		$sss = $emp->attendance("2018-10-21", "2018-11-05");

		echo "<pre>";
		print_r ($sss);
		echo "</pre>";
	}
	public function test1()
	{
	   $this->load->model('depts_def_sched_nfds');
	   $this->load->model('Department_irregular_sched');
	   $this->load->model('eec_nfds');
			
		// delete all employee schedule

		$emp = new Employee;
		$emps = $emp->get_all();

		foreach ($emps as $key => $value) {
			$empInfo = new Employee;
			$empInfo->load_with_employment_info($value->employee_id);

				$sched = $empInfo->emp_scheds();

				foreach ($sched as $key2 => $value2) {

					if (get_class($value2) == "Eec_Nfds") {
						$eecNfds = new Eec_Nfds;
						$eecNfds->load($value2->eec_nfds_id);
						$eecNfds->end = "2018-03-30";
						$eecNfds->save();
					}
					else{
						$value2->delete();
					}

					// $value2->delete();
				}
		}

		// end delete all employee schedule

		// delete  all department sched
	   $this->load->model('department');
	   $depts = new Department;
	   $all_depts = $depts->get();

	   foreach ($all_depts as $key => $value) {
	   		$sched = $value->sched();
	   		

	   		foreach ($sched as $key2 => $value2) {
	   			if (get_class($value2) == "Depts_Def_Sched_Nfds") {
	   				$NDDSN = new Depts_Def_Sched_Nfds;
	   				$NDDSN->load($value2->ddsnfds_id);
		   			$NDDSN->end = "05-09-2018";
	   				$NDDSN->save();
	   			}
	   			else{
	   				if (strtotime($value2->sched_from_date) >= strtotime("05-09-2018") ) {
	   					$value2->delete();
	   				} 
	   			}
	   		}

	   }
		// end delete  all department sched

	   // set each department schedule
	   	// needed NFDS
	   $this->load->model('non_flexi_daily_scheds');
	   $nfds_ids = [];
	   $dows = ['mon','tue','wed','thu','fri'];
	   $nfds = new Non_Flexi_Daily_Scheds;

	   foreach ($dows as $key => $value) {
	   		$sched_am = $nfds->save_or_get(['nfds_day' => $value, 'nfds_time_in' => '08:00', 'nfds_time_out' => '12:00'], ['nfds_day' => $value, 'nfds_time_in' => '08:00', 'nfds_time_out' => '12:00'],  'Non_Flexi_Daily_Scheds');
 	  		$sched_pm = $nfds->save_or_get(['nfds_day' => $value, 'nfds_time_in' => '13:00', 'nfds_time_out' => '17:00'], ['nfds_day' => $value, 'nfds_time_in' => '13:00', 'nfds_time_out' => '17:00'],  'Non_Flexi_Daily_Scheds');


 	  		 foreach ($all_depts as $key => $value) {
 	  		 	$ddsnfds_am = new Depts_Def_Sched_Nfds;
 	  		 	$ddsnfds_am->nfds_id = $sched_am->nfds_id;
 	  		 	$ddsnfds_am->department_id = $value->department_id;
 	  		 	$ddsnfds_am->start = "05-09-2018";
 	  		 	$ddsnfds_am->save();

 	  		 	$ddsnfds_pm = new Depts_Def_Sched_Nfds;
 	  		 	$ddsnfds_pm->nfds_id = $sched_pm->nfds_id;
 	  		 	$ddsnfds_pm->department_id = $value->department_id;
 	  		 	$ddsnfds_pm->start = "05-09-2018";
 	  		 	$ddsnfds_pm->save();

			   }

	   }

	   // end set each department schedule
	}
	public function index(){

		$this->create_head_and_navi([
										asset_url('plugins/daterangepicker/moment.min.js'),
										asset_url('plugins/daterangepicker/daterangepicker.js'),
									]);

		$empData = $this->emp_json_data();
		$content = $this->load->view('admin/payroll/main',array('empData' => $empData),TRUE);

		create_content(['contentHeader' => 'Payroll',
						'content' => $content]);

		$this->create_footer([ 
								$this->load->view('admin/payroll/jscripts',[], TRUE)
							]);
	}
	public function admin_rate($empId="",$department=""){
		$this->load->model('employee');
		$employee = new Employee;

		$employee->toJoin = array('employment' => 'employee',
								  'department' => 'employment');
		$emp = $employee->search("employees.employee_id = $empId");
		$emp = reset($emp);
		if($department == "Admin"){
			$perDay =  (($emp->employment_rate * 12)/314);
			return number_format($perDay,2);
		}else if($department == "faculty"){
			$this->partime_rate($empId);
		}
	}
	public function partime_rate($empId="",$department){
		$this->load->model('employee');
		$employee->toJoin = array('employment' => 'employee',
								  'department' => 'employment');
		$emp = $employee->search("employees.employee_id = $empId");
		$emp = reset($emp);

		$ratePerHr = ($emp->employment_rate / 120);
		return number_format($ratePerHr,2);
	}
	public function generate_emp_proll()
	{

		$this->load->model('employee');
		$emp = new Employee;

		$emp->load_with_employment_info($this->input->post('employee_id'));
		$emp->get_rates();
		$data = array();

		$attRec = $emp->attendance($this->input->post('cut_off_start'), $this->input->post('cut_off_end'));
		$ot 	= $emp->ot_rendered_on_dates($this->input->post('cut_off_start'), $this->input->post('cut_off_end'));


		$data['lateTotal']		 = $attRec['minutes_late'];
		$data['ut']				= $attRec['minutes_undertime'] > 0 ? $attRec['minutes_undertime'] / 60 : 0;
		$data['overtime'] 		= $ot['ot_hours'];
		$data['employee'] 		 = $emp;
		$data['absentDays']		 = $attRec['days_absent'];
		$data['cut_off'] 		 = date('F d, Y', strtotime($this->input->post('cut_off_start')))." to ". date('F d, Y', strtotime($this->input->post('cut_off_end')));
		$data['payroll_date'] 	= date('F d, Y', strtotime($this->input->post('proll_date')));
		$data['sss'] 	   		= $this->input->post('sss') ? true : false;
		$data['philhealth'] 	= $this->input->post('philhealth') ? true : false;
		$data['pagibig'] 		= $this->input->post('pagibig') ? true : false;
		$data['adjustments']	= $this->input->post('adjustments');
		$data['isForm']			= true;
		
		$this->load->view('admin/payroll/payslip_form',$data, FALSE);
		$data['isForm']			= false;
		$this->load->view('admin/payroll/payslip_form',$data, FALSE);
	}
	public function generate_payroll(){
		$this->load->model('employee');
		$emps 	= [];
			$posted_emps = json_decode($this->input->post('tbl_cb'));
			if ($posted_emps) {
				foreach ($posted_emps as $key => $value) {
					$emp 	= new Employee;
					$emp->load($value);
					if (isset($this->input->post('adjustments')[$value])) {
						$emp->adjustments = [];

				
						foreach ($this->input->post('adjustments')[$value]['name'] as $key2 => $value2) {
								$emp->adjustments[] = ['name' 	 => $value2,
														'amount' => $this->input->post('adjustments')[$value]['amount'][$key2],
														];
						}
					}
					$emps[]	= $emp;
				}
			}

		$data['employees'] 	= $emps;
	
		$this->load->view('admin/payroll/generate_page', $data, FALSE);
	}
	public function save_payroll()
	{
		set_time_limit(0);

		$this->load->model('payroll_record');
		$this->load->model('emp_payroll_rec');
		$this->load->model('emp_loan_payment');
		$this->load->model('payroll_loan_payment');
		$this->load->model('emp_ca_payment');
		$this->load->model('payroll_ca_payment');
		$this->load->model('payroll_adjustment');
		$this->load->model('emp_other_deduction_payment');
		$this->load->model('payroll_eod_payment');

		$payroll = new Payroll_record;

		$prollCreated = $this->payroll_calculated($this->input->post('pr_date'),$this->input->post('pr_cut_off_from'),$this->input->post('pr_cut_off_to'),false);

		// overriding payroll records
		if ($prollCreated->pr_id != '') {

			$payroll->load($prollCreated->pr_id);

			// deleting payroll records per employee
			$eprs = new Emp_payroll_rec;
			$eprs = $eprs->search(['pr_id' => $prollCreated->pr_id]);

			foreach ($eprs as $key => $value) {

				// deleting loan payments of the overriden payroll
				$plp 	= new Payroll_loan_payment;
				$plps 	= $plp->search(['emp_proll_id' => $value->emp_proll_id]);
				foreach ($plps as $loan => $payment) {
					$emp_loan_payment = new Emp_loan_payment;
					$emp_loan_payment->load($payment->el_payment_id);
					$emp_loan_payment->delete();
				}

				// deleting CA payments of the overriden payroll
				$pcps = new Payroll_ca_payment;
				$pcps = $pcps->search(['emp_proll_id' => $value->emp_proll_id]);
				foreach ($pcps as $ca => $pp) {
					$ecapths = new Emp_Ca_Payment;
					$ecapths->load($pp->ca_payment_id);
					$ecapths->delete();
				}

				// deleting Other Deduction payments of the overridden payroll
				$peps = new Payroll_eod_payment;
				$peps = $peps->search(['emp_proll_id' => $value->emp_proll_id]);

				foreach ($peps as $pep => $pepPay) {
					$eodp = new Emp_Other_Deduction_Payment;
					$eodp->load($pepPay->eod_payment_id);
					$eodp->delete();
				}

				$value->delete();
			}




		}
		$payroll->pr_date 				= $this->input->post('pr_date');
		$payroll->pr_cut_off_from 		= $this->input->post('pr_cut_off_from');
		$payroll->pr_cut_off_to 		= $this->input->post('pr_cut_off_to');

		$payroll->save();

		foreach ($this->input->post('employment_id') as $key => $value) {
			$emp_proll_rec = new Emp_payroll_rec;

			$emp_proll_rec->employment_id 			= $value;
			$emp_proll_rec->pr_id 					= $payroll->pr_id;
			$emp_proll_rec->emp_proll_ot_hrs		= $this->input->post('emp_proll_ot_hrs')[$key];
			$emp_proll_rec->emp_proll_ot_pay		= $this->input->post('emp_proll_ot_pay')[$key];
			$emp_proll_rec->emp_proll_pay 			= $this->input->post('emp_proll_pay')[$key];
			$emp_proll_rec->emp_proll_absent 		= $this->input->post('emp_proll_absent')[$key];
			$emp_proll_rec->emp_proll_wtax 			= $this->input->post('emp_proll_wtax')[$key];
			$emp_proll_rec->emp_proll_sss			= $this->input->post('emp_proll_sss')[$key];
			$emp_proll_rec->emp_proll_philhealth 	= $this->input->post('emp_proll_philhealth')[$key];
			$emp_proll_rec->emp_proll_hdmf 			= $this->input->post('emp_proll_hdmf')[$key];
			$emp_proll_rec->emp_proll_absent_days 	= $this->input->post('emp_proll_absent_days')[$key];
			$emp_proll_rec->emp_proll_late_mins 	= $this->input->post('emp_proll_late_mins')[$key];
			$emp_proll_rec->emp_proll_late_ded		= $this->input->post('emp_proll_late_ded')[$key];
			$emp_proll_rec->emp_proll_ut_mins 		= $this->input->post('emp_proll_ut_mins')[$key];
			$emp_proll_rec->emp_proll_ut_ded		= $this->input->post('emp_proll_ut_ded')[$key];

			$emp_proll_rec->save();

			if (isset($this->input->post('loans')[$key])) {
				foreach ($this->input->post('loans')[$key] as $loan_id => $amount_deducted) {
					$elp = new Emp_loan_payment;
					$elp->emp_loan_id = $loan_id;
					$elp->el_payment_date = $this->input->post('pr_date');
					$elp->el_payment_option = "payroll";
					$elp->el_payment_amount = $amount_deducted;
					$elp->save();

					$plp = new Payroll_loan_payment;
					$plp->el_payment_id = $elp->el_payment_id;
					$plp->emp_proll_id = $emp_proll_rec->emp_proll_id;
					$plp->save();
				}
			}
			if (isset($this->input->post('cash_advances')[$key])) {
				foreach ($this->input->post('cash_advances')[$key] as $ca_id => $paid) {
					$ecap = new Emp_Ca_Payment;
					$ecap->emp_ca_id 			= $ca_id;
					$ecap->ca_payment_amt 		= $paid;
					$ecap->ca_payment_option 	= "Payroll";
					$ecap->ca_payment_date 		= $this->input->post('pr_date');
					$ecap->save();

					$pcp = new Payroll_ca_payment;
					$pcp->ca_payment_id = $ecap->ca_payment_id;
					$pcp->emp_proll_id = $emp_proll_rec->emp_proll_id;
					$pcp->save();

				}
			}
			if (isset($this->input->post('adjustments')[$key]['amount'])) {
				foreach ($this->input->post('adjustments')[$key]['amount'] as $key2 => $value2) {
					$proll_adj = new Payroll_adjustment;
					$proll_adj->emp_proll_id = $emp_proll_rec->emp_proll_id;
					$proll_adj->proll_adj_amt = $value2;
					$proll_adj->proll_adj_name = $this->input->post('adjustments')[$key]['name'][$key2];
					$proll_adj->save();
				}
			}
			if (isset($this->input->post('other_deductions')[$key])) {
				foreach ($this->input->post('other_deductions')[$key] as $key2 => $value2) {
					$eodPay = new Emp_Other_Deduction_Payment;
					$eodPay->eod_id 			= $key2;
					$eodPay->eod_payment_date 	= $this->input->post('pr_date');
					$eodPay->eod_payment_option = "Payroll";
					$eodPay->eod_payment_amount = $value2;
					$eodPay->save();

					$payroll_eod_payment = new Payroll_eod_payment;
					$payroll_eod_payment->emp_proll_id = $emp_proll_rec->emp_proll_id;
					$payroll_eod_payment->eod_payment_id = $eodPay->eod_payment_id;
					$payroll_eod_payment->save();
				}
			}
		}
	}
	public function payroll_calculated($payroll_date,$payroll_from, $payroll_to,$json = true)
	{
		$this->load->model('payroll_record');

		$payroll_date 	= date('Y-m-d',strtotime($payroll_date));
		$payroll_from 	= date('Y-m_d', strtotime($payroll_from));
		$payroll_to 	= date('Y-m-d', strtotime($payroll_to));
		$toret 			= ['success' => true,
							'txt' => ''];

		$prec = new Payroll_record;
		$prec = $prec->pop("pr_date = '{$payroll_date}' OR (('{$payroll_from}' BETWEEN pr_cut_off_from AND pr_cut_off_to) OR ('{$payroll_to}' BETWEEN pr_cut_off_from AND pr_cut_off_to) OR (pr_cut_off_from BETWEEN '{$payroll_from}' AND '{$payroll_to}') OR (pr_cut_off_to BETWEEN '{$payroll_from}' AND '{$payroll_to}')  ) ");
		if (!$json) {
			return $prec;
		}
		if ($prec->pr_id != "") {
			$toret['success'] 	= false;
			$toret['txt']	 	= "Payroll calculation cut-off conflict detected!<br>Would you like to override the previous data?<hr style='border-width:1px; border-color:red'>
									<button onclick='save_payroll()'>Yes</button> <button>No</button>
									";
		}
		echo json_encode($toret);
	}
	public function payroll_rec_json()
	{
		$this->load->model('emp_payroll_rec');

		$prec = new Emp_payroll_rec;
		$prec->toJoin = ['payroll_record' => 'emp_payroll_rec',
						'employment' => 'emp_payroll_rec',
						'employee' => 'employment'];

		$data = ['data' => []];

		$precs = $prec->search();

		foreach ($precs as $key => $value) {
			$data['data'][] = [	$value->pr_date,
								$value->pr_cut_off_from." - ". $value->pr_cut_off_to,
								$value->fullName(),
								"Php ".$value->emp_proll_ot_pay,
								"Php ".$value->emp_proll_late,
								"Php ".$value->emp_proll_absent,
								"Php ".$value->emp_proll_wtax,
								"Php ".$value->emp_proll_sss,
								"Php ".$value->emp_proll_philhealth,
								"Php ".$value->emp_proll_hdmf
								];
		}

		echo json_encode($data);
	}
	public function payroll_record_view()
	{
		$day = $this->input->post('date') == "15th" ? 15 : date('t', strtotime("1990-".$this->input->post('month')."-20"));
		$date = $this->input->post('year')."-".$this->input->post('month')."-".$day;

		if ($this->input->post('month') == "") {
			echo "<center><h3>SELECT MONTH</h3></center>";
			return;
		}
		elseif($this->input->post('year') == ""){
			echo "<center><h3>SELECT YEAR</h3></center>";
			return;	
		}
		elseif($this->input->post('date') == ""){
			echo "<center><h3>SELECT DATE</h3></center>";
			return;	
		}
		else{
			$this->load->model('payroll_record');

			$prec = new Payroll_record;
			$pRec = $prec->pop(['pr_date' => $date]);

			$data = ['record' => $pRec];

			$this->load->view('admin/payroll/payroll_record/main', $data, FALSE);

		}
	}
}
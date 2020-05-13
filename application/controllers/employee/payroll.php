<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends MY_Controller {

	public function index()
	{
		$this->userInfo->get_rates();

		$this->create_head_and_navi([
									asset_url('plugins/daterangepicker/moment.min.js'),
									asset_url('plugins/daterangepicker/daterangepicker.js'),
									]);
		$content  = $widget4 = lte_widget(4,array('header' 	=> 'Payslip',
								  'body' 	=> $this->load->view('employee/payslip/form', [], TRUE),
								  'col_grid'=> col_grid(12,12,6,5,3),
								  'bgColor'	=> 'box-info',
								   ));

		$content .= $widget5 = lte_widget(5,array('header' 	=> 'Payslip Record',
									'body'		=>	$this->load->view("admin/payroll/payroll_record", FALSE, TRUE),
									'col_grid'	=>	col_grid(12,12,6,7,9),
									'bgColor'	=>	'box-info',
									));

		create_content(array('contentHeader' => 'Payroll',
							 'breadCrumbs'	 => true,
							 'content'       => [$content]
							)
					  );

		$this->create_footer([
							$this->load->view('employee/payslip/jscript', [], TRUE)
							]);
	}


	public function payroll_rec_json()
	{
		$emp_id = $this->userInfo->employment_id;
		$this->load->model('emp_payroll_rec');

		$prec = new Emp_payroll_rec;

		$prec->toJoin = ['payroll_record' => 'emp_payroll_rec',
						'employment' => 'emp_payroll_rec',
						'employee' => 'employment'];

		$precs = $prec->search(['emp_payroll_rec.employment_id' => $emp_id ,]);

		$data = ['data' => []];

		foreach ($precs as $key => $value) {
			$data['data'][] = [	$value->pr_date,
								$value->pr_cut_off_from." - ". $value->pr_cut_off_to,
								$value->fullName(),
								"Php ".$value->emp_proll_ot,
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
	public function search_payslip()
	{
		$this->userInfo->get_rates();
		$data = [];

		if ($this->input->post('proll_month') != "" && $this->input->post('proll_date') != "" && $this->input->post('proll_year') != "") {
			$this->load->model('emp_payroll_rec');
			$epr = new Emp_payroll_rec;
			$epr->toJoin = ['payroll_record' => 'emp_payroll_rec'];
			$day = $this->input->post('proll_date') == "15th" ? 15 : date('t',strtotime("1990-".$this->input->post('proll_month')."-21"));
			
			$epr = $epr->pop(['employment_id' => $this->userInfo->employment_id,
						'pr_date' => date('Y-m-d', strtotime($this->input->post('proll_year')."-".$this->input->post('proll_month')."-".$day)) ]);


			if (isset($epr->pr_date) && $epr->pr_date != "") {
				$data['payroll_date'] = $epr->pr_date;
				$data['epr'] = $epr;
			}
		}

		$this->load->view('employee/payslip/payslip', $data, FALSE);
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
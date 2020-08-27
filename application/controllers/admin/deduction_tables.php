<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deduction_tables extends MY_Controller {

	public function test()
	{
		$ans = (2.75 / 100) * 10000;

		echo $ans;
	}
	public function index()
	{
		$this->calculate_wtax_bracket();
	}
	public function sss(){
		$tableHeaders 	= array('Range of Compensation','Employer Share','Employee Share','Total Contribution','');
		$tableRows		= array();

		$tableOptions = array('ajax' =>  base_url('index.php/admin/deduction_tables/sss_json'),
							'paging' => false,
							'ordering' => true,
							'aoColumns' => array(null,array('bSortable' => false),array('bSortable' => false),array('bSortable' => false),array('bSortable' => false)),
							'aaSorting' => array(),
							);

		$tblCallBacks = array('fnDrawCallback' => "function(){
														$('.sss_range_from').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_sss')."', success: function(r){sss_table.ajax.reload()}});
														$('.sss_range_to').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_sss')."', success: function(r){sss_table.ajax.reload()}});
														$('.sss_ee_cont').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_sss')."', success: function(r){sss_table.ajax.reload()}});
														$('.sss_er_cont').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_sss')."', success: function(r){sss_table.ajax.reload()}});
													}");


		$table = lte_table(array('tableHeaders' => $tableHeaders,
								'tableRows' => $tableRows,
								'tableId' => 'sss-table',
								'tableOptions' => $tableOptions,
								'tblCallBacks' => $tblCallBacks,
								'tblVarName' => 'sss_table'
								));

		$content1 = lte_tab(array('tabs' => ['Contribution Table' => $table,
											 'Contribution Record' => $this->load->view('admin/deduction_tables/sss/contrib_rec_tbl',[], TRUE)
											],
										'tab_id' => 'sss-contrib-tabs',
										'col_grid' => col_grid(12,12,12,10),
										));

		// $content2 = $this->load->view('admin/deduction_tables/sss/jscripts',array(), TRUE);

		$contents = array($content1);

		$this->create_head_and_navi(array(asset_url('bootstrap-editable/js/bootstrap-editable.min.js')));

		create_content(array('contentHeader' => "SSS",
							'breadCrumbs' => true,
							'content' => $contents,
							'cssPlugins'=> array(asset_url('bootstrap-editable/css/bootstrap-editable.css'))));


		$this->create_footer(array($this->load->view('admin/deduction_tables/sss/jscripts',array(), TRUE)));
	}
	public function sss_contrib_rec_json()
	{
		$this->load->model('emp_payroll_rec');
		$epr = new Emp_payroll_rec;
		$epr->toJoin = ['payroll_record' 	=> 'emp_payroll_rec',
						'employment' 		=> 'emp_payroll_rec',
						'employee' 			=> 'employment'];
		$eprs = $epr->get();

		$data = ['data' => [] ];

		$this->load->model('sss');

		foreach ($eprs as $key => $value) {
			$sss = new Sss;
			$sssEE = $sss->search(['sss_er_cont' => $value->emp_proll_sss]);

			foreach ($sssEE as $key2 => $value2) {
				$data['data'][] = [
								   $value->pr_date,
								   $value->fullName('l f, m.'),
								   "Php ".number_format($value->emp_proll_sss,2),
								   "Php ".number_format($value2->sss_ee_cont,2),
								   "Php ".number_format(($value2->sss_ee_cont + $value->emp_proll_sss),2),
							];
			}	
			
 		}

 		echo json_encode($data);

	}
	public function calculate_wtax_bracket($emp_id = null)
	{
		$this->load->model('employee');

		$emp = new Employee;
		$emp->toJoin = ['employment' => 'employee'];

		if ($this->input->post('employee_id')) {
			$emp->load_with_employment_record($this->input->post('employee_id'));

			if ($emp->employee_fname != "") {
				$empRate = $emp->employment_rate;

				$dailyRate 		= isset($emp->daily_rate) ? $emp->daily_rate : "<i class='text-red'>Rate not set.</i>"; 
				$weeklyate 		= isset($emp->weekly_rate) ? $emp->weekly_rate : "<i class='text-red'>Rate not set.</i>"; 
				$semi_monthly 	= isset($emp->semi_monthly_rate) ? $emp->semi_monthly_rate : "<i class='text-red'>Rate not set.</i>"; 
				$monthlyRate 	= isset($emp->monthly_rate) ? $emp->monthly_rate : "<i class='text-red'>Rate not set.</i>"; 

				$dailyBracket 		= $emp->tax_bracket('daily');
				$weeklyBracket 		= $emp->tax_bracket('weekly');
				$semiMonthlyBracket = $emp->tax_bracket('semi-monthly');
				$monthlyBracket 	= $emp->tax_bracket('monthly');


				$data = array(
								['Daily', 			$dailyBracket->wtax_bracket_status, 		number_format($dailyBracket->wtax_bracket_base,2 ),			$dailyBracket->wtax_bracket_percent_over."%" ],
								['Weekly', 			$weeklyBracket->wtax_bracket_status, 		number_format($weeklyBracket->wtax_bracket_base,2) ,		 $weeklyBracket->wtax_bracket_percent_over."%" ],
								['Semi-monthly', 	$semiMonthlyBracket->wtax_bracket_status, 	number_format($semiMonthlyBracket->wtax_bracket_base,2) , $semiMonthlyBracket->wtax_bracket_percent_over."%" ],
								['Monthly', 		$monthlyBracket->wtax_bracket_status, 		number_format($monthlyBracket->wtax_bracket_base,2) ,	 $monthlyBracket->wtax_bracket_percent_over."%" ],

							);
			}
			else{
					$data = array(
						['Daily','0.00','0.00','0.00'],
						['Weekly','0.00','0.00','0.00'],
						['Semi-Monthly','0.00','0.00','0.00'],
						['Monthly','0.00','0.00','0.00'],
					);
			}
		}
		else{
			$data = array(
					['Daily','0.00','0.00','0.00'],
					['Weekly','0.00','0.00','0.00'],
					['Semi-Monthly','0.00','0.00','0.00'],
					['Monthly','0.00','0.00','0.00'],
				);
		}

		echo json_encode($data);
	}
	public function philhealth(){

		$tableOptions = array('ajax' =>  base_url('index.php/admin/deduction_tables/philhealth_json'),
								'paging' => false,
								'ordering' => true,
								'aaSorting' => array(),
							);
		$tblCallBacks = array('fnDrawCallback' => "function(){
								$('.phic-salary-range-from').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_phic')."', success: function(){ phic_table.ajax.reload()} });
								$('.phic-salary-range-to').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_phic')."', success: function(){ phic_table.ajax.reload()}});
								$('.phic-ee-share').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_phic')."', success: function(){ phic_table.ajax.reload()}});
								$('.phic-er-share').editable({mode:'inline',url:'".base_url('index.php/admin/deduction_tables/edit_phic')."', success: function(){ phic_table.ajax.reload()}});
							}");
		$phicTblVars = array('tableHeaders' => array('Salary Bracket',"Monthly Premium",'Actions'),
							'tableRows'	 	=> array(),
							'tableOptions' 	=> $tableOptions,
							'tableId' 		=> 'philhealth-table',
							'tblCallBacks' 	=> $tblCallBacks,
							'tblVarName' 	=> 'phic_table');

		$phicTbl = lte_table($phicTblVars);



		$tab = lte_tab(array('tabs' => array('Contribution Table' => $phicTbl, 
											'Contribution Record' => $this->load->view('admin/deduction_tables/philhealth/contribution_record_tbl',[],TRUE)),
							'tab_id' => "phic-tabs",
							'col_grid' => col_grid(12,12,12,10)));


		$contents = array($tab);



		$contentVars = array('contentHeader' 	=> 'PHILHEALTH',
							'breadCrumbs' 		=> true,
							'content' 			=> $contents,
							'cssPlugins'		=> array(asset_url('bootstrap-editable/css/bootstrap-editable.css')));

		$this->create_head_and_navi(array(asset_url('bootstrap-editable/js/bootstrap-editable.min.js')));
		create_content($contentVars);
		$this->create_footer(array($this->load->view('admin/deduction_tables/philhealth/jscripts', array(), TRUE)));
	}
	public function phic_contrib_json()
	{
		$this->load->model('emp_payroll_rec');
		$epr = new Emp_payroll_rec;

		$epr->toJoin = ['payroll_record' => 'emp_payroll_rec',
						'employment' => 'emp_payroll_rec',
						'employee' 	=> 'employment'];
		$eprs = $epr->get();
		$data = ['data' => []];

		$this->load->model('philhealth');
		foreach ($eprs as $key => $value) {
			$ph = new Philhealth;
			// $phEE = $ph->search(['ph' => number_format($value->emp_proll_philhealth,2)]);
			$phEE = $ph->db->query("SELECT * FROM philhealth WHERE phic_salary_range_from < '{$value->employment_rate}' AND phic_salary_range_to >  '{$value->employment_rate}'");

			foreach ($phEE->result_array() as $key2 => $value2) {

				$data['data'][] = [$value->pr_date,
								$value->fullName('l f, m.'),
								$value2['phic_monthly_premium'],
								"Php ".number_format($value->emp_proll_philhealth,2),
								"Php ".number_format($value->emp_proll_philhealth,2),
								"Php ".number_format((number_format($value->emp_proll_philhealth,2)*2),2),
							  ]; 
			}
			
		}
		echo json_encode($data);

	}
	public function pagibig()
	{
		$tableOptions = array('ajax' => base_url('index.php/admin/deduction_tables/pagibig_json'));
		$tableCallbacks = array('fnDrawCallback' => "function(){
														$('.ee-share').editable({mode:'inline',url: '".base_url("index.php/admin/deduction_tables/edit_phic_contrib")."'});
													}");


		$contTblVars = array('tableHeaders' => array(
														'Employee', 'Employee Share'
													),
							'tableRows' => array(),
							'tableId' => 'pagibig-table',
							'tableOptions' => $tableOptions,
							'tblCallBacks' => $tableCallbacks,
							'tblVarName' => "pagibig_tbl");

		$contTbl = lte_table($contTblVars);

		$tabVars = array('tabs' => array('Contribution Table' => $contTbl,
										'Contrbution Record' => $this->load->view('admin/deduction_tables/pagibig/contribution_rec_tbl',[], TRUE)),
						'tab_id' => 'pagibig-tabs',
						);

		$tabs = lte_tab($tabVars);

		$contentVars = array('contentHeader' => 'PAG-IBIG',
							 'breadCrumbs' => true,
							 'content' => $tabs,
							 'footer');

		$this->create_head_and_navi();
		create_content($contentVars);
		$this->create_footer();
	}
	public function pagibig_contribution_json()
	{
		$this->load->model('emp_payroll_rec');
		//gian author
		$this->load->model('employee');
		$this->load->model('employment');
		$this->load->model('employment_application_form');

		$eaf = new Employment_Application_Form;
		$emp = new Employee;
		$employment = new Employment;
		$emp->toJoin = ["employment_application_form" => "employee"];
		//end gian author

		$epr = new Emp_payroll_rec;
		$epr->toJoin = ['employment' 		=> 'emp_payroll_rec',
						'employee' 			=> 'employment',
						'payroll_record' 	=> 'emp_payroll_rec'];

		$eprs = $epr->get();
		$data = ['data' => []];

		foreach ($eprs as $key => $value) {
			$employment->load($value->employment_id);
			$emp->load($employment->employee_id);			
			
			
			$tin = $employment->tin_no != "" ? $employment->tin_no : $emp->eaf_TIN;
			$pagibig = $employment->pagibig_no != "" ? $employment->pagibig_no :  $emp->eaf_pagibig;
			$philhealth = $employment->philhealth_no != "" ? $employment->philhealth_no : $emp->eaf_philhealth;
			$sss = $employment->sss_no != "" ? $employment->sss_no : $emp->eaf_SSS;
			
				$data['data'][] = [
									$value->pr_date,
									$pagibig,
									$tin,
									date('m/d/Y',strtotime($value->employee_bday)),
									$sss,
									"F1",
									ucfirst($value->employee_lname),
									ucfirst($value->employee_fname),
									ucfirst($value->employee_ext),
									ucfirst($value->employee_mname),
									date("Ym",strtotime($value->pr_date)),
									"Php ".	number_format($value->emp_proll_hdmf,2),
									"Php 100.00",
									"Php ".	number_format($value->emp_proll_hdmf + 100,2),
									""
				
									];
		}

		echo json_encode($data);
	}
	public function sss_json(){
		$this->load->model('sss');		
		$sss = new Sss;

		$sss = $sss->get();
		$dta = array();

		foreach ($sss as $key => $value) {
			$totalContribution = $value->sss_ee_cont + $value->sss_er_cont;
			$dta['data'][] = array(	"<span class='sss_range_from' data-pk='{$value->sss_id}' data-name='sss_range_from' >".number_format($value->sss_range_from,2)."</span> - <span class='sss_range_to' data-pk='{$value->sss_id}' data-name='sss_range_to' >".number_format($value->sss_range_to,2)."</span>",
									"<span class='sss_er_cont' data-pk='{$value->sss_id}' data-name='sss_er_cont' >".number_format($value->sss_er_cont,2)."</span>",
									"<span class='sss_ee_cont' data-pk='{$value->sss_id}' data-name='sss_ee_cont' >".number_format($value->sss_ee_cont,2)."</span>",
									number_format($totalContribution,2),
									"<a href='#'><i class='fa fa-minus text-red remove-row-btn'  sss-id='{$value->sss_id}'></i></a> ");
		}
		$dta['data'][] = array("<input type='number' pattern='' class='col-sm-5' range-from>
									<center class='col-sm-2 fa fa-minus centered' style='line-height:25px'></center>
								<input type='number' class='col-sm-5' range-to>",
								"<input type='number' er-cont>",
								"<input type='number' ee-cont>",
								"<span total-cont></span>",
								"<a href='#' onclick='add_sss(this)'><i class='fa fa-plus'></i></a>"
								);

		echo json_encode($dta);
	}
	public function add_sss(){
		$this->load->model('sss');
		$sss = new Sss;

		$sss->sss_ee_cont = $this->input->post('sss_ee_cont');
		$sss->sss_er_cont = $this->input->post('sss_er_cont');
		$sss->sss_range_from = $this->input->post('sss_range_from');
		$sss->sss_range_to = $this->input->post('sss_range_to');
		$sss->save();
	}
	public function delete_sss(){
		$this->load->model('sss');
		$sss = new Sss;
		$sss->load($this->input->post('sss_id'));
		$sss->delete();
	}
	public function edit_sss(){
		$this->load->model('sss');
		$sss = new Sss;
		$sss->load($this->input->post('pk'));
		$sss->{$this->input->post('name')} = str_replace(',','',$this->input->post('value'));
		$sss->save();
	}
	public function philhealth_json(){
		$this->load->model('philhealth');
		$philhealth = new Philhealth;

		$tbl = $philhealth->get();

		$dta = array('data' => array());
		foreach ($tbl as $key => $value) {
			$dta['data'][] =	array('<span class="phic-salary-range-from" data-pk="'.$value->phic_id.'"data-name="phic_salary_range_from" >'.number_format($value->phic_salary_range_from,2).'</span> - <span class="phic-salary-range-to" data-pk="'.$value->phic_id.'"data-name="phic_salary_range_to">'.number_format($value->phic_salary_range_to,2).'</span>',
									'<span class="phic-ee-share" data-pk="'.$value->phic_id.'"data-name="phic_monthly_premium">'. $value->phic_monthly_premium .'</span>',
									// '<span class="phic-er-share" data-pk="'.$value->phic_id.'"data-name="phic_er_share">'.number_format($value->phic_er_share,2).'</span>',
									lte_load_view('button_groups',array('buttons' => array('<span class="fa fa-trash"></span>' => array('link' => array('Delete' => array('link'=>'#','attr' => "onclick='deletePhilhealth(this)' phic_id = '{$value->phic_id}'"),
																																					'Cancel' => array('link'=>'#','attr' => "")),
																																		'attr' => "type='button' class='btn btn-danger dropdown-toggle'"))
																		)
												)
									);		
		}
		$dta['data'][] = array(
							'<input type="number" skip="any" name="phic_salary_range_from" class="col-sm-5"> <center class="col-sm-2"><i class="fa fa-minus"></i></center> <input type="number" name="phic_salary_range_to" class="col-sm-5">',
							'<input type="text"  name="phic_monthly_premium" >',
							// '<input type="number" skip="any" name="phic_ee_share" >',
							// '<input type="number" skip="any" name="phic_er_share">',
							'<a href="#" onclick="addPhilHealth(this)"><i class="fa fa-plus"></i></a>'
							);

		echo json_encode($dta);
	}
	public function add_philhealth()
	{
		$this->load->model('philhealth');
		$phic = new Philhealth;

		$phic->phic_salary_range_from = $this->input->post('phic_salary_range_from');
		$phic->phic_salary_range_to = $this->input->post('phic_salary_range_to');
		$phic->phic_monthly_premium = $this->input->post('phic_monthly_premium');

		$phic->save();
	}
	public function delete_phic()
	{
		$this->load->model('philhealth');
		$phic = new Philhealth;
		$phic->load($this->input->post('phic_id'));
		$phic->delete();
	}
	public function edit_phic()
	{
		$this->load->model('philhealth');
		$sss = new Philhealth;
		$sss->load($this->input->post('pk'));
		$sss->{$this->input->post('name')} = str_replace(',', '', $this->input->post('value'));
		$sss->save();
	}
	public function pagibig_json()
	{
		$this->load->model('pagibig');
		$this->load->model('employee');
		$this->load->model('company_setting');

		$compSettting = new Company_setting;
		$eeShare = $compSettting->pop(array('comp_setting_name' => "pagibig_ee_share"));

		$employee = new Employee;
		$allEmps = $employee->get();

		$data = array('data' => array());
		foreach ($allEmps as $key => $value) {
			$pagibigCont = new Pagibig;
			$empCont = $pagibigCont->pop(array('employee_id' => $value->employee_id));
			$empShare = $empCont->pagibig_share != "" ? $empCont->pagibig_share : $eeShare->comp_setting_val;

			$data['data'][] = array($value->fullName(),
									"<span class='ee-share' data-pk='{$value->employee_id}'>".number_format($empShare,2)."</span>");
		}

		echo json_encode($data);
	}
	public function edit_phic_contrib()
	{
		$this->load->model('pagibig');
		$pagibig = new Pagibig;
		$empContrib = $pagibig->pop(array('employee_id' => $this->input->post('pk')));
		$newContrib = floatval(str_replace(',','',$this->input->post('value')));

		$empContrib->employee_id = $this->input->post('pk');
		$empContrib->pagibig_share = $newContrib;

		$empContrib->save();
	}
	public function wtax()
	{
		$this->load->model('wtax');
		$tax = new Wtax;

		$dailyBracket = $tax->search(array('wtax_bracket_term' => 'daily'));
		$weeklyBracket = $tax->search(array('wtax_bracket_term' => 'weekly'));
		$semiMonthlyBracket = $tax->search(array('wtax_bracket_term' => 'semi-monthly'));
		$monthlyBracket = $tax->search(array('wtax_bracket_term' => 'monthly'));

		$data = ['dailyBracket' => $dailyBracket];
		$data['weeklyBracket'] = $weeklyBracket;
		$data['monthlyBracket'] = $monthlyBracket;
		$data['semiMonthlyBracket'] = $semiMonthlyBracket;

		$table = $this->load->view('admin/deduction_tables/wtax/main_page',$data,true);

		$contentVars = array('contentHeader' => "Withholding Tax",
							'content' => array($table));

		$this->create_head_and_navi([asset_url('plugins/tautocomplete/tautocomplete.js')],
									[asset_url('plugins/tautocomplete/tautocomplete.css')]);
		create_content($contentVars);
		$this->create_footer();
	}
	public function wtax_contrib_json()
	{
		$this->load->model('emp_payroll_rec');

		$epr = new Emp_payroll_rec;
		$epr->toJoin = ['payroll_record' => 'emp_payroll_rec',
						'employment' => 'emp_payroll_rec',
						'employee' => 'employment'];
		$eprs = $epr->get();

		$data = ['data' => []];

		foreach ($eprs as $key => $value) {
			$data['data'][] = [$value->pr_date,
							  $value->fullName('l f, m.'),
							  "Php ".$value->emp_proll_wtax];
		}

		echo json_encode($data);
	}
	public function edit_tax()
	{
		$this->load->model('wtax');
		$wtax = new Wtax;
		$wtax->load($this->input->post('pk'));
		$wtax->{$this->input->post('name')} = $this->input->post('value');
		$wtax->save();
	}

	function emp_json(){
		echo $this->basic_emp_json();
	}

}
/* End of file deduction_tables.php */
/* Location: ./application/controllers/admin/deduction_tables.php */
<?php 
	echo lte_load_view('datatable',[
									'tableId' 		=> 'contrib-tbl',
									'tblVarName' 	=> 'contrib_tbl', 
									'tableHeaders'  => ['Payroll Date', 
														'Employee Name', 
														'Monthly Premium',
														'Employee Contribution',
														'Employer Contribution',
														'Total'],
									'tableRows' 	=> [],
									'tableOptions' 	=> [
														'ajax' => ['url' => base_url('index.php/admin/deduction_tables/phic_contrib_json')],
														'buttons' => ['print','excel','pdf']
														],
									'totalFooter'  	=> [3 => 'Php',
														4 => 'Php',
														5 => 'Php',
													   ]
									]);
<?php 
		echo lte_load_view('datatable', [
										'tableId' 	 	=> 'contrib-rec-tbl',
										'tblVarName' 	=> 'contrib_rec_tbl', 
										'tableHeaders' 	=> ['Payroll Date', 'Employee Name','Employer Contribution', 'Employee Contribution', 'Total'],
										'tableRows' 	=> [],
										'tableOptions'  => ['ajax' => ['url' => base_url('index.php/admin/deduction_tables/sss_contrib_rec_json')],
															'buttons' => [
																			['extend' => 'print', 'text' => '<span class="fa fa-print"></span> Print'],
																			['extend' => 'excel', 'text' => '<span class="fa fa-file-excel-o"></span> Excel'],
																			['extend' => 'pdf', 'text' => '<span class="fa fa-file-pdf-o"></span> PDF']
																			]
															],
										'totalFooter' 	=> [2 => 'Php',
															3 => 'Php',
															4 => 'Php']
										]);
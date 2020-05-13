<?php 

	echo lte_load_view('datatable',[
									'tableId' 		=> 'wtax-contrib-tbl', 
									'tblVarName' 	=> 'wtax_contrib_tbl', 
									'tableHeaders' 	=> ['Payroll Date', 'Employee', 'Contribution'],
									'tableRows' 	=> [],
									'tableOptions'  => [
														'ajax' => ['url' => base_url('index.php/admin/deduction_tables/wtax_contrib_json')], 
														'buttons' => ['print','excel']
														],
									'totalFooter' 	=> [2 => 'Php']
									]);
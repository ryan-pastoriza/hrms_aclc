<?php 
	
	$tbl_url = $this->uri->segment(1) == "admin" ? base_url('index.php/admin/payroll/payroll_rec_json') : base_url('index.php/employee/payroll/payroll_rec_json');

	echo lte_load_view('datatable', [
									'selectionEnabled' 	=> 	false,
									'tableId' 			=> 'payroll-record-tbl',
									'tblVarName' 		=> 'precTbl', 
									'tableHeaders' 		=> ['Payroll Date', 'Cut-off','Employee','OT','Late','Absences','WTAX','SSS','PHILHEALTH','HDMF'],
									'tableRows'			=> [],
									'tableOptions'  	=> ['ajax' => ['url' => $tbl_url],	
															'buttons' => ['print'] ],
									'totalFooter'		=> [3 => "Php",
															4 => "Php",
															5 => "Php",
															6 => "Php",
															7 => "Php",
															8 => "Php",
															9 => "Php"]
									]);

<?php 
	$body = "";
	$header = "";
	if($this->userInfo->user_privilege == "admin"){
	$header = "Search Employee Bracket";
	$body = lte_load_view('form_group',[
										'formInputs' => [
															'Find Employee ' => [
																				'attribs' => [
																								'name' => 'employee_id',
																								'id' => 'employee-selector',
																							]
																				]
														]
										]
						);
	

	$body .= lte_table(['tableHeaders' => ['Term','Employee Bracket','Taxable Amount','%Over'],
						'tableRows' => [
										['Daily','0.00','0.00','0'],
										['Weekly','0.00','0.00','0'],
										['Semi-Monthly','0.00','0.00','0'],
										['Monthly','0.00','0.00','0'],
									],
						'tableOptions' => ['paginate' => false,
											'paging' => false,
											'searching' => false,
											'info' => false,
											'bSort' => false
											],
						'tableId' => 'emp-bracket-tbl',
						'tblVarName' => 'bracketTbl']);
	}elseif($this->userInfo->user_privilege == "employee"){
		$header = "Tax";
		$body = lte_table(['tableHeaders' => ['Term','Employee Bracket','Taxable Amount','%Over'],
						'tableRows' => [
										['Daily','0.00','0.00','0'],
										['Weekly','0.00','0.00','0'],
										['Semi-Monthly','0.00','0.00','0'],
										['Monthly','0.00','0.00','0'],
									],
						'tableOptions' => ['paginate' => false,
											'paging' => false,
											'searching' => false,
											'info' => false,
											'bSort' => false,
											'ajax'	=> base_url("index.php/employee/deduction_tables/calculate_wtax_bracket")
											],
						'tableId' => 'emp-bracket-tbl',
						'tblVarName' => 'bracketTbl']);
	}
	if ($this->uri->segment(1) == "admin") {
		$form = lte_widget(5,['header' => "Search Employee Bracket", 
							'body' => $body,
							'bgColor' => 'box-success',
							'col_grid' => col_grid(12,12,4)]);
	}
	else {
		$form = "";
	}

	echo $form;
?>
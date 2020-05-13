

<?php 

	$title = "<table>
				<tr>
					<td style='width:15%;'>ER ID NO</td>
					<td style='width:40%;'>800166483971</td>
				</tr>
				<tr>
					<td>ER NAME</td>
					<td>BUTUAN INFORMATION TECHNOLOGY SERVICES INC.</td>
					<td style='width:15%;'>Contact No. </td>
					<td style='width:30%;'>341-57-19</td>
				</tr>
				<tr>
					<td>ER ADDRESS</td>
					<td>HDS BLDG. JC AQUINO AVENUE BUTUAN CITY</td>
					<td>E-mail Address</td>
					<td> aclc_hr@yahoo.com</td>
				</tr>
				<tr>
					<td><span></span></td>
					<td colspan='3' >
						<hr style='border:1px solid black;'>
					</td>
				</tr>
				<tr>
					<td>PERCOV</td>
					<td id='percov'></td>
				</tr>
			  </table>

			  ";
	
	echo lte_load_view(
					  	'datatable',['tableId' 		=> 'cont-rec-tbl', 
									'tblVarName' 	=> 'cont_rec_tbl', 
									'tableHeaders'  => ['Payroll Date',
														'RTN',
														'TIN',
														'B-Day',
														'GSIS/SSS',
														'MEMBERSHIP OF PROGRAM',
														'LAST NAME',
														'FIRST NAME',
														'NAME EXTENSION',
														'MIDDLE NAME',
														'PERCOV',
														'EE',
														'ER',
														'TOTAL',
														'REMARKS',
													   ], 
									'tableRows' 	=> [],
									'tableOptions'  => ['ajax' => ['url' => base_url('index.php/admin/deduction_tables/pagibig_contribution_json') ],
														'buttons' => [		
																			[
																				'extend' => 'print', 'text' => '<span class="fa fa-print"></span> Print',
																				'title' => $title,
																				
																			],
																			[
																				'extend' => 'excel', 'text' => '<span class="fa fa-file-excel-o"></span> Excel',
																				'title' => $title,
																			],
																			[
																				'extend' => 'pdf', 'text' => '<span class="fa fa-file-pdf-o"></span> PDF',
																				'title' => $title
																			]
																	 ]
														],
									'totalFooter' 	=> [
														11 => 'Php',
														12 => 'Php',
														13 => 'Php'
													   ]
									]

					  );
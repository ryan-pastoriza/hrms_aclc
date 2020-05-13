<?php 
	$tblRows = [];
	
	foreach ($monthlyBracket as $key => $value) {
		$tblRows[] = [$value->wtax_bracket_status,number_format($value->wtax_bracket_base,2), number_format($value->wtax_amount,2) ,$value->wtax_bracket_percent_over];
	}

	$tableVars = array('tableHeaders' => array("Status","Salary Base","Base Tax","% Over"),
						'tableRows' => $tblRows,
						'tableId' => 'wtax-monthly-table',
						'tblVarName' => 'monthlyTbl',
						'tableOptions' => array());

	$tbl = lte_table($tableVars);


	echo lte_widget(5,array('header' => "WTAX Table <i>(Monthly)</i>",
						'body' => $tbl,
						'collapsable' => true,
						'col_grid' => col_grid(12,12,6),
						)
						);
 ?>
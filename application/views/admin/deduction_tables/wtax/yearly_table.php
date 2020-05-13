<?php 
	$tblRows = [];

	$tableVars = array('tableHeaders' => array("Status","Salary Base","Base Tax","% Over"),
						'tableRows' => $tblRows,
						'tableId' => 'wtax-yearly-table',
						'tableOptions' => array());

	$tbl = lte_table($tableVars);


	echo lte_widget(5,array('header' => "WTAX Table <i>(Yearly)</i>",
						'bgColor' => 'box-danger',
						'body' => $tbl,
						'collapsable' => true,
						'col_grid' => col_grid(12,12,6),
						)
						);
 ?>
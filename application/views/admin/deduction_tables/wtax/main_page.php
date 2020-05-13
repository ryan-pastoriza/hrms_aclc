<?php 
	

	$tables = $this->load->view('admin/deduction_tables/wtax/search_bracket',false,true);
	$tables .= $this->load->view('admin/deduction_tables/wtax/daily_table',false,true);
	$tables .= $this->load->view('admin/deduction_tables/wtax/weekly_table',false,true);
	$tables .= $this->load->view('admin/deduction_tables/wtax/semi_monthly_table',false,true);
	$tables .= $this->load->view('admin/deduction_tables/wtax/monthly_table',false,true);


	echo lte_tab([
				'tabs' => ['Tax Table' => $tables,
							'Contribution Record' => $this->load->view('admin/deduction_tables/wtax/wtax_contrib_tbl',[],TRUE)
							],
				'tab_id' => 'wtax-tabs',
				'col_grid' => col_grid(12),
				'bgColor' => "bg-info"
				]);

	$this->load->view('admin/deduction_tables/wtax/jscripts');
<?php 	

	$datatable = $this->load->view('admin/biometric_rejects/table',[], TRUE);
	
	echo lte_widget(5,['help' => true,
					 'body'   => $datatable,
					 'header' => "Biometric Data",
					 'col_grid' => col_grid(8)]);

	// $this->load->view('admin/biometric_rejects/table');
	$this->load->view('admin/biometric_rejects/jscripts');
?>
<?php 
	
	$vars 				= ['helper' => true];
	$vars['header'] 	= 'Generate Sign-up Keycode';
	$vars['body'] 		= $this->load->view('admin/user_accounts/gen_account/emp_selector',[], TRUE);
	$vars['col_grid'] 	= col_grid(12,12,12,10);
	$vars['bgColor'] 	= "box-primary";

	echo lte_widget(4,$vars);

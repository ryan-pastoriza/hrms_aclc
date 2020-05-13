<?php 
	$form = lte_widget(5, ['helper' 	=> true,
							'body' 		=> $this->load->view('admin/Schedule/Department_Schedule/insert_schedule/body', [], TRUE),
							'header' 	=> "Set Schedule",
							'bgColor' 	=> "box-info",
							'collapsable' => true,
							'collapsed' => true,
							'foot' 		=> "<button class='btn btn-sm btn-primary' type='submit'>Set</button> <button type='reset' class='btn btn-sm'>Clear</button> "
						]);

	echo $form;
 ?>
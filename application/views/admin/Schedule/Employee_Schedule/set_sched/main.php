<br>
<?php 
	echo lte_widget(5, ["helper" => true,
						'body' => $this->load->view('admin/Schedule/Employee_Schedule/set_sched/body', [], TRUE),
						'bgColor' => "box-primary",
						"header" => "Set Employee Schedule",
						"foot" => "<div class='pull-right'> <button type='submit' class='btn btn-sm btn-primary'>Set Schedule</button> <button class='btn btn-sm btn-default' type='reset'> Cancel</button> </div>" ]);
 ?>
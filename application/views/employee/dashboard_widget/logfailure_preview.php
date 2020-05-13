<?php

/**
 * @Author: gian
 * @Date:   2016-08-04 10:16:20
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 10:21:20
 */
	$this->load->view("employee/dashboard_widget/logfailure_jscripts");
	$tbl = '<table id="example1" class="table table-responsive table-bordered table-striped">
		            <thead>
                      	<tr>
                        	<th>Date</th>
                        	<th>AM</th>
                        	<th>PM</th>
                        	<th>Reason</th>
                      	</tr>
	                </thead>
                    <tbody></tbody>
	          	</table>';
	echo lte_widget(4,	[
							"header" => "Log Failure Preview",
							"col_grid" => col_grid(12,12,4),
							"bgColor"	=> "box-primary",
							"body" => $tbl
				   		]
				   );
?>
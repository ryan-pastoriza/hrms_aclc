<?php

/**
 * @Author: gian
 * @Date:   2016-08-04 09:49:34
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-11 09:48:32
 */
	$this->load->view("employee/dashboard_widget/calendar_jscripts");
	echo lte_widget(4,
						[
							"header" => "CALENDAR OF EVENTS",
							"col_grid" => col_grid(12,12,8),
							"bgColor"	=> "box-primary",
							"body"	=> '<div id="calendar"></div>'
						]
					);
	
?>

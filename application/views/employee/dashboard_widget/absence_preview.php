<?php
/**
 * @Author: gian
 * @Date:   2016-07-18 09:26:49
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 09:43:57
 */
	
	$this->load->view("employee/dashboard_widget/absence_jscripts");
	echo lte_widget(4,
					[
						"header" => "ABSENCE CHART",
						"col_grid" => col_grid(12,12,4),
						"bgColor"	=> "box-primary",
						"body"	=> '<div class="chart" id="bar-chart" style="height: 300px;"></div>',
					]
				  );




?>

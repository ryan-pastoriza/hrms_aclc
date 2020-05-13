<?php
/**
 * @Author: gian
 * @Date:   2016-08-03 08:48:18
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-03 17:14:36
 */
$tbl = "
			<table class='table'>	
				<thead>
					<th>Employee</th>
					<th>Employee Share</th>
				</thead>
				<tbody>
					<tr>
						<td>{$this->userInfo->fullName('f m. l')}</td>
						<td>{$pagibig}</td>
					<tr>
				</tbody>
			</table>
	   ";
echo lte_widget(4,
					[
						"header" => "PAG-IBIG",
						"col_grid" => col_grid(12,12,4),
						"bgColor"	=> "default",
						"body"	=> $tbl,
					]
				  );
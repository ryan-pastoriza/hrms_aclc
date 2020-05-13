<?php
/**
 * @Author: gian
 * @Date:   2016-08-03 08:21:34
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-03 17:11:09
 */

$tbl = "
			<table class='table'>	
				<thead>
					<th>Range of Compensation</th>
					<th>Employer Share</th>
					<th>Employee Share</th>
				</thead>
				<tbody>
					<tr>
						<td>{$sss['compensation']}</td>
						<td>{$sss['employer']}</td>
						<td>{$sss['employee']}</td>
					<tr>
				</tbody>
			</table>
	   ";
echo lte_widget(4,
					[
						"header" => "SSS",
						"col_grid" => col_grid(12,12,4),
						"bgColor"	=> "box-primary",
						'collapsable' => false,
						"body"	=> $tbl,
					]

				  );

?>

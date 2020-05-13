
<?php
/**
 * @Author: gian
 * @Date:   2016-08-03 08:48:10
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-03 17:11:26
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
						<td>{$philhealth['salary_bracket']}</td>
						<td>{$philhealth['employer']}</td>
						<td>{$philhealth['employee']}</td>
					<tr>
				</tbody>
			</table>
	   ";
echo lte_widget(4,
					[
						"header" => "PHILHEALTH",
						"col_grid" => col_grid(12,12,4),
						"bgColor"	=> "box-primary",
						"body"	=> $tbl,
					]

				  );
<?php

/**
 * @Author: gian
 * @Date:   2016-08-04 09:57:23
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 10:14:04
 */

$this->load->view("employee/dashboard_widget/leave_jscripts");
$tbl = '<table class="table table-bordered table-responsive">
	        		<thead>
	        			<tr>
	        				<th>Credits</th>
	        				<th>Earned</th>
	        				<th>Used</th>
	        				<th>Balance</th>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<tr>
	        				<td>Vacation Leave</td>
	        				<td id="vacEarned"><center>'. $credits["vac_earned"] .'</center></td>
	        				<td id="vacUsed"><center>'. $credits["vac_used"] .'</center></td>
	        				<td id="vacBalance"><center>'. $credits["vac_balance"] .'</center></td>
	        			</tr>
	        			<tr>
	        				<td>Sick Leave</td>
	        				<td id="sickEarned"><center>'. $credits["sick_earned"] .'</center></td>
	        				<td id="sickUsed"><center>'.$credits["sick_used"] .'</center></td>
	        				<td id="sickBalance"><center>'. $credits["sick_balance"] .'</center></td>

	        			</tr>
	        			<tr>
	        				<td>Emergency Leave</td>
	        				<td id="emerEarned"></td>
	        				<td id="emerUsed"></td>
	        				<td id="emerBalance"></td>

	        			</tr>
	        			<tr>
	        				<td>Paternity Leave</td>
	        				<td id="patEarned"></td>
	        				<td id="patUsed"></td>
	        				<td id="patBalance"></td>

	        			</tr>
	        			<tr>
	        				<td>Maternity  Leave</td>
	        				<td id="matEarned"></td>
	        				<td id="matUsed"></td>
	        				<td id="matBalance"></td>

	        			</tr>
	        			<tr>
	        				<td>Solo Parent Leave</td>
	        				<td id="solParEarned"></td>
	        				<td id="solParUsed"></td>
	        				<td id="solParBalance"></td>

	        			</tr>
	        			<tr>
	        				<td>Educational Leave</td>
	        				<td id="educLeaEarned"></td>
	        				<td id="educLeaUsed"></td>
	        				<td id="educLeaBalance"></td>

	        			</tr>
	        		</tbody>
	        	</table>';
echo lte_widget(4,
						[
							"header" => "LEAVE PREVIEW",
							"col_grid" => col_grid(12,12,4),
							"bgColor"	=> "box-primary",
							"body"	=> $tbl
						]
					);
?>
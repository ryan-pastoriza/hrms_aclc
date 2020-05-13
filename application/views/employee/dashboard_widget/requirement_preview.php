<?php
/**
 * @Author: gian
 * @Date:   2016-08-04 11:07:53
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-04 11:20:07
 */
$tbl = '<table class="table table-bordered tabled-responsive">
	        		<thead>
	        			<tr>
	        				<th>Status</th>
	        				<th>Requirements</th>
	        			</tr>
	        		</thead>
	        		<tbody>';
	        				foreach ($requirement as $key => $value) {
	        					$flag = false;
	        					foreach ($has_requirement as $key2 => $value2) {
	        						if($value->er_id == $value2->er_id){
		        						$tbl .= '
		        								<tr>
		        									<td id="table4-checkbox">
		        											<center><input class="styled" type="checkbox" checked disabled></center>
		        									</td>
		        							 ';
		        						$tbl .= '
			        								<td id="table4-checkbox-title" style="text-align:justify;">
			        									'.$value->requirement_name.'
			        								</td>

		        							  	</tr>';
		        						$flag = true;	 
		        						break;
		        					}
	        					}
	        					if(!$flag){
	        						$tbl .= '
	        							<tr>
	        								<td id="table4-checkbox">
        										<center><input class="styled" type="checkbox" disabled></center>
        									</td>';
        							$tbl .= '
		        							<td id="table4-checkbox-title" style="text-align:justify;">
		        								'.$value->requirement_name.'
		        							</td>

	        							</tr>';
	        					}
	        				}
	        		$tbl .= '</tbody>
	        	</table>';
echo lte_widget(4,[
					"header" => "Requirement Preview",
					"col_grid" => col_grid(12,12,4),
					"bgColor"	=> "box-primary",
					"body"	=> $tbl,
				  ]
			    );
?>

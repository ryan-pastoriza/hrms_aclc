<script type="text/javascript">
	$(function(){
		// var aa = $('.req_checkbox:checkbox:checked').length;
		$('.req_checkbox:checkbox:checked').each(function(){
			$('#'+$(this).attr('req-id')).removeClass('hidden');

		})
		$("#print").on('click',function(e){
			$('#printable_erc').print();
			e.preventDefault();
		});
	});
</script>

<style type="text/css">
	@media print{
		#parentDiv{
	      width: 350px !important;
	      border:2px solid black !important;
	    }
	    #tableDiv{
	      margin: 0 auto;
	      width: 300px !important;
	    }
	    /*table1*/
	    #table1{
	     padding-left: 7px;
	     display: block !important;
	     width: 100% !important;
	     margin-top:5px;
	    }
	    #table1-header{
	      border:1px solid black;
	    }
	    #table1-header-span{
	       line-height: 0;
	       margin-left:5px;
	       font-size: 8px;
	       font-weight:bold;
	    }
	    #table1-span{
	      font-size: 7px;
	      line-height: 0;
	      margin-left:5px;
	    }
	    #table1-bitsi{
	      width: 76px;
	      line-height: 0;
	      margin: 0;
	      border:1px solid black;
	      border-left:none;
	    }
	    /*end table1*/
	    /*table2*/  

	    #table2{
	      padding-left: 7px;
	      display: block !important;
	      width: 100% !important;
	    }
	    #table2-header{
	      font-weight: bold;
	      font-size: 13px;
	      border-top:none;
	    }
	    #table2-semiheader{
	      text-align:right;
	      font-size:8px;
	    }

	    /*end table2*/

	    /*table3*/
	    #table3{
	       display: block !important;
	       width: 100% !important;
	    }
	    #table3-lblName{
	      width: 117px;
	      font-size: 8px;
	      font-weight: bold;
	    }
	    #table3-please{
	      font-style: italic;
	      font-size: 12px;
	      border:1px solid black;
	      border-top:none;
	    }
	    #table3-names{
	      width: 227px;
	      font-size: 8px;
	      font-weight: bold;
	    }
	    /*end table3*/

	    /*table4*/
	    #table4{
	      display: block !important;
	      width: 100% !important;
	    }
	    #table4-checkbox{
	      width: 20px;
	      font-size:8px;
	      border:1px solid black;
	    }
	    #table4-checkbox-title{
	      font-size:8px;
	      border:1px solid black;
	      height: 10px;
	    }
	    .req_checkbox{
	    	border:none !important;
	    }
	    .thumbail, .file-custom{
	    	display: none;
	    }
	    /*end table4*/

	    /*table5*/
	      #table5{
	      	display: block !important;
	        width: 100% !important;
	        margin-bottom: 5px;
	      }
	      #table5-submission{
	        font-size: 8px;
	        font-weight: bold;
	        width: 150px;
	        border:1px solid black;
	      }
	      #table5-texts{
	        font-size: 8px;
	        font-weight: bold;
	        width: 194px;
	        border: 1px solid black;
	      }
	    /*end table5*/

	    #table6{
	    	display: none;
	    }
	}
	#table1,#table2,#table3,#table5{
		display: none;
	}

	#parentDiv{
		display: hidden;
		/*border:2px solid black;*/
	}

	#table4-checkbox{
		border:1px solid black;
		padding-left: 3px;
		padding-bottom:5px;
	}
	#table4-checkbox-title{
		border:1px solid black;
		padding-left: 3px;

	}
	#table6{
		margin-top:3px;
	}
</style>
<div class="container-fluid" id="printable_erc">
	<div id="parentDiv">
	  <input type="text" name="empID" value="<?= $this->userInfo->user_privilege == 'employee' ? $this->userInfo->employee_id : $empID; ?>" emp="<?= $this->userInfo->user_privilege == 'employee' ? $this->userInfo->employee_id : $empID; ?>" hidden /> 	
      <div id="tableDiv">
        <table id="table1" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td id="table1-header">
              	  <p id="table1-header-span">Butuan Information Technology Services, Inc.</p>
                  <p id="table1-span">Franchised of ACLC College and AMA computer Learning Center</p>
                  <p id="table1-span">999 J.C. Aquino Avenue, Butuan City</p>
              </td>
              <td id="table1-bitsi"><h2 style="text-align: center">BITSI</h2></td>
            </tr>
          </tbody>
        </table>
        <table id="table2" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td >
              	<div id="table2-header" >EMPLOYMENT REQUIREMENT CHECKLIST</div>
             </td>
            </tr>
            <tr>
              <td>
             	  <div id="table2-semiheader" >BITSI-HRD-ERC</div>
              </td>
            </tr>
          </tbody>
        </table>
        <table id="table3" cellspacing="0">
          <tbody>
            <tr>
              <td id="table3-lblName" style="border:1px solid black;"> NAME</td>
              <?php
              	if($this->userInfo->user_privilege == 'admin'){
              ?>
              		<td id="table3-names" style="border:1px solid black;border-left:none;"> &nbsp;<?= $empFull; ?></td>
              <?php
              	}
              ?>
              <?php
              	if($this->userInfo->user_privilege == 'employee'){
              ?>
              		<td id="table3-names" style="border:1px solid black;border-left:none;"> &nbsp;<?= $this->userInfo->fullname('f m. l'); ?></td>
              <?php
				}
              ?>
            </tr>
            <tr>
              <td id="table3-lblName" style="border:1px solid black;border-top:none;">POSITION</td>
            	<?php
              		if($this->userInfo->user_privilege == 'admin'){
              	?>
              			<td id="table3-names" style="border:1px solid black;border-top:none;border-left:none;"> &nbsp;<?= $position; ?></td>
              	<?php
              		}
              	?>
              	<?php
              		if($this->userInfo->user_privilege == 'employee'){
              	?>
              			<td id="table3-names" style="border:1px solid black;border-top:none;border-left:none;"> &nbsp;<?= $this->userInfo->employment_job_title; ?></td>
				<?php
					}
				?>
            </tr>
            <tr>
              <td id="table3-lblName" style="border:1px solid black;border-top:none;">DEPARTMENT</td>
              <?php
              		if($this->userInfo->user_privilege == 'admin'){
              	?>
              <td id="table3-names" style="border:1px solid black;border-top:none;border-left:none;"> &nbsp;<?= $department; ?></td>
              <?php
              	}
              ?>
             	<?php
              		if($this->userInfo->user_privilege == 'employee'){
          		?>
              	<td id="table3-names" style="border:1px solid black;border-top:none;border-left:none;"> &nbsp;<?= $this->userInfo->department_name; ?></td>
              	<?php
              		}
              	?>
            </tr>
            <tr>
              <td colspan="2" id="table3-please">Please check submitted documents:</td>
              </tr>
          </tbody>
        </table>

        <table id="table4" cellspacing="0">
          <tbody>
            <?php
				foreach($requirements as $key => $value){
					$flag = false;
					foreach ($hasReq as $key1 => $value2) {
						if($value->er_id == $value2->er_id){
								echo '<tr>
										<td id="table4-checkbox">
											<div class="checkbox checkbox-primary">
												<input  class="styled req_checkbox" type="checkbox" name="has_file['.$value->er_id.']" req-id="req-'.$value->er_id.'" checked>
	                        					<label>
											
											';
										
										foreach ($hasFile as $keys => $values) {
											if($values == $value2->employee_id."_".$value2->er_id.".jpg"){
												echo '<a href="" class="thumbnail" title="'.$value->requirement_name.'" style="width:50px;">';
												echo '<img src="'.base_url('file_upload/users/'.$value2->employee_id.'/'.$value2->employee_id."_".$value2->er_id.'.jpg?='.filemtime('file_upload/users/'.$value2->employee_id.'/'.$value2->employee_id."_".$value2->er_id.'.jpg')).'" class="thumbail img-responsive" fldImg="'.$value2->employee_id.'/'.$value2->employee_id."_".$value2->er_id.'.jpg">';
												echo '</a>';
												$flag = true;
												break;
											}
												
										}
										if($this->userInfo->user_privilege == 'admin'){
											echo '	</label></div>	<input id="req-'.$value->er_id.'" type="file" class="file-custom hidden" name="userfile['.$value->er_id.']" accept="image/jpeg,image/jpg">
											  	</td>
												<td id="table4-checkbox-title">
													'.$value->requirement_name.'
												</td>
										 	 </tr>';
										}
										if($this->userInfo->user_privilege == 'employee'){
											echo '<td id="table4-checkbox-title">
													'.$value->requirement_name.'
												</td>
										 	 </tr>';
										}
							$flag = true;
							break;
						}
					}
					if(!$flag){
						echo '<tr>
								<td id="table4-checkbox">
									<div class="checkbox checkbox-primary">
										<input  class="styled req_checkbox" type="checkbox" name="requirement['.$value->er_id.']" req-id="req-'.$value->er_id.'">
                    					<label></label>
									</div>
									<input id="req-'.$value->er_id.'" type="file" class="file-custom hidden" name="userfile['.$value->er_id.']" accept="image/jpeg,image/jpg">
								</td>
								<td id="table4-checkbox-title">
									'.$value->requirement_name.'
								</td>
							 </tr>';
					}

				}

			?>	
          </tbody>
        </table>
        <table id="table5" cellspacing="0">
          <tbody>
            <tr>
              <td id="table5-submission">&nbsp;SUBMISSION DEADLINE</td>
              <td id="table5-texts">&nbsp;</td>
            </tr>
            <tr>
              <td id="table5-submission">&nbsp;RECEIVED BY</td>
              <td id="table5-texts">&nbsp;</td>
            </tr>
            <tr>
              <td id="table5-submission">&nbsp;SIGNATURE</td>
              <td id="table5-texts">&nbsp;</td>
            </tr>
            <tr>
              <td id="table5-submission">&nbsp;DATE RECEIVED</td>
              <td id="table5-texts">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div> 
      <table id="table6" cellspacing="0">
        	<tbody>
        		<tr>
					<td>
					<?php
						if($this->userInfo->user_privilege == 'admin'){
					?>
						<button class="btn btn-flat btn-primary" id="btn-checklist">Submit</button>
					<?php
						}
					?>
						<a href="#" class="btn btn-flat btn-default" id="print"><span class="fa fa-print"></span> Print</a>
					</td>
				</tr>
        	</tbody>
        </table> 	
    </div>
</div>
<!-- <div class="container-fluid" id="printable">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<div id="tableHeader">
						<table>
							<tbody>
								<tr>
									<td id="lblName">
										<b>FULLNAME</b>
									</td>
									<td id="names">
										<span id="fullname"><?= $empFull; ?></span>
										<input type="text" name="empID" value="<?= $empID; ?>" emp="<?= $empID; ?>" hidden/> 
									</td>
								</tr>
								<tr>
									<td id="lblName">
										<b>POSITION</b>
									</td>
									<td id="names">
										<span id="position"><?= $position; ?></span>
									</td>
								</tr>
								<tr>
									
									<td id="lblName">
										<b>DEPARTMENT</b>
									</td>
									<td id="names">
										<span id="department"><?= $department; ?></span>
									</td>
								</tr>
								<tr>
									<td colspan="2" id="req-names">
										<i>Please check submitted documents:</i>
									</td>
								</tr>
								

								<?php
									foreach($requirements as $key => $value){
										$flag = false;
										foreach ($hasReq as $key1 => $value2) {
											if($value->er_id == $value2->er_id){
													echo '<tr>
															<td>
																<div class="checkbox checkbox-primary">
																	<input  class="styled req_checkbox" type="checkbox" name="has_file['.$value->er_id.']" req-id="req-'.$value->er_id.'" checked>
						                        					<label>
																
																';
															
															foreach ($hasFile as $keys => $values) {
																if($values == $value2->employee_id."_".$value2->er_id.".jpg"){
																	echo '<a href="" class="thumbnail" title="'.$value->requirement_name.'" style="width:50px;">';
																	echo '<img src="'.base_url('file_upload/users/'.$value2->employee_id.'/'.$value2->employee_id."_".$value2->er_id.'.jpg?='.filemtime('file_upload/users/'.$value2->employee_id.'/'.$value2->employee_id."_".$value2->er_id.'.jpg')).'" class="thumbail img-responsive" fldImg="'.$value2->employee_id.'/'.$value2->employee_id."_".$value2->er_id.'.jpg">';
																	echo '</a>';
																	$flag = true;
																	break;
																}
																	
															}
													echo '	</label></div>	<input id="req-'.$value->er_id.'" type="file" class="file-custom hidden" name="userfile['.$value->er_id.']" accept="image/jpeg,image/jpg">
														  	</td>
															<td id="req-names">
																'.$value->requirement_name.'
															</td>
													 	 </tr>';
												$flag = true;
												break;
											}
										}
										if(!$flag){
											echo '<tr>
													<td>
														<div class="checkbox checkbox-primary">
															<input  class="styled req_checkbox" type="checkbox" name="requirement['.$value->er_id.']" req-id="req-'.$value->er_id.'">
				                        					<label></label>
														</div>
														<input id="req-'.$value->er_id.'" type="file" class="file-custom hidden" name="userfile['.$value->er_id.']" accept="image/jpeg,image/jpg">
													</td>
													<td id="req-names">
														'.$value->requirement_name.'
													</td>
												 </tr>';
										}

									}

								?>	
								<tr>
									<td id="lblName">
										<b><i>SUBMISSION DEADLINE</i></b>
									</td>
									<td id="names">
										<?= date("Y-m-d") ?>
									</td>
								</tr>
								<tr>
									<td id="lblName">
										<b><i>RECEIVED BY</i></b>
									</td>
									<td id="names">
										Gian Carl Anduyan
									</td>
								</tr>
								<tr>
									<td id="lblName">
										<b><i>DATE RECEIVED</i></b>
									</td>
									<td id="names">
										<?= date("Y-m-d") ?>
									</td>
								</tr>
								<tr>
									<td>
										<button class="btn btn-flat btn-primary" id="btn-checklist">Submit</button>
										<a href="#" class="btn btn-flat btn-default" id="print"><span class="fa fa-print"></span> Print</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Heading</h4>
	</div>
	<div class="modal-body">
		
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal" id="deleteImg">Delete</a>
		<button class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
   </div>
  </div>
</div>
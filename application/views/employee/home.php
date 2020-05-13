<section class="content">
    <div class="row">

		<div class="col-lg-3">
			<div class="box box-primary box-solid">
				<div class="box-header with-border box-primary">
	        		<h3 class="box-title">Update Request</h3>
	        	</div>
	        	<div class="box-body " id="pisView">
					<?= form_open(base_url('index.php/employee/update_request/add_request'), 'id=form'); ?>

		        	<textarea class="update_rqst" name="eur_request_content" id="eur_request_content"></textarea><br>
		        	<input type="file" class="form-control" style="font-size:11px;" id="file_upload" name="eur_request_file">
		        	<button style="font-size:12px;margin-top:5px;" class="btn btn-primary pull-right">Send Request</button>
		        	<br><br> 
		        	<div class="pull-right rqst-callback">
		        		
		        	</div>
		        	</form>
	        	</div>
			</div>
		</div>

	    <div class="col-lg-9">
	        	<div class="nav-tabs-custom">
	        		<ul class="nav nav-tabs">
	        			<li class="active"><a href="#pis_tab" data-toggle="tab">PIS</a></li>
	        			<li ><a href="#employmentApplicationForm" data-toggle="tab">Employment Application Form</a></li>
	        			<li><a href="#staffInfoSheet" data-toggle="tab">Staff Information Sheet</a></li>
	        			<li><a href="#empCheckList" data-toggle="tab">Employment Requirement Checklist</a></li>
	        		</ul>

	        		<div class="tab-content">
	                  	<div class="tab-pane active" id="pis_tab">
					        <div class="box box-info">
					        	<div class="box-header with-border">
					        		<h3 class="box-title">Personnel Information Sheet</h3>
					        	</div>
					        	<div class="box-body" id="pisView">
						        	<?php 
						        		include('new/pis.php');
						        	?>
					        	</div>
					        	<div class="box-footer">
					        		<!-- this is the footer -->
						        	<!-- <div class="btn-group"> -->
							        	<!-- <a href="#" class="btn btn-info" data-toggle="tooltip" id="addNewEmpBTN" title="Save as New Employee"><i class="glyphicon glyphicon-plus"></i></a> -->
							        	<!-- <a href="#" id="updateBTN" class="btn btn-info only-with-data" data-toggle="tooltip" title="Save Updated Information"><i class="glyphicon glyphicon-save"></i></a> -->
							        	<!-- <a class="dynamic"></a> -->
							        	<!-- <a href="#" class="btn btn-info" data-toggle="tooltip" id="clearPisBTN" title="Clear"><i class="fa fa-times"></i></a> -->
						        	<!-- </div> -->
					        	</div>
				        	</div>
				       	</div>
				       	<div class="tab-pane" id="employmentApplicationForm" >
				       		<div class="box box-info">
						      	<div class="box-body">
							   	 	<div class="box-body" id="pisView">
							        	<?php 
						        			include('new/emp_app_form.php');
					        			?>
						        	</div>
						      	</div>
						    </div>
				       	</div>

				       	<div class="tab-pane" id="staffInfoSheet">
				       		<div class="box box-info">
				       			<div class="box-body">
				       				<?php 
					        			include('new/staff_info_sheet.php');
				        			?>
				       			</div>
				       		</div>
				       	</div>
				       	<div class="tab-pane" id="empCheckList">
				       		<div class="box box-info">
				       			<div class="box-body" id="req"> 
				       				<?php
					        			include('new/emp_req_checklist.php');
				        			?>
				       			</div>
				       		</div>
				       	</div>
				    </div>
	        	</div>
	       </div>
	</div> 
</section>    


<style>
	.update_rqst {
		width:100%;
		height:150px;
		box-shadow: 0px 0px 1px 1px #ccc;
	}

	textarea.update_rqst {
		resize:none;
		background: white;
	}
</style>

<?php 
	$this->load->view('employee/jscript');
?>
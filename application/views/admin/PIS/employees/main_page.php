<?php
/**
 * @Author: gian
 * @Date:   2016-04-04 16:43:35
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-05 08:20:12
 */
?>
<section class="content">
    <div class="row">
        <div class="col-md-12 col-lg-4 col-xs-12">
        	<div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Employees</span>
                    <span class="info-box-number"><?= count($activeEmps) ?></span>
                </div><!-- /.info-box-content -->
            </div>
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Inactive Employees</span>
                    <span class="info-box-number"><?= count($inactiveEmps) ?></span>
                </div><!-- /.info-box-content -->
            </div>
            <?php
            	$this->load->view('admin/PIS/employees/employees_table/emp_table');
            ?>
        </div>
	    <div class="col-md-12 col-lg-8 col-xs-12">
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
						        		$this->load->view('admin/PIS/new/pis',$departments);
						        	?>
					        	</div>
					        	<div class="box-footer">
						        	<div class="btn-group">
							        	<a href="#" class="btn btn-info" data-toggle="tooltip" id="addNewEmpBTN" title="Save as New Employee"><i class="glyphicon glyphicon-plus"></i></a>
							        	<a href="#" id="updateBTN" class="btn btn-info only-with-data" data-toggle="tooltip" title="Save Updated Information"><i class="glyphicon glyphicon-save"></i></a>
							        	<a class="dynamic"></a>
							        	<a href="#" class="btn btn-info" data-toggle="tooltip" id="clearPisBTN" title="Clear"><i class="fa fa-times"></i></a>
						        	</div>
					        	</div>
				        	</div>
				       	</div>
				       	<div class="tab-pane" id="employmentApplicationForm" >
				       		<div class="box box-info">
						      	<div class="box-body">
						      		<?php
						      			$this->load->view('admin/PIS/employees/201/emp_app_form/employment_app_form');
						      		?>
						      		<br/>
						      		<button class="btn btn-primary">Print</button>
						      	</div>
						    </div>
				       	</div>

				       	<div class="tab-pane" id="staffInfoSheet">
				       		<div class="box box-info">
				       			<div class="box-body">
				       				<?php
				       					$this->load->view('admin/PIS/employees/201/staff_info_sheet/staff_sheet');
				       				?>
				       			</div>
				       		</div>
				       	</div>
				       	<div class="tab-pane" id="empCheckList">
				       		<div class="box box-info">
				       			<?php echo form_open_multipart('admin/employees/add_emp_req_checklist', array("class"=>"form-horizontal" ,"id"=>"checklistForm")) ?>
					       			<div class="box-body" id="req"> <!-- kang gian ! id="#req"-->
					       			<?php 
					       				$this->load->view('admin/PIS/employees/201/employment_checklist/employment_req_checklist');
					       			 ?>
					       			</div>
								</form>
				       		</div>
				       	</div>
				    </div>
	        	</div>
	       </div>
	</div> 
</section>    

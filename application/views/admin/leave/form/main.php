<style type="text/css">
	.p {
		display: inline-block;
		margin-right: 10%;
	}
	.p2 {
		display: inline-block;
	}
</style> 
<div class="box collapsed-box">
	<div class="box-header with-border">
		<h3 class="box-title">Leave Application Form</h3>
		<div class="box-tools">
			<button class="btn btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
		</div>
	</div>

	<div class="box-body">

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<?php if($this->userInfo->user_privilege == "admin"): ?>
					<?= form_open(base_url('index.php/admin/leave/add'), 'id=form'); ?>
					<?php else: ?>
					<?= form_open(base_url('index.php/employee/leave/leave_request'), 'id=form'); ?>
					<?php endif ?>
						<table class="table table-bordered" id="from_table">
							<tr>
								<th>NAME</th>
								<td>
									<?php if ($this->userInfo->user_privilege == 'admin'){ ?>
									<input type="text" class="form-control" id="searchEmp" style="font-size: 1.2em; width: 100%">
									<?php } ?>
									<?php if ($this->userInfo->user_privilege == 'employee'){ ?>
									<input type="text" class="form-control" id="searchEmp" style="font-size: 1.2em; width: 100%" <?= $this->userInfo->user_privilege == 'employee' ? 'readonly value=" '. $this->userInfo->fullName('f m. l') . '"' : ''?> >
									<?php } ?>

									<input type="hidden" name="emp_id">
								</td>
								<th>DATE FILED</th>
								<td colspan="3"><input type="date" class="form-control" name="date_filed" required></td>
							</tr>
							<tr>
								<th>POSITION</th>
								<td>
									<?php if ($this->userInfo->user_privilege == 'admin'){ ?>
									<input type="text" class="form-control" name="pos" style="border: 0px;" readonly></p>
									<?php } ?>
									<?php if ($this->userInfo->user_privilege == 'employee'){ ?>
									<input type="text" class="form-control" name="pos" style="border: 0px;" readonly <?= $this->userInfo->user_privilege == 'employee' ? 'value= "'. $this->userInfo->employment_job_title . '"' : ''?>></p>
									<?php } ?>
								</td>
								<th>DEPARTMENT</th>
								<td colspan="3">
									<input type="text" class="form-control" name="dept" style="border: 0px;" readonly <?= $this->userInfo->user_privilege == 'employee' ? 'readonly value= "'. $this->userInfo->department_name . '"' : '' ?>></p>
								</td>
							</tr>
							<tr>
								<th colspan="2" class="text-center">LEAVE AVAILMENT</th>
								<th colspan="4" class="text-center">EMPLOYEE'S LEAVE RECORD <em>(HRD use only)</em></th>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Vacation Leave" required> VACATION LEAVE</td>
								<td rowspan="2">
									<div style="display: inline-block; width: 45%;">
										<b>No. of Days:</b>
										<br>
										<br>
										<input type="number" min="0" step="any" class="form-control" name="days" required>
									</div>
									<div style="display: inline-block; width: 45%;">
										<b>No. of Hours:</b>
										<br>
										<br>
										<input type="number" min="0" step="any" class="form-control" name="hours" required>
									</div>
								</td>
								<th>DATE HIRED</th>
								<td colspan="3" id="hired_date"></td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Sick Leave" required> SICK LEAVE</td>
								<th>CREDITS</th>
								<th>EARNED</th>
								<th>USED</th>
								<th>BALANCE</th>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Emergency Leave" required> EMERGENCY LEAVE</td>
								<td rowspan="3">
									<div style="display: inline-block; width: 45%;">
										<b>Date From:</b>
										<br>
										<br>
										<input type="date" class="form-control" name="date_from" required>
									</div>
									<div style="display: inline-block; width: 45%;" class="bootstrap-timepicker">
										<b>Time From:</b>
										<br>
										<br>
										<input type="text" class="form-control timepicker" name="date_from_time" required>
									</div>
								</td>
								<td>Vacation Leave</td>
								<td id="vacLeaveEarned">
									<?php if($this->userInfo->user_privilege == "employee"): ?>
										<?php
											echo $feli['vacation']['earned'];	
										?>
									<?php else: ?>

									<?php endif ?>					
				
								</td>
								<td id="vacLeaveUsed">
									<?php if($this->userInfo->user_privilege == "employee"): ?>
										<?php
											echo $feli['vacation']['used'];	
										?>
									<?php else: ?>

									<?php endif ?>	

								</td>
								<td id="vacLeaveBalance">
									<?php if($this->userInfo->user_privilege == "employee"): ?>
										<?php
											echo $feli['vacation']['earned'] - $feli['vacation']['used'] ;	
										?>
									<?php else: ?>

									<?php endif ?>	
								</td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Paternity Leave" required> PATERNITY LEAVE</td>
								<td>Sick Leave</td>
								<td id="SLEarned">
									<?php if($this->userInfo->user_privilege == "employee"): ?>
										<?php
											echo $feli['sick']['earned'];	
										?>
									<?php else: ?>

									<?php endif ?>	
								</td>
								<td id="SLUsed">
									<?php if($this->userInfo->user_privilege == "employee"): ?>
										<?php
											echo $feli['sick']['used'];	
										?>
									<?php else: ?>

									<?php endif ?>	
								</td>
								<td id="SLBalance">
									<?php if($this->userInfo->user_privilege == "employee"): ?>
										<?php
											echo $feli['sick']['earned'] - $feli['sick']['used'];	
										?>
									<?php else: ?>

									<?php endif ?>	
								</td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Service Incentive Leave" required>SERVICE INCENTIVE LEAVE</td>
								<td>Service Incentive Leave</td>
								<td id="SILEarned"></td>
								<td id="SILUsed"></td>
								<td id="SILBalance"></td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Maternity Leave" required colspan='3'> MATERNITY LEAVE</td>
								<td></td>
								<td> Emergency Leave</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Solo Parent Leave" required> SOLO PARENT LEAVE</td>
								<td rowspan="3">
									<div style="display: inline-block; width: 45%;">
										<b>Date To:</b>
										<br>
										<br> 
										<input type="date" class="form-control" name="date_to" required>
									</div>
									<div style="display: inline-block; width: 45%;" class="bootstrap-timepicker">
										<b>Time To:</b>
										<br>
										<br>
										<input type="text" class="form-control timepicker" name="date_to_time" required>
									</div>
								</td>
								<td>Paternity Leave</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Educational/Professional Leave" required> EDUCATIONAL/PROFESSIONAL LEAVE</td>
								<td>Maternity Leave</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="BIRTHDAY LEAVE" required> BIRTHDAY LEAVE</td>
								<td>Birthday Leave</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr class="menstrual-leave">
								<td><input type="radio" name="availed" value="Menstrual Leave" required>
									<p class="p2">Menstrual Leave (Female Only)</p>
									<p class="p2"><input type="text" class="form-control" name="others"></p>
								</td>
								<td></td>
								<td>Solo Parent Leave</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><input type="radio" name="availed" value="Others" required>
									<p class="p2">OTHERS:</p>
									<p class="p2"><input type="text" class="form-control" name="others"></p>
								</td>
								<td></td>
								<td>Educational Leave</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2" class="text-center">
									<p class="p"><input type="radio" name="pay" value="1" required> WITH PAY</p> 
									<p class="p"><input type="radio" name="pay" value="0" required> WITHOUT PAY</p>
								</td>
								<td id="removeML">Menstrual Leave</td>
								<td id="ml_earned"></td>
								<td id="ml_used"></td>
								<td id="ml_balance"></td>
							</tr>
							<tr>
								<td colspan="2">
									<p class="p2">REASONS/REMARKS: </p>
									<p class="p2"><input type="text" class="form-control" name="remarks"></p>
								</td>
								<td>Others</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					
					
				</div>
			</div>
		</div>
		<div class="rqst-callback pull-right">
				
		</div>
	</div>
	
	<div class="box-footer text-right">
		<?php if($this->userInfo->user_privilege == "admin"): ?>
		<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Add</button>
		<?php else: ?>
		<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Request</button>
		<?php endif ?>
		</form>
	</div>

</div><!--box -->

<?php if($this->userInfo->user_privilege == "admin"): ?>
	<?php $this->load->view("admin/leave/form/jscript"); ?>
<?php else: ?>
	<?php $this->load->view("employee/leave/form_jscript"); ?>
<?php endif ?>

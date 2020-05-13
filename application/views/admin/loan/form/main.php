<style type="text/css">
	#termName {
		display: inline-block;
		margin-left: 10%;
	}
	#check {
		display: inline-block;
		margin-left: 15%;
	}
	#paymentTable {
		width: 100%;
	}
	#paymentTable td{
		padding: 1%;
	}
</style>
<div class="box collapsed-box">
	<div class="box-header with-border">
		<h3 class="box-title">Loan Form <small>Expand to open form</small></h3>
		<div class="box-tools">
			<button class="btn btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
		</div>
	</div>

	<div class="box-body">

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<?php if($this->userInfo->user_privilege == "admin"): ?>
						<?= form_open(base_url('index.php/admin/loan/add'), 'id=form'); ?>
					<?php elseif($this->userInfo->user_privilege == "employee"): ?>
						<?= form_open(base_url('index.php/employee/loan/add'), 'id=form'); ?>
					<?php endif; ?>
						<table class="table table-bordered">
							<tr>
								<td>
									<b>Employee Name</b>
									<br>
									<?php if($this->userInfo->user_privilege == "admin"): ?>
										<input type="text" class="form-control" id="searchEmp" style="font-size: 1.2em; width: 100%">
										<input type="hidden" name="emp_id" >
									<?php elseif($this->userInfo->user_privilege == "employee"): ?>
										<input type="text" class="form-control" value="<?= $this->userInfo->fullName('f m. l') ?>" id="searchEmp" style="font-size: 1.2em; width: 100%" readonly>
										<input type="hidden" name="emp_id" value="<?= $this->userInfo->employee_id; ?>">
									<?php endif; ?>
									
								</td> 
								<td>
									<b>Date Filed</b>
									<input type="date" name="date_filed" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>
									<b>Department</b>
									<br> 
									<?php if($this->userInfo->user_privilege == "admin"): ?>
										<input type="text" name="dept" style="border: 0px;"></p>
									<?php elseif($this->userInfo->user_privilege == "employee"): ?>
										<input type="text" name="dept" value="<?= $this->userInfo->department_name; ?>" style="border: 0px;" readonly></p>	
									<?php endif; ?>
								</td>
								<td>
									<b>Position</b> 
									<br> 
									<?php if($this->userInfo->user_privilege == "admin"): ?>
										<input type="text" name="pos" style="border: 0px;"></p>
									<?php elseif($this->userInfo->user_privilege == "employee"): ?>
										<input type="text" name="pos" value="<?= $this->userInfo->employment_job_title; ?>" style="border: 0px;"></p>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td>
									<b>Loan Type</b>
									<input type="text" class="form-control" name="loan_type" required>
								</td>
								<td rowspan="2">
									<p><b>Terms</b></p>
									<div id="termName">
										<p>Monthly</p>
										<p>Semi-monthly</p>
									</div> 
									<div id="check">
										<p><input type="radio" name="term" value="Monthly" required></p>
										<p><input type="radio" name="term" value="Semi-monthly" required></p>
									</div>

									<br><br>
									<p><b>Amount To Deduct</b></p>
									<input type="number" class="form-control" name="deduct" step="any" required>
								</td>
							</tr>
							<tr>
								<td>
									<b>Amount Loaned</b>
									<input type="number" class="form-control" name="amount" step="any" required>
								</td>
							</tr>
						</table>
					
				</div>
			</div>
		</div>

	</div>
	<div class="box-footer text-right">
		<?php if($this->userInfo->user_privilege == "admin"): ?>
			<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Add</button>
		<?php elseif($this->userInfo->user_privilege == "employee"): ?>
			<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Request</button>
		<?php endif; ?>
	
	</div>
	</form>

</div><!--box -->


<?php $this->load->view("admin/loan/form/jscript"); ?>
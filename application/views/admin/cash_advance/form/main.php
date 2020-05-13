<style type="text/css">
	textarea {
		resize: none;
	}
	#termName {
		display: inline-block;
		margin-left: 10%;
	}
	#check {
		display: inline-block;
		margin-left: 15%;
	}
</style>
<div class="box collapsed-box">
	<div class="box-header with-border">
		<h3 class="box-title">Cash Advance Request Form</h3>
		<div class="box-tools">
			<button class="btn btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
		</div>
	</div>

	<div class="box-body">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<?php if ($this->userInfo->user_privilege == 'admin'): ?>
						<?= form_open(base_url('index.php/admin/cash_advance/add'), 'id=form'); ?>
					<?php else: ?>
						<?= form_open(base_url('index.php/employee/cash_advance/request_form'), 'id=form'); ?>
					<?php endif ?>
						<table class="table table-bordered">
							<tr>
								<td>
									<b>Date Filed:</b>
									<input type="date" class="form-control" name="date_filed" required >
								</td>
								<td>
									<b>Employee #:</b>
									<br>
									<input type="text" name="emp_id" readonly style="border: 0px;"  <?= $this->userInfo->user_privilege == 'employee' ? 'readonly value=" '. $this->userInfo->employee_id . '" ' : ''?>></p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<b>Name</b>
									<br>
									<input type="text" class="form-control" id="searchEmp" style="font-size: 1.2em; width: 100%;" <?= $this->userInfo->user_privilege == 'employee' ? 'readonly value=" '. $this->userInfo->fullName('f m. l') . '"' : ''?>>
								</td>
							</tr>
							<tr>
								<td>
									<b>Position</b>
									<br> 
									<input type="text" name="pos" style="border: 0px;"  <?= $this->userInfo->user_privilege == 'employee' ? 'readonly value= "'. $this->userInfo->employment_job_title . '"' : ''?> ></p>
								</td>
								<td>
									<b>Department</b>
									<br> 
									<input type="text" name="dept" style="border: 0px;"  <?= $this->userInfo->user_privilege == 'employee' ? 'readonly value=" '. $this->userInfo->department_name . '"' : ''?>></p>
								</td>
							</tr>
							<tr>
								<td>
									<b>Requested Amount(Php)</b>
									<input type="number" step="any" min="0" class="form-control" id="reqAmount" name="req_amount" required>
								</td>
								<td>
									<b>Amount in words</b>
									<br> 
									<input type="text" name="in_words" style="pointer-events:none;border: 0px; width:100%"></p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<b>Purpose of Cash Advance:</b>
									<textarea rows="4" class="form-control" name="purpose" required></textarea>
								</td>
							</tr>
							<tr>
								<td>
									<p><b>Repayment Schedule</b></p>
									<p>Payroll Deduction:</p>
									<p>Terms</p>
									<div id="termName">
										<p>Monthly</p>
										<p>Semi-monthly</p>
									</div> 
									<div id="check">

										<?php if ($this->userInfo->user_privilege == 'employee'): ?>
											<p><input type="radio" name="term" value="Monthly" </p>
											<p><input type="radio" name="term" value="Semi-monthly"></p>
										<?php else: ?>
											<p><input type="radio" name="term" value="Monthly" required></p>
											<p><input type="radio" name="term" value="Semi-monthly" required></p>
										<?php endif ?>

									</div>
								
								</td>
								<td>
									<p>Repayment Starts on:</p>
									<input type="date" name="emp_ca_deduct_start" required="">
									<br>
									<p>Amount:</p>
									<input type="number" step="any" min="0" name="amount" class="form-control" id="amount" required  oninvalid="setCustomValidity('Must not be greater than requested amount.')" onchange="try{setCustomValidity('')}catch(e){}">
								</td>
							</tr>
						</table>
	
				</div>
			</div>
		</div>
	<div class="pull-right rqst-callback"></div>
	</div>
	
	
	<div class="box-footer text-right">
	
		<?php if ($this->userInfo->user_privilege == 'employee'): ?>
			<button type="reset" class="btn btn-secondary">Reset Form</button>
			<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Request</button>
		<?php else: ?>
			<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Add</button>
		<?php endif ?>
		</form>
	</div>
</div><!--box -->


<?php	
	if($this->userInfo->user_privilege=='employee'){
		$this->load->view('employee/loans_and_advances/ca_form_js');			
	}else {
		$this->load->view("admin/cash_advance/form/jscript");
	}

?>
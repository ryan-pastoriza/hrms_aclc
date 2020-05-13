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
		<h3 class="box-title">Other Deductions Form <small>Expand to open form</small></h3>
		<div class="box-tools">
			<button class="btn btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
		</div>
	</div>

	<div class="box-body">

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<?= form_open(base_url('index.php/admin/deduction/add'), 'id=form'); ?>
						<table class="table table-bordered">
							<tr>
								<td colspan="2">
									<b>Deduction Name</b>
									<input type="text" class="form-control" name="ded_name" required>
								</td>
								<td>
									<b>Date Filed</b>
									<input type="date" class="form-control" name="ded_date" required>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<b>Deduction Description</b>
									<input type="text" class="form-control" name="ded_desc">
								</td>
								<td>
									<b>Deduction Start</b>
									<input type="date" class="form-control" name="ded_start" required>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<p><b>Terms</b></p>
									<div id="termName">
										<p>Monthly</p>
										<p>Semi-monthly</p>
									</div> 
									<div id="check">
										<p><input type="radio" name="term" value="Monthly" required></p>
										<p><input type="radio" name="term" value="Semi-monthly" required></p>
									</div>
								</td>
								<td>
									<b>Duration (Months)</b>
									<br>
									<br>
									<input type="number" class="form-control" name="ded_duration" min="1" required>
								</td>
							</tr>
							<tr>
								<th>Employee Name</th>
								<th>Amount to deduct</th>
								<th>Deduction per term</th>
							</tr>
							<tbody id="table-body">
								<tr id="tr-form">
									<td> 
										<input type="text" class="form-control" id="searchEmp" style="font-size: 1.2em; width: 100%">
									</td>
									<td>
										<input type="number" class="form-control" min="0" name="amt_total" step="any">
									</td>
									<td>
										<input type="number" class="form-control" min="0" name="ded_amt" step="any">
									</td>
									<td>
										<a onclick="add_row()"><i class="fa fa-plus"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					
				</div>
			</div>
		</div>

	</div>
	<div class="box-footer text-right">
		<button class="btn btn-primary" id="btn_add"><span class="fa fa-plus"></span> Add</button>
		</form>
	</div>

</div><!--box -->

<?php $this->load->view("admin/other_deduction/form/jscript"); ?>
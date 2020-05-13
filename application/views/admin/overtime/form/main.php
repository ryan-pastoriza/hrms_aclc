<div class="box collapsed-box">
	<div class="box-header with-border">
		<h3 class="box-title">Overtime Authorization Form <small>Expand to open form</small></h3>
		<div class="box-tools">
			<button class="btn btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
		</div>
	</div>

	<div class="box-body">

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">

					<?= form_open(base_url('index.php/admin/overtime/add'), 'id=form'); ?>
						<table class="table table-bordered">
							<tr>
								<th>Date Filed </th>
								<td colspan="8">
									<input type="date" class="form-control" name="dateFiled" id="dateFiled" required>
								</td>
							</tr>
							<tr>
								<th rowspan="2">Employee Name</th>
								<th rowspan="2">Date</th>
								<th colspan="2" class="text-center">Time</th>
								<th rowspan="2">Total # Of Hrs.</th>
								<th colspan="2" class="text-center">Work Shift</th>
								<th rowspan="2">Purpose/Reason</th>
								<th rowspan="2">Actual Hrs. Worked</th>
							</tr>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>From</th>		
								<th>To</th>				
							</tr>
							<tbody id="table-body">
								<tr id="tr-form">
									<td> 
										<input type="text" class="form-control" id="searchEmp" style="font-size: 1.2em; width: 100%">
									</td>
									<td>
										<input type="date" class="form-control" id="date">
									</td>
									<td>
										<div class="bootstrap-timepicker">
						                    <input type="text" class="form-control timepicker" id="from-time" />
						                </div>
									</td>
									<td>
										<div class="bootstrap-timepicker">
					                   		<input type="text" class="form-control timepicker" id="to-time" />
					                    </div>
									</td>
									<td>
										<div class="bootstrap-timepicker">
											<input type="text" class="form-control" id="total-hours" readonly>
										</div>
									</td>
									<td>
										<div class="bootstrap-timepicker">				                    
											<input type="text" class="form-control timepicker" id="from-work-shift" />
										</div>
									</td>
									<td>
										<div class="bootstrap-timepicker">
					                    	<input type="text" class="form-control timepicker" id="to-work-shift" />
					                	</div>
									</td>
									<td>
										<input type="text" class="form-control" id="purpose">
									</td>
									<td>
										<input type="number" class="form-control" min="0" id="actualHours">
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

<?php $this->load->view("admin/overtime/form/jscript"); ?>
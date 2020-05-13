<div class="box">
	<div class="box-header with-border">	
		<span class="box-title">
			Overtime List
		</span>
		<button class="btn btn-default pull-right" id="daterange-btn">
			<i class="fa fa-calendar"></i> <span></span>
			<i class="fa fa-caret-down"></i>
		</button>
		<input type="hidden" id="start">
		<input type="hidden" id="end">
		<input type="hidden" id="date-span-selected">
	</div>
	<div class="box-body">

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">

						<table id="table" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th rowspan="2">Employee Name</th>
									<th rowspan="2">Date Filed</th>
									<th rowspan="2">Overtime Date</th>
									<th colspan="2" class="text-center">Time</th>
									<th rowspan="2">Total # Of Hrs.</th>
									<th colspan="2" class="text-center">Work Shift</th>
									<th rowspan="2">Purpose/Reason</th>
									<th rowspan="2">Actual Hrs. Worked</th>
									<th rowspan="2">Action</th>
								</tr>
								<tr>
									<th>From</th>
									<th>To</th>
									<th>From</th>
									<th>To</th>
								</tr>
					        </thead>
					        <tbody></tbody>
						</table>

				</div>
			</div>
		</div>

	</div>
</div>

<?php $this->load->view("admin/overtime/list/jscript"); ?>
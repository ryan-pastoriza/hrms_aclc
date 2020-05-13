<div class="box">
	<div class="box-header with-border">	
		<span class="box-title">
			Leave List
		</span>
	</div>
	<div class="box-body">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12 table-responsive">

					<div id="print_btns"></div>
					<button class="btn btn-default pull-right" id="daterange-btn">
						<i class="fa fa-calendar"></i> <span></span>
						<i class="fa fa-caret-down"></i>
					</button>
					<input type="hidden" id="start">
					<input type="hidden" id="end">
					<input type="hidden" id="date-span-selected">

					<br>
					<hr>
					
					
					<table id="table" class="table table-bordered table-hover">
						<thead>
							<?php if($this->userInfo->user_privilege == "admin"): ?>
								<tr>
									<th rowspan="2">Employee Name</th>
									<th rowspan="2">Date Filed</th>
									<th rowspan="2">Leave Availed</th>
									<th colspan="2" class="text-center">Date</th>
									<!-- <th colspan="2" class="text-center">Time</th> -->
									<th rowspan="2">No. of Days</th>
									<th rowspan="2">No. of Hours</th>
									<th rowspan="2">Pay</th>
									<th rowspan="2">Reasons/Remarks</th>
									<th rowspan="2">Status</th>
									<th rowspan="2">Action</th>
								</tr>
								<tr>
									<th>From</th>
									<th>To</th>
									<!-- <th>From</th>
									<th>To</th> -->
								</tr>
							<?php else:?>
								<tr>
									<th rowspan="2">Reasons/Remarks</th>
									<th rowspan="2">Date Filed</th>
									<th rowspan="2">Leave Availed</th>
									<th colspan="2" class="text-center">Date</th>
									<th rowspan="2">No. of Days</th>
									<th rowspan="2">No. of Hours</th>
									<th rowspan="2">Pay</th>
									<th rowspan="2">Status</th>
								</tr>
								<tr>
									<th>From</th>
									<th>To</th>
									<!-- <th>From</th>
									<th>To</th> -->
								</tr>
							<?php endif ?>
				        </thead>
				        <tbody></tbody>
					</table>

				</div>
			</div>
		</div>

	</div>
</div>

<?php if($this->userInfo->user_privilege == "admin"): ?>
<?php $this->load->view("admin/leave/list/jscript"); ?>
<?php else:?>
<?php $this->load->view("employee/leave/list_jscript"); ?>
<?php endif ?>
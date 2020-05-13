<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12">

			<button class="btn btn-default pull-right" id="daterange-btn">
				<i class="fa fa-calendar"></i> <span></span>
				<i class="fa fa-caret-down"></i>
			</button>
			<input type="hidden" id="start">
			<input type="hidden" id="end">
			<input type="hidden" id="date-span-selected">

			<br>
			<br>

			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Employee Name</th>
						<th>Date Filed</th>
						<th>Deduction Name</th>
						<th>Amount to Deduct</th>
						<th>Term</th>
						<th>Duration(Months)</th>
						<th>Deduction per Term</th>
						<th>Balance</th>
						<th>Action</th>
					</tr>
		        </thead>
		        <tbody></tbody>
			</table>

		</div>
	</div>
</div>

<?php $this->load->view("admin/other_deduction/list/jscript"); ?>
<?php $this->load->view("admin/other_deduction/list/modal"); ?>
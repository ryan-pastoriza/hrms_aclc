<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12">

			<button class="btn btn-default pull-right" id="daterange-btn-record">
				<i class="fa fa-calendar"></i> <span></span>
				<i class="fa fa-caret-down"></i>
			</button>
			
			<br>
			<br>

			<table id="table_record" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Employee Name</th>
						<th>Payment Date</th>
						<th>Purpose</th>
						<th>Requested Amount</th>
						<th>Payment Amount</th>
					</tr>
		        </thead>
		        <tbody></tbody>
			</table>

		</div>
	</div>
</div>

<?php $this->load->view("admin/cash_advance/record/jscript"); ?>
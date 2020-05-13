<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12 table-responsive">

			<button class="btn btn-default pull-right" id="daterange-btn">
			
				<i class="fa fa-calendar"></i> <span></span>
				<i class="fa fa-caret-down"></i>

			</button>

			<input type="hidden" id="start">
			<input type="hidden" id="end">
			<input type="hidden" id="date-span-selected">

			<br>
			<br>
			
			<table id="table" class="table table-bordered table-hover ">
				<thead>
					<tr>
						<th>Employee Name</th>
						<th>Date Filed</th>
						<th>Loan Type</th>
						<th>Amount Loaned</th>
						<th>Terms</th>
						<th>Deduction</th>
						<th>Balance</th>
						<?php if($this->userInfo->user_privilege == "admin"): ?>
						<th>Status</th>	
						<th>Action</th>
						<?php elseif($this->userInfo->user_privilege == "employee"): ?>
							<th>Status</th>
						<?php endif; ?>
					</tr>
		        </thead>
		        <tbody></tbody>
			</table>
		
		</div>
	</div>
</div>

<?php $this->load->view("admin/loan/list/modal"); ?>
<?php $this->load->view("admin/loan/list/jscript"); ?>
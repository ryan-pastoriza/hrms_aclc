
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Date Filed</th>
						<th>Requested Amount</th>
						<th>Purpose</th>
						<th>Repayment Term</th>
						<th>Repayment Amount</th>
						<th>Balance</th>
					</tr>
		        </thead>
		        <tbody>
		        	<?php
		        		foreach ($ca_history as $key => $value) {
		        	?>
		        	<tr>
			        	<td class="text-center"><?= $value->emp_ca_filed ?></td>
			        	<td><?= $value->emp_ca_amount ?></td>
			        	<td><?= $value->emp_ca_purpose ?></td>
			        	<td><?= $value->emp_ca_repayment_term ?></td>
			        	<td><?= $value->emp_ca_repayment_amt ?></td>
			        	<td><?= $value->emp_ca_filed ?></td>
		        	</tr>
		        	<?php
		        		}
		        	?>
		        </tbody>
			</table>
		
		</div>
	</div>
</div>

<?php $this->load->view("employee/loans_and_advances/cash_advance_list/jscript"); ?>


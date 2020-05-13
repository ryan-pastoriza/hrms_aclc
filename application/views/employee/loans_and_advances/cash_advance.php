	

	<div class="container-fluid" style="padding-left:30px;padding-right:30px;">
		<div class="row">
			<?php include('ca_form.php'); ?>
		</div>

		<div class="row">
			<div class="col-lg-12">
		        	<div class="nav-tabs-custom">
		        		<ul class="nav nav-tabs">
		        			<li class="active"><a href="#cash_advance_list" data-toggle="tab">Cash Advance List</a></li>
		        			<li ><a href="#payment_records" data-toggle="tab">Payment Records</a></li>
		        		</ul>

		        		<div class="tab-content">
		                  	<div class="tab-pane active" id="cash_advance_list">
					        	<div class="box-header with-border">
					        		<h3 class="box-title">Cash Advance List</h3>
					        	</div>
					        	<div class="box-body" id="pisView">
									<?php
										include('cash_advance_list/main.php');
									?>
					        	</div>
					       	</div>
					       	<div class="tab-pane" id="payment_records" >
					       		<div class="box-header with-border">
			        				<h3 class="box-title">Payment Records</h3>
					        	</div>
					        	<div class="box-body" id="pisView">
									<?php
										include('cash_advance_record/main.php');
									?>
					        	</div>
					       	</div>
					    </div>
		        	</div>
	       </div>
		</div>

	</div>
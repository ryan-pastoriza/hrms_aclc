<?php $this->load->view("admin/loan/record/jscript"); ?>
<style>
	.ColVis{
		margin-top:34px;
	}
	.DTTT_button_copy{
		display:none !important;
	}
	.DTTT_button_csv{
		display:none !important;
	}
	.DTTT_button_xls{
		display:none !important;
	}
	.DTTT_button_pdf{
		display:none !important;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12 table-responsive">

			<button class="btn btn-default pull-right" id="daterange-btn-record">
				<i class="fa fa-calendar"></i> <span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		<?php echo form_open_multipart('admin/loan/print_form', array('id'=>'genFormSSS' , 'class' => 'form-horizontal', 'data-toggle' => "validator" ,'target' => '_blank','method' => 'POST')); ?>
			<button class="btn btn-default pull-right" style="margin-right:2px;" id="print-btn">
				<i class="fa fa-print"></i> <span></span>Print
			</button>
			<input type="text" id="searchVal" hidden name="search">
			<input type="text" id="monthVal" hidden name="month">
		</form>

			<input type="hidden" id="start">
			<input type="hidden" id="end">
			<input type="hidden" id="date-span-selected">

			<br>
			<br>

			<table id="table_record" class="table table-bordered table-hover">
				<thead>
					<tr id="theader_hide_print">
						<th>Employee Name</th>
						<th>Payment Date</th>
						<th>Loan Type</th>
						<th>Amount Loaned</th>
						<th>Payment Amount</th>
					</tr>
		        </thead>
			</table>
		
		</div>
	</div>
</div>


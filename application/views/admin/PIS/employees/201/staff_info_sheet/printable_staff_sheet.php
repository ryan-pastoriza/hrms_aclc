<head>
	<title>Staff Information Sheet</title>
	<style type="text/css">
		.printable_table {
			width: 100%;
			border-spacing: 20px;
			font-size: 12px;
		}
		.printable_table td{
			border-bottom: 0.5px solid #595959;
			text-align: center;
			font-size: 12px;
		}
		.printable_hide {
			display: none;
		}
		input[type=text], input[type=date], select {
			border: 0px;
			border-bottom: 1px solid #595959;
			font-size: 12px;
		}
		td {
			font-size: 12px;
		}
		select {
			-webkit-appearance: none;
			-moz-appearance: none;
		}
	</style>
</head>

<script src="<?= asset_url('plugins/jQuery/jQuery-1.11.3.min.js') ?>"></script>
<script type="text/javascript">
	$('input').attr('readonly', true);
	$('select').attr('disabled', true).css('color', 'black');
	$(function(){
		window.print();
	})
</script>

<?php $this->load->view('admin/PIS/employees/201/staff_info_sheet/staff_sheet'); ?>
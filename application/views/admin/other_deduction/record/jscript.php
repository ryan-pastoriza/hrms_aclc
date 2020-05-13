<script type="text/javascript">
	var oTable_record;
	var tableOptions_record = {
						aLengthMenu: [
					        [25, 50, 100, 200, -1],
					        [25, 50, 100, 200, "All"]
					    ],
						ajax : "<?= base_url('index.php/admin/deduction/eodp_json') ?>",
						};

	$(function() {

		oTable_record = $('#table_record').dataTable(tableOptions_record);

		$('#daterange-btn-record span').html("All");
		$('#start').val("");
		$('#end').val("");

		$('#daterange-btn-record').daterangepicker({
				ranges: {
					'All' :["", ""],
					'Today': [moment(), moment()],
	                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	                'This Month': [moment().startOf('month'), moment().endOf('month')],
	                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: [],
	          	endDate: []
			},
			function (start, end, label) {
				if(label == "All"){
					$('#daterange-btn-record span').html(label);
				}
				else{
					$('#daterange-btn-record span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				}
				$('#start').val(start.format('YYYY-MM-DD'));
				$('#end').val(end.format('YYYY-MM-DD'));
				$('#date-span-selected').val(label);

				oTable_record.api().draw();
			}
		);

	});

</script>
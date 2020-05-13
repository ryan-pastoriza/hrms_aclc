

<script type="text/javascript">
	
	$(function() {
		// var oTable_record;
		$('#monthVal').val("All");

		$(document).on('keyup','#table_record_filter label .input-sm',function(){
			$('#searchVal').val($(this).val())
		});

		

		var tableOptions = {
		 					dom: 'Blfrtip',
							aLengthMenu: [
									        [25, 50, 100, 200, -1],
									        [25, 50, 100, 200, "All"]
									    ],

							<?php 
								if($this->userInfo->user_privilege == "admin" ): ?>
								ajax : "<?= base_url('index.php/admin/loan/elp_json') ?>",
							<?php elseif($this->userInfo->user_privilege == "employee" ): ?>
								ajax : "<?= base_url('index.php/employee/loan/elp_json') ?>",
							<?php endif; ?>
						}
		
		oTable_record = $('#table_record').dataTable(tableOptions);

		$('#daterange-btn-record span').html("All");
		$('#start').val("");
		$('#end').val("");

		$('#daterange-btn-record').daterangepicker({
				ranges: {
					'All' : ["",""],
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


				var starts = $('#daterange-btn-record span').html();

				$('#monthVal').val(starts);


				$('#start').val(start.format('YYYY-MM-DD'));
				$('#end').val(end.format('YYYY-MM-DD'));
				$('#date-span-selected').val(label);

				oTable_record.api().draw();
			}
		);

	});

</script>
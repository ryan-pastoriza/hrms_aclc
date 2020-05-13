<script type="text/javascript">
	var oTable;
	var tableOptions = {
						dom: "Blfrtip",
						buttons: [
							{extend: 'print', 
							 text: '<span class="fa fa-print"></span> Print',
							 exportOptions: {
				                columns: [0,1,2,3,4,5,6,7,8]
				             }
							},

							{extend: 'excel', 
							 text: '<span class="fa fa-file-excel-o"></span> Excel', 
							 exportOptions: {
				                columns: [0,1,2,3,4,5,6,7,8]
				             }},

							{extend: 'pdf', 
							 text: '<span class="fa fa-file-pdf-o"></span> PDF',
							 exportOptions: {
				                columns: [0,1,2,3,4,5,6,7,8]
				             }}
						],
						aLengthMenu: [
					        [25, 50, 100, 200, -1],
					        [25, 50, 100, 200, "All"]
					    ],
						<?php if($this->userInfo->user_privilege == "admin"): ?>
						ajax : "<?= base_url('index.php/admin/leave/leave_json') ?>",
						<?php else: ?>
						ajax : "<?= base_url('index.php/employee/leave/leave_list') ?>",
						<?php endif ?>
						fnDrawCallback: function(){
											$('.emp-leave-filed').editable({
												type:'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>"},
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-availment').editable({
												type: 'select',
												mode:'inline',
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												source: [
													{value: 'Vaction Leave', text: 'Vacation Leave'},
													{value: 'Sick Leave', text: 'Sick Leave'},
													{value: 'Emergency Leave', text: 'Emergency Leave'},
													{value: 'Paternity Leave', text: 'Paternity Leave'},
													{value: 'Service Incentive Leave', text: 'Service Incentive Leave'},
													{value: 'Birthday Leave', text: 'Birthday Leave'},
													{value: 'Maternity Leave', text: 'Maternity Leave'},
													{value: 'Solo Parent Leave', text: 'Solo Parent Leave'},
													{value: 'Educational/Professional Leave', text: 'Educational/Professional Leave'},
													{value: 'Menstrual Leave', text: 'Menstrual Leave'},
													{value: 'Others', text: 'Others'}
												],
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-from').editable({
												type:'combodate',
												mode:'popup',
												template: "MMM D YYYY - h:mm a",
											    viewformat: "MM/DD/YYYY - h:mm a",
											    format: "YYYY-MM-DD HH:mm",
												combodate: {
													maxYear: "<?= date('Y') ?>", 
													minuteStep: 1
												},
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-to').editable({
												type:'combodate',
												mode:'popup',
												template: "MMM D YYYY - h:mm a",
											    viewformat: "MM/DD/YYYY - h:mm a",
											    format: "YYYY-MM-DD HH:mm",
												combodate: {
													maxYear: "<?= date('Y') ?>", 
													minuteStep: 1
												},
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-days').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-hours').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-with-pay').editable({
												type: 'select',
												mode:'inline',
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												source: [
													{value: 1, text: 'With Pay'},
													{value: 0, text: 'Without Pay'}
												],
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-leave-remark').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/leave/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
										} 
						};
	
    $(function() {

    	oTable = $('#table').dataTable(tableOptions);
    	oTable.api().buttons().container().appendTo('#print_btns');

    	$('#daterange-btn span').html("All");
  		$('#start').val("");
		$('#end').val("");

		$('#daterange-btn').daterangepicker({
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
					$('#daterange-btn span').html(label);
				}
				else{
					$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				}
				$('#start').val(start.format('YYYY-MM-DD'));
				$('#end').val(end.format('YYYY-MM-DD'));
				$('#date-span-selected').val(label);

				oTable.api().draw();
			}
		);

		$.fn.dataTableExt.afnFiltering.push(
		    function( oSettings, aData, iDataIndex ) {
		        var iFini = $('#start').val();
		        var iFfin = $('#end').val();
		        var iStartDateCol = 1;
		        var iEndDateCol = 1;
		        var label = $('#date-span-selected').val();

		        iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
		        iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);
		 
		        var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
		        var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);
		 
		        if(label == "All"){
		        	return true;
		        }
		        else if ( iFini === "" && iFfin === "" )
		        {
		            return true;
		        }
		        else if ( iFini <= datofini && iFfin === "")
		        {
		            return true;
		        }
		        else if ( iFfin >= datoffin && iFini === "")
		        {
		            return true;
		        }
		        else if (iFini <= datofini && iFfin >= datoffin)
		        {
		            return true;
		        }
		        return false;
		    }
		);

    })

	    function delete_leave(id) {
			$.post(
				'<?= base_url("index.php/admin/leave/delete"); ?>',
				{id : id}, 
				function() {
					oTable.api().ajax.reload();
				}
			);
		}

		function approve(id){
			$.post(
					'<?= base_url("index.php/admin/leave/approve") ?>',
					{id : id},
					function(){
						oTable.api().ajax.reload();
						oTable_record.api().ajax.reload();
					}
				);
		}

		function reject(id){
			$.post(
					'<?= base_url("index.php/admin/leave/reject") ?>',
					{id : id},
					function(){
						oTable.api().ajax.reload();
						oTable_record.api().ajax.reload();
					}
				);
		}
		

        
</script>
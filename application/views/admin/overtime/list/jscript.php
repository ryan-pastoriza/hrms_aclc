<script type="text/javascript">
//Data Table
	var oTable;
	var pk;

	var tableOptions = {
						aLengthMenu: [
					        [25, 50, 100, 200, -1],
					        [25, 50, 100, 200, "All"]
					    ],
						ajax : "<?= base_url('index.php/admin/overtime/ot_json') ?>",
						fnDrawCallback: function(){
											$('.emp-ot-date').editable({
												type:'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>"},
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ot-from').editable({
												type:'time',
												mode:'inline',
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
														pk = $(this).data('pk');
														oTable.api().ajax.reload(function() {
															var id1 = "#from" + pk;
															var id2 = "#to" + pk;
															var t1 = $(id1).text();
															var t2 = $(id2).text();
															var output = calculate_hours(t1, t2);
															update_total_hours(pk, output);
														});
												}
											});
											$('.emp-ot-to').editable({
												type:'time',
												mode:'inline',
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
														pk = $(this).data('pk');
														oTable.api().ajax.reload(function() {
															var id1 = "#from" + pk;
															var id2 = "#to" + pk;
															var t1 = $(id1).text();
															var t2 = $(id2).text();
															var output = calculate_hours(t1, t2);
															update_total_hours(pk, output);
														});
												}
											});
											$('.emp-ot-work-shift-in').editable({
												type:'time',
												mode:'inline',
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ot-work-shift-out').editable({
												type:'time',
												mode:'inline',
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ot-purpose').editable({
												type:'text',
												mode:'inline',
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ot-actual-worked').editable({
												type:'text',
												mode:'inline',
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ot-date-filed').editable({
												type:'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>"},
												url: "<?= base_url('index.php/admin/overtime/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});

										} 
						};
	
    $(function(){

    	oTable = $('#table').dataTable(tableOptions);

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
		        var iStartDateCol = 2;
		        var iEndDateCol = 2;
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

    function update_total_hours(pk, value) {
    	$.post('<?= base_url("index.php/admin/overtime/update"); ?>',
			{
				pk: pk,
				value: value,
				name: 'emp_ot_total_hours'
			}, 
			function() {
				oTable.api().ajax.reload();
			}
		);
    }

	function delete_ot(id) {
		$.post('<?= base_url("index.php/admin/overtime/delete"); ?>',
			{
				id : id
			}, 
			function() {
				oTable.api().ajax.reload();
			}
		);
	}

	function calculate_hours(t1, t2) {
		var from = t1.split(':');
		var to = t2.split(':');
		var fromDaytime = t1.split(' ');
		var toDaytime = t2.split(' ');
		var fromHr = parseInt(from[0]);
		var toHr = parseInt(to[0]);
		var fromMin = parseInt(from[1]);
		var toMin = parseInt(to[1]);

		if(fromDaytime[1] === 'PM') {
			if(fromHr != 12) {
				fromHr += 12;
			}
		} else {
			if(fromHr == 12) {
				fromHr += 12;
			}
		}

		if(toDaytime[1] === 'PM') {
			if(toHr != 12) {
				toHr += 12;
			}
		} else {
			if(toHr == 12) {
				toHr += 12;
			}
		}

		var f = (fromHr * 60) + fromMin;
		var t = (toHr * 60) + toMin;
		var totalHrs = (t - f) / 60;
		var output = parseInt(totalHrs);

		if(output <= 0) {
			output = '';
		}
		return output;
	}
	

</script>
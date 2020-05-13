<script type="text/javascript">
	var oTable;
	var pk;

	var tableOptions = {
						aLengthMenu: [
					        [25, 50, 100, 200, -1],
					        [25, 50, 100, 200, "All"]
					    ],
						ajax : "<?= base_url('index.php/admin/deduction/eod_json') ?>",
						fnDrawCallback: function(){
											$('.eod-date-filed').editable({
												type:'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>"},
												url: "<?= base_url('index.php/admin/deduction/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});

											$('.eod-amt-total').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/deduction/update') ?>",
												success: function() {
													pk = $(this).data('pk');
													oTable.api().ajax.reload(function() {
														var amt_total = '#amt_total' + pk;
														var ded_duration = '#ded_duration' + pk;
														var term = '#ded_term' + pk;
														amt_total = $(amt_total).text();
														ded_duration = $(ded_duration).text();
														term = $(term).text();
														var output = deduction_per_term(term, ded_duration, amt_total);
														update_deduction(pk, output);
													});
												}
											});
										} 
						};

	function deduction_per_term(term, duration, amount) {
		amount = amount.replace(/[^0-9.]/g, '');
		var output = '';
		if(term === 'Monthly') {
			output = parseFloat(amount) / parseInt(duration);
		} else {
			output = parseFloat(amount) / (parseInt(duration) * 2);
		}
		if(isNaN(output)) {
			return '';
		}
		return output;
	}

	function update_deduction(pk, value) {
		$.post('<?= base_url("index.php/admin/deduction/update"); ?>',
			{
				pk: pk,
				value: value,
				name: 'eod_term_deduction_amt'
			}, 
			function() {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
			}
		);
	}
	
    $(function() {

    	oTable = $('#table').dataTable(tableOptions);

    	$('#daterange-btn span').html("All");
  		$('#start').val("");
		$('#end').val("");

		$('#daterange-btn').daterangepicker({
				ranges: {
					'All': ["", ""],
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
				if(label === "All") {
					$('#daterange-btn span').html(label);
				} else{
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
		 
		        if(label == "All") {
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

		var payment_form_options = {
			clearForm: true,
			resetForm: true,
			beforeSubmit: function() {
				$('#payment_btn_add').attr('disabled', true);
			},
			success: function() {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
				$('#payment_btn_add').attr('disabled', false);
				$('#payment').modal('hide');
			}
		};

		$('#payment_form').ajaxForm(payment_form_options);

		$('[name=amount_paid]').keypress(function(e){
			if(e.keyCode == 13) {
				e.preventDefault();
			}	
		});

    });

	function paymentModal(id) {
		$.post(
				'<?= base_url("index.php/admin/deduction/get_eod_json") ?>',
				{id: id},
				function(data) {
					var obj = JSON.parse(data);
					var balance = obj.data[0].balance;
					$('[name=eod_id]').val(obj.data[0].eod_id);
					$('#emp_name').text(obj.data[0].fullName);
					$('#date').text(obj.data[0].eod_date_filed);
					$('#deduc_name').text(obj.data[0].other_ded_name);
					$('#amt').text(obj.data[0].eod_amt_total);
					$('#term').text(obj.data[0].other_ded_term);
					$('#duration').text(obj.data[0].other_ded_duration_months);
					$('#deduct').text(obj.data[0].eod_term_deduction_amt);
					$('#balance').text(balance);
					$('[name=amount_paid]').attr('max', balance.replace(/[^0-9.]/g, ''));
				}
			);
	}

    function delete_eod(id) {
		$.post(
			'<?= base_url("index.php/admin/deduction/delete"); ?>',
			{id : id}, 
			function() {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
			}
		);
	}

        
</script>
<script type="text/javascript">
	var oTable;
	var tableOptions = {
						aLengthMenu: [
					        [25, 50, 100, 200, -1],
					        [25, 50, 100, 200, "All"]
					    ],
						ajax : "<?= base_url('index.php/admin/cash_advance/ca_json') ?>",
						fnDrawCallback: function() {
											$('.emp-ca-filed').editable({
												type:'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>"},
												url: "<?= base_url('index.php/admin/cash_advance/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ca-amount').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/cash_advance/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ca-purpose').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/cash_advance/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ca-repayment-term').editable({
												type: 'select',
												mode:'inline',
												url: "<?= base_url('index.php/admin/cash_advance/update') ?>",
												source: [
													{value: 'Monthly', text: 'Monthly'},
													{value: 'Semi-monthly', text: 'Semi-monthly'}
												],
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ca-repayment-amt').editable({
												mode:'inline',
												url: "<?= base_url('index.php/admin/cash_advance/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-ca-repayment-start').editable({
												mode:'popup',
												type:'combodate',
												combodate: {maxYear: "<?= date('Y') ?>"},
												url: "<?= base_url('index.php/admin/cash_advance/update') ?>",
												success: function() {
													oTable.api().ajax.reload();
												}
											});
										} 
						};
	
    $(function() {

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
				'<?= base_url("index.php/admin/cash_advance/get_ca_json") ?>',
				{id: id},
				function(data) {
					var obj = JSON.parse(data);
					var balance = obj.data[0].balance;
					$('[name=emp_ca_id]').val(obj.data[0].emp_ca_id);
					$('#date').text(obj.data[0].emp_ca_filed);
					$('#emp_name').text(obj.data[0].fullName);
					$('#req_amt').text(obj.data[0].emp_ca_amount);
					$('#purpose').text(obj.data[0].emp_ca_purpose);
					$('#term').text(obj.data[0].emp_ca_repayment_term);
					$('#rep_amt').text(obj.data[0].emp_ca_repayment_amt);
					$('#balance').text(balance);
					$('[name=amount_paid]').attr('max', balance.replace(/[^0-9.]/g, ''));
				}
			);
	}

	function delete_ca(id) {
		$.post(
			'<?= base_url("index.php/admin/cash_advance/delete"); ?>',
			{id : id}, 
			function() {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
			}
		);
	}

	// Author: Dale
	
	function approve(id){
		$.post(
				'<?= base_url("index.php/admin/cash_advance/approve") ?>',
				{id : id},
				function(){
					oTable.api().ajax.reload();
					oTable_record.api().ajax.reload();
				}
			);
	}

	function reject(id){
		$.post(
				'<?= base_url("index.php/admin/cash_advance/reject") ?>',
				{id : id},
				function(){
					oTable.api().ajax.reload();
					oTable_record.api().ajax.reload();
				}
			);
	}

        
</script>
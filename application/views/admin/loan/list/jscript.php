<script type="text/javascript">
	var oTable_record
	var oTable;
	var tableOptions = {
						aLengthMenu: [
					        [25, 50, 100, 200, -1],
					        [25, 50, 100, 200, "All"]
					    ],
					    <?php if($this->userInfo->user_privilege == "admin" ): ?>
							ajax : "<?= base_url('index.php/admin/loan/loan_json') ?>",
					    <?php elseif($this->userInfo->user_privilege == "employee" ): ?>
							ajax : "<?= base_url('index.php/employee/loan/loan_json') ?>",
					    <?php endif; ?>

						fnDrawCallback: function() {
											$('.emp-loan-filed').editable({
												type:'combodate',
												mode:'popup',
												combodate: {maxYear: "<?= date('Y') ?>"},
					   							<?php if($this->userInfo->user_privilege == "admin" ): ?>
													url: "<?= base_url('index.php/admin/loan/update') ?>",
												<?php elseif($this->userInfo->user_privilege == "employee" ): ?>
													url: "<?= base_url('index.php/employee/loan/update') ?>",
												<?php endif; ?>
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-loan-type').editable({
												mode:'inline',
				    							<?php if($this->userInfo->user_privilege == "admin" ): ?>
													url: "<?= base_url('index.php/admin/loan/update') ?>",
												<?php elseif($this->userInfo->user_privilege == "employee" ): ?>
													url: "<?= base_url('index.php/employee/loan/update') ?>",
												<?php endif; ?>
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-loan-amt').editable({
												mode:'inline',
				    							<?php if($this->userInfo->user_privilege == "admin" ): ?>
													url: "<?= base_url('index.php/admin/loan/update') ?>",
												<?php elseif($this->userInfo->user_privilege == "employee" ): ?>
													url: "<?= base_url('index.php/employee/loan/update') ?>",
												<?php endif; ?>
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-loan-term').editable({
												type: 'select',
												mode:'inline',
				    							<?php if($this->userInfo->user_privilege == "admin" ): ?>
													url: "<?= base_url('index.php/admin/loan/update') ?>",
												<?php elseif($this->userInfo->user_privilege == "employee" ): ?>
													url: "<?= base_url('index.php/employee/loan/update') ?>",
												<?php endif; ?>
												source: [
													{value: 'Monthly', text: 'Monthly'},
													{value: 'Semi-monthly', text: 'Semi-monthly'}
												],
												success: function() {
													oTable.api().ajax.reload();
												}
											});
											$('.emp-loan-deduct').editable({
												mode:'inline',
				    							<?php if($this->userInfo->user_privilege == "admin" ): ?>
													url: "<?= base_url('index.php/admin/loan/update') ?>",
												<?php elseif($this->userInfo->user_privilege == "employee" ): ?>
													url: "<?= base_url('index.php/employee/loan/update') ?>",
												<?php endif; ?>
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
		
		// var lesser = true;

		// $('#btnAddPayment').click(function() {
		// 	var loan_id = $('[name=loan_id]').val();
		// 	var date_paid = $('[name=date_paid]').val();
		// 	var amount_paid = $('[name=amount_paid]').val();
		// 	var balance = $('#balance').text();

		// 	if(loan_id !== '' && date_paid !== '' && amount_paid !== '' && amount_paid != 0) {
		// 		if(lesser == true) {
		// 			$('#payment_form').submit();
		// 		}
		// 	}
		// });

		// $('[name=amount_paid]').keyup(function(e) {
		// 	var amount_paid = $('[name=amount_paid]').val();
		// 	var balance = $('#balance').text();
		// 	amount_paid = amount_paid.replace(/[^0-9.]/g,'');
		// 	balance = balance.replace(/[^0-9.]/g, '');

		// 	if(parseFloat(balance) < parseFloat(amount_paid)) {
		// 		$('#divAmount').attr('class', 'form-group has-error');
		// 		$('#msg').text("The amount is greater than the balance!");
		// 		lesser = false;
		// 	} else {
		// 		$('#divAmount').attr('class', 'form-group');
		// 		$('#msg').text('');
		// 		lesser = true;
		// 	}
		// });

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

    })

	function paymentModal(id) {
		$.post(
				<?php if($this->userInfo->user_privilege == "admin"): ?>
					'<?= base_url("index.php/admin/loan/get_el_json") ?>',
				<?php elseif($this->userInfo->user_privilege == "employee"): ?>
					'<?= base_url("index.php/employee/loan/get_el_json") ?>',
				<?php endif; ?>

				{id: id},
				function(data) {
					var obj = JSON.parse(data);
					var balance = obj.data[0].balance;
					$('[name=loan_id]').val(obj.data[0].emp_loan_id);
					$('#emp_name').text(obj.data[0].fullName);
					$('#date').text(obj.data[0].emp_loan_filed);
					$('#type').text(obj.data[0].emp_loan_type),
					$('#amt').text(obj.data[0].emp_loan_amt),
					$('#terms').text(obj.data[0].emp_loan_term),
					$('#deduct').text(obj.data[0].emp_loan_deduct),
					$('#balance').text(balance);
					$('[name=amount_paid]').attr('max', balance.replace(/[^0-9.]/g, ''));
				}
			);
	}

	function delete_loan(id) {
		$.post(
			<?php if($this->userInfo->user_privilege == "admin"): ?>
				'<?= base_url("index.php/admin/loan/delete"); ?>',
			<?php elseif($this->userInfo->user_privilege == "employee"): ?>
				'<?= base_url("index.php/employee/loan/delete"); ?>',
			<?php endif; ?>
			{id : id}, 
			function() {
				oTable.api().ajax.reload();
				oTable_record.api().ajax.reload();
			}
		);
	}

	function approve(id){
		$.post(
				'<?= base_url("index.php/admin/loan/approve") ?>',
				{id : id},
				function(){
					oTable.api().ajax.reload();
					oTable_record.api().ajax.reload();
				}
			);
	}

	function reject(id){
		$.post(
				'<?= base_url("index.php/admin/loan/reject") ?>',
				{id : id},
				function(){
					oTable.api().ajax.reload();
					oTable_record.api().ajax.reload();
				}
			);
	}

</script>
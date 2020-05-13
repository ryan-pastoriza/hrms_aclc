
<div class="col-md-12 col-lg-12 col-sm-12">
	<?php $this->load->view("admin/loan/form/main"); ?>
</div> <!--col -->

<?php 
	$loan_list = $this->load->view("admin/loan/list/main",false,TRUE);
	$payment_list = $this->load->view("admin/loan/record/main",false,TRUE); 

	echo lte_tab(
					[
					    'tabs' => 
								[
									'Loans List' => '<div class="col-md-12 col-lg-12 col-sm-12">'. $loan_list.'</div>',
									'Payments Record' => '<div class="col-md-12 col-lg-12 col-sm-12">'. $payment_list.'</div>'
								],
					 	'tab_id' => 'loan-tabs' ]);
?>

	
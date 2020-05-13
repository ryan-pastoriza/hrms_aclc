
<div class="col-md-12 col-lg-12 col-sm-12">
	<?php $this->load->view("admin/other_deduction/form/main"); ?>
</div> <!--col -->

<?php 
	$deduction_list = $this->load->view("admin/other_deduction/list/main",false,TRUE);
	$payment_list = $this->load->view("admin/other_deduction/record/main",false,TRUE); 

	echo lte_tab(['tabs' => ['Other Deductions List' => '<div class="col-md-12 col-lg-12 col-sm-12">'. $deduction_list.'</div>',
							'Payments Record' => '<div class="col-md-12 col-lg-12 col-sm-12">'. $payment_list.'</div>'],
				'tab_id' => 'other-ded-tabs' ]);
 ?>

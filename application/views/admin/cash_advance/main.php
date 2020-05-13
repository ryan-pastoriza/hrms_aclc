
<div class="col-md-12 col-lg-12 col-sm-12">
	<?php $this->load->view("admin/cash_advance/form/main"); ?>
</div> <!--col -->

<?php 
	$ca_list = $this->load->view("admin/cash_advance/list/main",false,TRUE);
	$payment_list = $this->load->view("admin/cash_advance/record/main",false,TRUE); 

	echo lte_tab(['tabs' => ['Cash Advances List' => '<div class="col-md-12 col-lg-12 col-sm-12">'. $ca_list.'</div>',
							'Payments Record' => '<div class="col-md-12 col-lg-12 col-sm-12">'. $payment_list.'</div>'],
				'tab_id' => 'ca-tabs' ]);
 ?>

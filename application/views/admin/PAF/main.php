<?php 
	$paf = $this->load->view("admin/PAF/form/main",false,TRUE);
	$list = $this->load->view("admin/PAF/list/main",false,TRUE);

	echo lte_tab(['tabs' => ['Personnel Action Form' => '<div class="col-md-12 col-lg-12 col-sm-12">'.$paf.'</div>',
							'Personnel Action Form List' => '<div class="col-md-12 col-lg-12 col-sm-12">'.$list.'</div>'],
				'tab_id' => 'other-ded-tabs' ]);
 ?>

 <?php if ($record->pr_id == ""): ?>
	<center><h3>No Payroll Record Found.</h3></center> 	
<?php else: ?>
	<?php 
		$this->load->view('admin/payroll/payroll_record/table');
	 ?>
 <?php endif ?>
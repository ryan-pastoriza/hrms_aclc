<style type="text/css">
	.loading-div{
		position: absolute;
		top:0px;
		left: 0px;
		height: 100%;
		width:100%;
		background: rgba(255,255,255,0.5);
		z-index: 10000;
	}
	.loading-div>div{
		width:40%;
		margin:30%;
		margin-top:10%;
		position: relative;
		border-radius: 10px;
		padding:10px;
	}
</style>

<div class="row">
	<div class="col-sm-12">	
		<div class="col-sm-3">
              <input type="text" name="employee_id" id="searchEmp" class="form-control" placeholder="Select Employee">
			<?= form_open(base_url('index.php/admin/employee_schedule/set_sched'), 'id="set-sched-form"'); ?>
			<?php 
				$this->load->view('admin/Schedule/Employee_schedule/set_sched/main');
			 ?>
			 <?= form_close(); ?>
		</div>
		<div class="col-sm-9">
			<?php 
				$this->load->view('admin/Schedule/Employee_Schedule/calendar/main');
			 ?>
		</div>
	</div>
</div>
<?php 
	$this->load->view('admin/Schedule/Employee_Schedule/jscripts');
	$this->load->view('admin/Schedule/Employee_Schedule/modals/edit_sched');
	$this->load->view('admin/Schedule/Employee_Schedule/modals/delete_confirm_modal');
	$this->load->view('admin/Schedule/Employee_Schedule/modals/revertSchedModal');
 ?>
 <div class="loading-div hidden">
	<div class="bg-red">
		<h3>Saving Schedule and Updating DTR . . . </h3>
		<hr>
		<p>Please don't leave this page until the process is complete.</p>
	</div>
</div>
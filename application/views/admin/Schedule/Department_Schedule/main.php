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
<?php 
	$this->load->view('admin/Schedule/Department_Schedule/calendar/main.php');
	$this->load->view('admin/Schedule/Department_Schedule/modals/edit_sched');
	$this->load->view('admin/Schedule/Department_Schedule/modals/delete_confirm_modal');
?>
<div class="loading-div hidden">
	<div class="bg-red">
		<h3>Saving Schedule and Updating DTR . . . </h3>
		<hr>
		<p>Please don't leave this page until the process is complete.</p>
	</div>
</div>
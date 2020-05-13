<?php 
	$days = ['mon','tue','wed','thu','fri','sat','sun'];
 ?>

 <style type="text/css">
	.check-label:hover, .radio-label:hover{
		cursor: pointer;
	}
	.fc-event{
		/*height: 3em !important;*/
		padding:5px !important;
	}
	.fc-event .event-buttons{
		display: inline-block;
		position: absolute;
		top: 0px;
		right: 3px;
	}
	.fc-event .event-buttons a{
		color:#fff !important;
		margin:3px;
		display: inline-block;
	}
</style>
<button class="btn btn-xs btn-primary" type='button' data-toggle='modal' data-target='#revertSchedModal'>Revert to Department Schedule</button>
<hr>

<input type="hidden" name="overwrite" value="0">
<input type="hidden" name="employee_id" id="empID">
<div class="col-sm-12">
	<label>Schedule Type</label>
	<br>
	<label><input type="radio" class="text-gray radio-label" name="reg_irreg" value="reg" checked="" id=""> Regular </label> |
	<label> <input type="radio" class="text-gray radio-label" name="reg_irreg" value="irreg"> Irregular </label>
</div>
<div class="col-sm-6">
	<label>Time In</label>
	<input type="time" name="time_in" id="">
</div>
<div class="col-sm-6">
	<label>Time Out</label>
	<input type="time" name="time_out" id="">
</div>
<div id="regForm">
	<div class="col-sm-12">
		<label>Schedule Days</label>
		<table class="table table-bordered">
			<tr>
				<?php foreach ($days as $key => $value): ?>
					<td><label class="text-gray check-label"> <input type="checkbox" name="days[]" id="" value="<?= $value ?>"> <?= $value ?> </label></td>
				<?php endforeach ?>
			</tr>
		</table>
	</div>
	<div class="col-sm-12">
		<label>Schedule Start</label>
		<br>
		<input type="date" name="sched_start" class="form-control" id="">
	</div>
	<div class="col-sm-12">
		<label>Schedule End <small class="text-orange"></small></label>
		<br>
		<input type="date" name="sched_end" class="form-control" id="">
	</div>
</div>
<div id="irregForm" class="hidden">
	<div class="col-sm-12">
		<label>Schedule Dates</label><br>
		<button class="btn btn-xs btn-flat" type="button" id="clearDatesBtn"> <span class="fa fa-times"></span> Clear Dates</button>
		<input readonly="" name="irreg_dates" class="datesPicker" class="form-control" style="width:100% !important">
	</div>
</div>
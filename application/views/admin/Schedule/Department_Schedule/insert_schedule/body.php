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
<?php 
	$days = ['mon','tue','wed','thu','fri','sat','sun']
 ?>
 
 <input type="hidden" name="overwrite" value="0">
 <input type="hidden" name="department_id" id="dept_id_hidden">
<div class="col-sm-12">
	<label>
		Schedule Time
	</label>
</div>
<div class="col-sm-12">
	<div class="col-sm-6">
		In
		<input type="time" name="time_in" required="" >
	</div>
	<div class="col-sm-6">
		Out
		<input type="time" name="time_out" required="" >
	</div>
</div>
<div class="col-sm-12">
	<label>
		Schedule Type
	</label>
	<div class="col-sm-12">
		<label class="text-gray radio-label">
			<input type="radio" name="regirreg" id="" value="1" checked>
			Regular
		</label>
		<label class="text-gray radio-label">
			<input type="radio" name="regirreg" id="" value="0">
			Irregular
		</label>
	</div>
</div>
<div id="regForm">
<div class="col-sm-12">
	<label>
		Days
	</label>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-3 ">
				<table class="table">
					<tr>
				<?php 
					for($i = 0; $i < 7; $i++):
				 ?>
					<td>
					<label class="check-label text-gray bg-info" style="padding:5px;">
						<input type="checkbox" name="sched_days[]" value="<?= $days[$i] ?>" id=""> <br><?= $days[$i] ?>
					</label>
					</td>
				<?php 
					endfor
				 ?>
					</tr>
				</table>
				</div>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<label>Date Start</label>
	<input type="date" name="date_start" class="form-control" id="">
</div>
<div class="col-sm-12">
	<label>Date End <small class="text-orange">**optional</small></label>
	<input type="date" name="date_end" class="form-control" id="">
</div>
</div>
<div id="irregForm" class="hidden">
	<div class="col-sm-12">
		<label>Schedule Dates</label><br>
		<button class="btn btn-xs btn-flat" type="button" id="clearDatesBtn"> <span class="fa fa-times"></span> Clear Dates</button>
		<input readonly="" name="irreg_dates" class="datesPicker" class="form-control" style="width:100% !important">
	</div>
</div>
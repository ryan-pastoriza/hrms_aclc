<?php 
	$days = ['mon','tue','wed','thu','fri','sat','sun'];


 ?>


 <input type="hidden" name="edit_sched_overwrite" value="0">

 <?php if (get_class($sched) == "Emp_irreg_sched"): ?>
	<input type="hidden" name="emp_irreg_sched_id" value="<?= $sched->emp_irreg_sched_id ?>">
	<input type="hidden" name="sched_type" value="irreg">
 	<div class="row">
		<div class="col-sm-12"> 
			<label>Schedule Date</label>
			<br>
			<input type="date" class="form-control" name="sched_date" id="" value="<?= date('Y-m-d', strtotime($sched->emp_irreg_sched_date)) ?>">
		</div>
		<div class="col-sm-6">
			<label>Time In</label>
			<br>
			<input type="time" class="form-control" name="time_in" id="" value="<?= date('H:i', strtotime($sched->emp_irreg_sched_time_in)) ?>">
		</div>
		<div class="col-sm-6">
			<label>Time Out</label>
			<br>
			<input type="time" class="form-control" name="time_out" id="" value="<?= date('H:i', strtotime($sched->emp_irreg_sched_time_out)) ?>">
		</div>		
	</div>
<?php else: ?>
	<input type="hidden" name="eec_nfds_id" value="<?= $sched->eec_nfds_id ?>">
	<input type="hidden" name="sched_type" value="reg">
	<div class="row">
		<div class="col-sm-6">
			<label>Schedule Day</label>
			<br>
			<select class="form-control" name="day">
			<?php foreach ($days as $key => $value): ?>
				<option <?= $value == $sched->nfds_day ? "selected" : ""  ?> ><?= $value ?></option>
			<?php endforeach ?>
			</select>
		</div>
		<div class="col-sm-6">
			<label>Start Date</label>
			<br>
			<input class="form-control" type="date" name="date_start" value="<?= $sched->start ?>" id="">
		</div>
		<div class="col-sm-6">
			<label>Time in</label><br>
			<input class="form-control" type="time" name="time_in" value="<?= $sched->nfds_time_in ?>" id="">
		</div>
		<div class="col-sm-6">
			<label>Time out</label><bR>
			<input class="form-control" type="time" name="time_out" value="<?= $sched->nfds_time_out ?>" id="">
		</div>
		
	</div>
<?php endif ?>


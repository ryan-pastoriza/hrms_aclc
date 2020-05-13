<?php
/**
 * @Author: gian
 * @Date:   2016-07-25 13:50:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-10 14:31:26
 */
?>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-sm-4" style="text-align: left;">DATE FILED</label>
				<div class="col-md-8" >
				    <input type="date" name="fileDate" class="form-control" value ="<?= date('Y-m-d') ?>"required>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-sm-4" for="empSearch">NAME</label>
				<div class="col-md-8" style="margin-top:-5px !important;">
					<?php if($this->userInfo->user_privilege == "admin"): ?>
						<input type="text" id="empSearch" class="form-control" style="font-size: 1.3em;" required>

						<input type="text" name="empId" id="empId" hidden>
					<?php endif; ?>
					<?php if($this->userInfo->user_privilege == "employee"): ?>
						<input type="text" value="<?= $this->userInfo->fullName("f m. l") ?>" class="form-control" style="font-size: 1.3em;border:none;" readonly> 
					<?php endif; ?>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-sm-4" for="position">POSITION</label>
				<div class="col-md-8">
					<?php if($this->userInfo->user_privilege == "admin"): ?>
					<input type="text" class="form-control" id="position" readonly>
					<?php elseif($this->userInfo->user_privilege == "employee"): ?>
					<input type="text" class="form-control" id="position" value="<?= $this->userInfo->employment_job_title; ?>" style="border:none;" readonly>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-sm-4" for="department">DEPARTMENT</label>
				<div class="col-md-8">
					<?php if($this->userInfo->user_privilege == "admin"): ?>
						<input type="text" class="form-control" id="department" readonly>
					<?php elseif($this->userInfo->user_privilege == "employee"): ?>
						<input type="text" class="form-control" id="department" value="<?= $this->userInfo->department_name?>" style="border:none;" readonly>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-sm-2" for="department">Log Date</label>
				<div class="col-md-4">
					<input type="date" class="form-control" id="log-date" name="emp_lfr_date" required="">
				</div>
			</div>
		</div>
	</div>
	<div sched-view></div>
<!-- 	<div class="row" id="logsFail">
		<div class="col-md-6">
				<label>
					<input type="checkbox" id="in" name="in" value="check"> Log-in
				</label> 
				<label>
					<input type="checkbox" id="out" name="out" value="check"> Log-out
				</label>
			<div class="form-group">
			 	<label class="col-md-1">
			 	</label>
			 	<div class="col-md-11" id="inForm" hidden>
			 		<div class="row">
			 			<div class="form-group">
			 				<label class="col-md-4" style="padding-top:6px;">Time</label>
			 				<div class="col-md-8 bootstrap-timepicker">
			 					<input type="text" class="form-control timepicker1" name="inFailTime" >
			 				</div>
			 			</div>
			 		</div>
			 		<div class="row">
			 			<div class="form-group">
				 			<label class="col-md-4">Date</label>
				 			<div class="col-md-8">
			 					<input type="date" class="form-control" name="inFailDate">
			 				</div>
				 		</div>
			 		</div>
			 	</div>
			</div>
		</div>
		<div class="col-md-6">
			<br>
			<div class="form-group">
			 	<label class="col-md-1">
			 	</label>
			 	<div class="col-md-11" id="outForm" hidden>
			 		<div class="row">
			 			<div class="form-group">
			 				<label class="col-md-4" style="padding-top:6px;">Time</label>
			 				<div class="col-md-8 bootstrap-timepicker">
			 					<input type="text" class="form-control timepicker2" name="outFailTime">
			 				</div>
			 			</div>
			 		</div>
			 		<div class="row">
			 			<div class="form-group">
				 			<label class="col-md-4">Date</label>
				 			<div class="col-md-8">
			 					<input type="date" class="form-control" name="outFailDate">
			 				</div>
				 		</div>
			 		</div>
			 	</div>
			</div>
		</div>
	</div> -->
	<div class="row">
		<div class="col-md-12">
			<label>Reason/s:</label>
			<textarea class="form-control" style="resize: none;height: 100px;" name="failReason"></textarea>
		</div>
	</div>
</div>
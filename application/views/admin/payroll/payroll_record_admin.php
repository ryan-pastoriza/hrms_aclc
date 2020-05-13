<?php 
	$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
 ?>
<div class="col-sm-6">
	<div class="col-sm-4">
		<label>SELECT MONTH</label>
		<select name="" id="month-selector" class="form-control">
			<option value="">[SELECT]</option>
			<?php foreach ($months as $key => $value): ?>
				<option value="<?= $key + 1 ?>"><?= $value ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-sm-4">
		<label for="">PAYROLL DATE</label>
		<select id='date-selector' class="form-control">
			<option value="">[SELECT]</option>
			<option>15th</option>
			<option>Month end</option>
		</select>
	</div>
	<div class="col-sm-4">
		<label for="">PAYROLL YEAR</label>
		<select id="year-selector" class="form-control">
			<option value="">[SELECT]</option>
			<?php 
				for ($i= date('Y'); $i >= 1990  ; $i--) { 
			?>
				<option><?= $i ?></option>
			<?php
				}
			 ?>
		</select>
	</div>
	</form>
</div>
<div class="col-sm-12" payroll-rec-view >
	<center><h3 > <span style="border:3px solid #eee;margin-top:100px; padding:10px 20px">SELECT PAYROLL DATE </span></h3></center>
</div>

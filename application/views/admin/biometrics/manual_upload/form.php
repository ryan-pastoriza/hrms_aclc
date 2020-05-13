<div class="box">
	<?= form_open_multipart(base_url('index.php/admin/biometrics/upload_attendance'),"id=upload-attendance-form"); ?>
	<div class="box-header with-border">	
		<span class="box-title">
			Manually Upload Attendance
		</span>
	</div>
	<div class="box-body">
		<input type="file" name="attlog">
		<p class="display"></p>
	</div>
	<div class="box-footer">
		<div class="pull-right">
		<button class="btn btn-primary">Submit</button>
		</div>
	</div>
	<?= form_close(); ?>

</div>
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="col-sm-12" style="margin-bottom:2%">
				<select class="select2" id="department-selector">
					<option value="">[SELECT DEPARTMENT]</option>
					<?php foreach ($allDepts as $key => $value): ?>
						<option value="<?= $value->department_id ?>"><?= $value->department_name ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">
						<?php 
							echo form_open(base_url('index.php/admin/department_schedule/set_sched'), 'id="set_schedule"');
							$this->load->view('admin/Schedule/Department_Schedule/insert_schedule/form');
							echo form_close();
						 ?>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="box box-primary">
			        <div class="box-body no-padding">
			          <div id="calendar"></div>
			        </div>
			    </div>
		    </div>
	    </div>
  	</div>
</div>
<?php 
	$this->load->view('admin/Schedule/Department_Schedule/calendar/jscripts');
?>
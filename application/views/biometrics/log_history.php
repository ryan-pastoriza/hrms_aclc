<div class="box box-navy box-solid" >
    <div class="box-header ">
      <h3 class="box-title source-light"> Today's Logs </h3>
		<div class="box-tools pull-right">
            <i class="fa fa-user" style="font-size: 2em;"></i>
		</div>
    </div>
    <!-- /.box-header -->
    <div class="box-body row">
		<ul class="log-history">
			<?php if ($recentLogs['recentLogs']): ?>
				
			<?php foreach ($recentLogs['recentLogs'] as $key => $value): 
				$timg = file_exists("images/users/{$value->employee_id}.jpg") ? base_url("images/users/{$value->employee_id}.jpg") : base_url('images/no-image.fw.png');
			?>
				<li class="col-sm-12">
					<div class="empInfo">
						<img src="<?= $timg ?>">
						<div class="info-block">
							<h3>
							<?= $value->fullName('f m. l') ?>
							<br>
							<small><?= $value->department_name ?><br>
							<?= $value->employment_job_title ?>
							</small>
							</h3>											
						</div>
						<?php foreach ($value->logs_today as $key2 => $value2): ?>
						<?php 
							$schedInfo = $value2->sched_info();
						?>
							<div class="log-block">
								<label style="font-size:2em"><?= date('a', strtotime($schedInfo->{$schedInfo::TIME_IN})) == 'am' ? 'Morning' : 'Afternoon' ?></label>
								<div class="block"  style="font-size:2em">
									<span>IN</span>
									<?= $value2->emp_log_in != '' ? date ('h:i a', strtotime($value2->emp_log_in)) : '<b class="text-red">xx:xx</b>' ?>
								</div>
								<div class="block"  style="font-size:2em">
									<span >OUT</span>
									<?= $value2->emp_log_out != '' ? date ('h:i a', strtotime($value2->emp_log_out)) : '<b class="text-red">xx:xx</b>' ?>
								</div>									
							</div>
						<?php endforeach ?>

					</div>

				</li>
			<?php endforeach ?>
			<?php endif ?>
		</ul>
    </div>
    <!-- /.box-body -->
  </div>
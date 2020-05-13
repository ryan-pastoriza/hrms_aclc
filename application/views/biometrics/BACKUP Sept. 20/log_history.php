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
			<?php foreach ($recentLogs['recentLogs'] as $key => $value): ?>
				<li class="col-sm-12">
					<div class="empInfo">
						<img src="<?= base_url('images/users/btn-2012-0213.jpg') ?>">
						<div class="info-block">
							<h3>
							<?= $value->fullName('f m. l') ?>
							<br>
							<small><?= $value->department_name ?><br>
							<small><?= $value->employment_job_title ?></small>
							</small>
							</h3>											
						</div>
						<?php foreach ($value->logs_today as $key2 => $value2): ?>
							<div class="log-block">
								<label><?= date('a', strtotime($value2->nfds_time_in)) == 'am' ? 'Morning' : 'Afternoon' ?></label>
								<div class="block">
									<span>IN</span>
									<?= $value2->log_in != '' ? date ('h:i a', strtotime($value2->log_in)) : '<b class="text-red">xx:xx</b>' ?>
								</div>
								<div class="block">
									<span>OUT</span>
									<?= $value2->log_out != '' ? date ('h:i a', strtotime($value2->log_out)) : '<b class="text-red">xx:xx</b>' ?>
								</div>									
							</div>
						<?php endforeach ?>

					</div>

				</li>
			<?php endforeach ?>
		</ul>
    </div>
    <!-- /.box-body -->
  </div>
<?php 
	$lastLog = reset($recentLogs['recentLogs']);
 ?>

<div class="panel logger" >
	<div class="img-frame">
		<?php 
			$lastLogImg = $lastLog && file_exists("images/users/{$lastLog->employee_id}.jpg") ? base_url("images/users/{$lastLog->employee_id}.jpg") : base_url('images/no-image.fw.png');

		 ?>
		 <?php if ($lastLog): ?>
		<img src="<?= $lastLogImg ?>">
		<div class="logger-info source-light">
			Good <?= date('a') == 'am' ? "Morning" : "Afternoon" ?> !
			<h1 class="source-light" style="line-height: .1em;"><?= isset($lastLog->employee_id) ? $lastLog->fullName('f m. l') : "" ?></h1>
			<?= $lastLog->department_name ?> / <?= $lastLog->employment_job_title ?>
		</div>
		<?php else: ?>
		<img src="<?= base_url('images/no-image.fw.png') ?>">
		<div class="logger-info source-light">
			Good <?= date('a') == 'am' ? "Morning" : "Afternoon" ?> !
			<h1 class="source-light" style="line-height: .1em;"></h1>
			
		</div>
		 <?php endif ?>
	</div>
	<label class='log-label source-regular'>Log Monitoring</label>
	
			<?php if ($lastLog): ?>
				
			<?php foreach ($lastLog->logs_today as $key => $log): ?>
				<?php 
					$sched = date('A',strtotime($log->nfds_time_in));
		            $logOutTimeDisp = "<span class='text-red'>xx:xx</span>";
		            $loginTimeDisp = "<span class='text-red'>xx:xx</span>";
		            $lateDisplay = "";
		            $underDisplay = "";
		            $loginTimeDisp = date('h:i', strtotime($log->log_in));

		            if ($log->log_out != "") {
		              $logOutTimeDisp = date('h:i', strtotime($log->log_out));

		              if (strtotime($log->log_out) < strtotime($log->nfds_time_out)) {
		                $logOutInterval = $this->funcs->time_interval($log->log_out,$log->nfds_time_out);
		                $underTimeHrs  = $logOutInterval->h;
		                $underTimeMins = $logOutInterval->i;

		                if ($underTimeHrs) {
		                  $underDisplay .= $underTimeHrs . " hour/s and ";
		                }
		                // if ($underTimeMins) {
		                  $underDisplay .= $underTimeMins . " minute/s early.";
		                // }
		              }
		            }
		            if ($log->log_in != "") {
		                if (strtotime($log->log_out) < strtotime($log->nfds_time_out)) {
		                  $log_in_interval = $this->funcs->time_interval($log->nfds_time_in,$log->log_in);
		                  $lateHours = $log_in_interval->h;
		                  $lateMins = $log_in_interval->i;

		                  if ($lateHours) {
		                    $lateDisplay .= $lateHours. " hour/s and ";
		                  }
		                  // if ($lateMins) {
		                    $lateDisplay .= $lateMins." minute/s late.";
		                  // }
		                }
		              }
				 ?>

				 <div class="log-monitor" >
					<div class="logs" >
					<label><?= date('a',strtotime($log->nfds_time_in)) == 'am' ? "Morning" : "Afternoon" ?></label>
					<ul class="log-set" >
					<li class="row">
						<div class="col-sm-6">
							<div class="left-part">
								<h1 style="margin-top: 10px"> 
									
									<small class="navy-text">in</small>
									<?=  $loginTimeDisp ?>
									<p class="label-danger">
										<?= $lateDisplay ?>
									</p>
								</h1>
							</div>
							<div class="right-part">
								<h1><?= strtoupper(date('a', strtotime($log->log_in))) ?></h1>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="left-part">
								<h1 style="margin-top: 10px">
									<small class="navy-text">out</small>
									<?= $logOutTimeDisp ?>
									<p class="label-danger">
										<?= $underDisplay ?>
									</p>
								</h1>
							</div>
							<div class="right-part">
								<h1>PM</h1>
							</div>
						</div>
					</li>
				</ul>
			<hr>
				</div>
			</div>
			<?php endforeach ?>

			<?php endif ?>
</div>
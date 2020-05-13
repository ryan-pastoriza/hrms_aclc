<?php 
	$llastLog = $recentLogs['recentLogs'] ?  reset($recentLogs['recentLogs']) : FALSE;

	if ($llastLog && $llastLog->logs_today) {
		if (count($llastLog->logs_today) > 1) {
			if (end($llastLog->logs_today)->emp_log_out != "") {
			 $checkTime = end($llastLog->logs_today)->emp_log_out;
			}
			elseif (strtotime(reset($llastLog->logs_today)->emp_log_out) > end($llastLog->logs_today)->emp_log_in) {
				$checkTime = reset($llastLog->logs_today)->emp_log_out;
			}
			else{
				$checkTime = end($llastLog->logs_today)->emp_log_in;
			}
		}
		else{
			$checkTime = end($llastLog->logs_today)->emp_log_out != "" ? end($llastLog->logs_today)->emp_log_out : end($llastLog->logs_today)->emp_log_in;
		}
		$checkTime = date('Y-m-d',strtotime(end($llastLog->logs_today)->emp_log_date))." ".$checkTime;
	}

	$errors = $this->session->userdata('log_errors');
	if ($errors) {
		$lastError = $errors;
		if (isset($checkTime)) {
			$lastLog = strtotime($checkTime) > strtotime($lastError['time']) ? $llastLog : $lastError;
		}
		else{
			$lastLog = $lastError;
		}
	}
	else{
		$lastLog = $llastLog;
	}

 ?>

<div class="panel logger" >
	<div class="img-frame">
		<?php 
			$lastLogImg = $lastLog && is_object($lastLog) && file_exists("images/users/{$lastLog->employee_id}.jpg") ? base_url("images/users/{$lastLog->employee_id}.jpg") : base_url('images/no-image.fw.png');
		 ?>
		 <?php if ($lastLog && is_object($lastLog)): ?>
		<img src="<?= $lastLogImg ?>">
		<div class="logger-info source-light">
			<span style="font-size:2em;line-height:0.7em;margin-top:5px">Good <?= date('a') == 'am' ? "Morning" : "Afternoon" ?> !</span>
			<h1 class="source-light" style="line-height: .3em;font-size:3em"><?= isset($lastLog->employee_id) ? $lastLog->fullName('f m. l') : "" ?></h1>
			<small style="font-size:2em"><?= $lastLog->department_name ?> / <?= $lastLog->employment_job_title ?></small>
		</div>
		<?php elseif(isset($lastLog['text'])): ?>
			<!-- <img src="<?= $lastLogImg ?>"> -->
			<h1 style="height:500px;line-height:500px;font-size:15em"><i class="fa fa-user-times text-red"></i></h1>
			<div class="logger-info source-light" style="background:rgba(255,0,0,0.5)">
				Good <?= date('a') == 'am' ? "Morning" : "Afternoon" ?> !
				<h1 class="source-light" style="line-height: 1em; font-size:1.5em !important">
					<?= $lastLog['text'] ?>
				</h1>
			</div>
		<?php elseif(isset($lastLog['error'])): 
			$lastLogImg = file_exists("images/users/{$lastLog->employee_id}.jpg") ? base_url("images/users/{$lastLog->employee_id}.jpg") : base_url('images/no-image.fw.png');

		?>
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
	
			<?php if ($lastLog && is_object($lastLog)): ?>
				
			<?php foreach ($lastLog->logs_today as $key => $log): ?>
				<?php 
					$sched 				= date('A',strtotime($log->emp_log_in));
		            $logOutTimeDisp 	= "<span class='text-red'>xx:xx</span>";
		            $loginTimeDisp 		= "<span class='text-red'>xx:xx</span>";
		            $lateDisplay 		= "";
		            $underDisplay 		= "";
		            $loginTimeDisp 		= $log->emp_log_in != '' ? date('h:i', strtotime($log->emp_log_in)) : $loginTimeDisp ;
		            $schedInfo 			= $log->sched_info();


		            if ($log->emp_log_out != "") {
		              $logOutTimeDisp = date('h:i', strtotime($log->emp_log_out));

		              if (strtotime($log->emp_log_out) < strtotime($schedInfo->{$schedInfo::TIME_OUT})) {
		                $logOutInterval = $this->funcs->time_interval($log->emp_log_out,$schedInfo->{$schedInfo::TIME_OUT});
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
		            if ($log->emp_log_in != "") {
		                if (strtotime($log->emp_log_in) > strtotime($schedInfo->{$schedInfo::TIME_IN})) {
		                  $log_in_interval = $this->funcs->time_interval($log->emp_log_in,$log->emp_log_in);
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
					<label style="font-size:2em"><?= date('a',strtotime($log->emp_log_in)) == 'am' ? "Morning" : "Afternoon" ?></label>
					<ul class="log-set" >
					<li class="row">
						<div class="col-sm-6" <?= $lateDisplay != "" ? "style='background:#DD4B39;color:#fff'": "" ?>>
							<div class="left-part">
								<h1 style="margin-top: 10px"> 
									
									<small class="navy-text">in</small>
									<?=  $loginTimeDisp ?>
									<p style="font-size:.5em">
										<?= $lateDisplay ?>
									</p>
								</h1>
							</div>
							<div class="right-part">
								<h1><?= strtoupper(date('a', strtotime($log->emp_log_in))) ?></h1>
							</div>
						</div>
						<div class="col-sm-6" <?= $underDisplay != "" ? "style='background:#DD4B39;color:#fff'": "" ?>>
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
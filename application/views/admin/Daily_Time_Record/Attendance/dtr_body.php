<tbody>
	<?php if ($headings): ?>
			<?php foreach ($dateArray as $key => $value): 
				$this->load->model('event');

				// set variables to display later
				$totalLate 	= 0;
				$totalOT 	= 0;
								$totalUT 	= 0;

				$event  = new Event;
				$has_event	= $event->has_event_on($value->format('Y-m-d'), $value->format('Y-m-d'));
				$has_event = reset($has_event);
				
			?>
					<tr>
						<td><?php echo $value->format('M d') ?></td>

						<?php foreach ($headings as $key2 => $value2):
							$scheds = $emp->scheds($value->format('Y-m-d'));
						?>
							<?php foreach ($scheds as $key3 => $value3): ?>
							<?php 
							
								$heading = date('H:i', strtotime($value3->{$value3::TIME_IN}) )." - ".date('H:i', strtotime($value3->{$value3::TIME_OUT}));
							?>

							<?php if ($heading == $value2): 
								$hasLog   = $value3->log( $emp->employee_id, $value->format('Y-m-d'));
								$hasLeave = $value3->on_leave($emp->employee_id, $value->format('Y-m-d'));
							?>
							<!-- if has log -->
								<?php if ($hasLog->emp_log_id != ""): 
									if ($hasLog->emp_log_in != "") {
										// compare actual log in and scheduled log in
										$log_in = date('H:i',strtotime($hasLog->emp_log_in));
										$diff = $this->funcs->time_interval($log_in,$value3->{$value3::TIME_IN});

										if ($diff->invert) {
											$totalLate += $diff->h * 60;
											$totalLate += $diff->i;
										}

									}
									if ($hasLog->emp_log_out != "") {
										$log_out = date('H:i',strtotime($hasLog->emp_log_out));
										$diff = $this->funcs->time_interval($value3->{$value3::TIME_OUT},$log_out);

										if ($diff->invert) {
											$totalUT += $diff->h * 60;
											$totalUT += $diff->i;
										}

									}
								?>
									<td>
										<?php if ($this->userInfo->user_privilege == "admin"): ?>
											
										<?= $hasLog->emp_log_in != "" ? "<span class=\"log-editable\" data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."' data-name='emp_log_in' data-has_log='yes'>".date('h:i a', strtotime($hasLog->emp_log_in))."</span> <div class=\"btn-group pull-right\"><a href='#' class='text-warning btn btn-xs btn-default dropdown-toggle' data-toggle='dropdown'><i class='fa fa-remove'></i></a><ul class=\"dropdown-menu bg-primary\"><li class=\"label-default label\">Clear Log?</li><li><a href=\"#\" clear-log='{$hasLog->emp_log_id}' log-type='emp_log_in'>Yes</a></li><li><a href=\"#\">No</a></li></ul></div>" : "<span class='text-danger log-editable' data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."' data-emp_log_sched_type='".get_class($value3)."' data-name='emp_log_in' data-has_log='yes'> No Log </span>" ?>
										<?php else: ?>
										<?= $hasLog->emp_log_in != "" ? "<span class=\"log-editable\" data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."' data-name='emp_log_in' data-has_log='yes'>".date('h:i a', strtotime($hasLog->emp_log_in))."</span>" : "<span class='text-danger log-editable' data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."' data-emp_log_sched_type='".get_class($value3)."' data-name='emp_log_in' data-has_log='yes'> No Log </span>" ?>
										<?php endif ?>
									</td>					
									<td>
										<?php if ($this->userInfo->user_privilege == "admin"): ?>
											<?= $hasLog->emp_log_out != "" ? "<span class=\"log-editable\" data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."' data-name='emp_log_out' data-has_log='yes'>".date('h:i a', strtotime($hasLog->emp_log_out))."</span> <div class=\"btn-group pull-right\"><a href='#' class='text-warning btn btn-xs btn-default  dropdown-toggle' data-toggle='dropdown'><i class='fa fa-remove'></i></a><ul class=\"dropdown-menu\"><li class=\"label-default label\">Clear Log?</li><li><a href=\"#\" clear-log='{$hasLog->emp_log_id}' log-type='emp_log_out'>Yes</a></li><li><a href=\"#\">No</a></li></ul></div>" : "<span class='text-danger log-editable' data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."'  data-emp_log_sched_type='".get_class($value3)."' data-name='emp_log_out' data-has_log='yes'> No Log </span>" ?>
										<?php else: ?>
											<?= $hasLog->emp_log_out != "" ? "<span class=\"log-editable\" data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."' data-name='emp_log_out' data-has_log='yes'>".date('h:i a', strtotime($hasLog->emp_log_out))."</span>" : "<span class='text-danger log-editable' data-pk='{$hasLog->emp_log_id}' data-date='".$value->format('Y-m-d')."'  data-emp_log_sched_type='".get_class($value3)."' data-name='emp_log_out' data-has_log='yes'> No Log </span>" ?>
										<?php endif ?>
									</td>					
								<!-- else no log -->
								<?php else: ?>

									<!-- if has calendar event -->
									<?php if ($has_event): ?>
										<td>
											<span class="text-success">
												<?= $has_event->title ?>
											</span>
										</td>
										<td>
											<span class="text-success">
												<?= $has_event->title ?>
											</span>
										</td>

									<!-- else if employee is on leave -->
									<?php elseif($hasLeave && $hasLeave->emp_leave_id != ""): ?>
										<td>
										 <span class="text-danger"><?= "ON {$hasLeave->emp_leave_availment}" ?></span>  </td>
								 		<td> <span class="text-danger"><?= "ON {$hasLeave->emp_leave_availment}" ?></span>  </td>

								 	<!-- else if employee is not on leave and schedule has no holiday -->
									<?php else: ?>
										<td>
											<span class="text-danger log-editable" data-pk="<?= $value3->{$value3::DB_TABLE_PK} ?>" data-date='<?= $value->format('Y-m-d') ?>' data-emp_log_sched_type='<?= get_class($value3) ?>' data-name='emp_log_in' data-has_log="no">ABSENT</span>
										</td>
										<td>
											<span class="text-danger log-editable" data-pk="<?= $value3->{$value3::DB_TABLE_PK} ?>" data-date='<?= $value->format('Y-m-d') ?>' data-emp_log_sched_type='<?= get_class($value3) ?>' data-name='emp_log_out' data-has_log="no">ABSENT</span>
										</td>
									<?php endif ?>
									
								<?php endif ?>
								<?php 
									continue 2;
								 ?>
								<!-- end of if has log -->

							<?php else: ?>
								<?php if (!in_array($heading, $headings)): ?>
									<td>
										<span class="text-gray">n/a</span>
									</td>
									<td>
										<span class="text-gray">n/a</span>
									</td>
								<?php endif  ?>
							<?php endif ?>
							<?php endforeach ?>
							<!-- end of sched loop -->
								<td><span class="text-gray">n/a</span></td>
								<td><span class="text-gray">n/a</span></td>
						<?php endforeach ?>
						<!-- end of headings loop -->

							<td><?php echo $totalLate ?></td>
							<td><?php echo $totalUT ?></td>

						<?php foreach ($overtime as $key2 => $value2): 
							$overtime_on_day = $emp->overtime($value->format('Y-m-d'));
						?>
						<?php if ($overtime_on_day): ?>
							<?php foreach ($overtime_on_day as $key3 => $value3): ?>
								<?php if ($value3->emp_ot_id == $value2['obj']->emp_ot_id): 
									$ot_log = $value3->logs();
								?>
								<?php if ($ot_log): ?>
									<td>
										<?php if ($ot_log->emp_ot_in == false || $ot_log->emp_ot_in == ""): ?>
											<span class="ot-log-editable text-danger" emp-ot-id="<?= $value3->emp_ot_id ?>"  log-type="in">no log</span>
										<?php else: ?>
											<span class="ot-log-editable" emp-ot-id="<?= $value3->emp_ot_id ?>"  log-type="in"><?= date('h:i a', strtotime($ot_log->emp_ot_in)) ?></span> 
											<div class="btn-group pull-right"><a href='#' class='text-warning btn btn-xs btn-default dropdown-toggle' data-toggle='dropdown'><i class='fa fa-remove'></i></a><ul class="dropdown-menu bg-primary"><li class="label-default label">Clear Log?</li><li><a href="#" clear-ot-log='<?= $value3->emp_ot_id ?>' log-type='in'>Yes</a></li><li><a href="#">No</a></li></ul></div>
										<?php endif ?>

									</td>
									<td>
										<?php if ($ot_log->emp_ot_out == false || $ot_log->emp_ot_out == ""): ?>
											<span class="text-danger ot-log-editable" emp-ot-id="<?= $value3->emp_ot_id ?>" log-type="out">no log</span>
										<?php else: ?>
											<span class="ot-log-editable" emp-ot-id="<?= $value3->emp_ot_id ?>"  log-type="out"><?= date('h:i a', strtotime($ot_log->emp_ot_out)) ?></span>
											<div class="btn-group pull-right"><a href='#' class='text-warning btn btn-xs btn-default dropdown-toggle' data-toggle='dropdown'><i class='fa fa-remove'></i></a><ul class="dropdown-menu bg-primary"><li class="label-default label">Clear Log?</li><li><a href="#" clear-ot-log='<?= $value3->emp_ot_id ?>' log-type='out'>Yes</a></li><li><a href="#">No</a></li></ul></div>
										<?php endif ?>
									</td>
								<?php else: ?>
									<td><span class="ot-log-editable text-danger" emp-ot-id="<?= $value3->emp_ot_id ?>"  log-type="in">ABSENT</span></td>
									<td><span class="ot-log-editable text-danger" emp-ot-id="<?= $value3->emp_ot_id ?>"  log-type="out">ABSENT</span></td>
								<?php endif ?>
								<?php endif ?>
							<?php endforeach ?>
						<?php else: ?>
							<td><span class="text-gray">n/a</span></td>
							<td><span class="text-gray">n/a</span></td>
						<?php endif ?>

						<?php endforeach ?>	
					</tr>
				
			<?php endforeach ?>
	<?php else: ?>
	<?php endif ?>
</tbody>
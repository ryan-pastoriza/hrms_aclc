<table class="table table-bordered table-condensed bg-info">
	<thead>
		<th>Shift</th>
		<th>Time In</th>
		<th>Time Out</th>
	</thead>
	<?php foreach ($sched as $key => $value): ?>
		<tr>
			<td>
				<?= date('h:i a', strtotime($value->{$value::TIME_IN})) ?> - <?= date( "h:i a", strtotime($value->{$value::TIME_OUT})) ?>
			</td>
			<td>
				<?php if ($log = $value->log( $employee_id, $date)): ?>
					<input type="time"  value = "<?= $log->emp_log_in ?>" <?=  $log->emp_log_in == "" ? "" : "readonly='readonly'" ?> <?= $log->emp_log_in != "" && $log->emp_log_out != "" ? "" : "name='emp_log_in[{$value->{$value::DB_TABLE_PK}}]'"  ?> >
				<?php else: ?>
					<input type="time"  value = ""  name='emp_log_in[<?= $value->{$value::DB_TABLE_PK} ?>]' >
				<?php endif ?>
				<input type="hidden" name="sched_class[<?= $value->{$value::DB_TABLE_PK} ?>]" value= "<?= get_class($value) ?>">
			</td>
			<td>
				<?php if ($log): ?>
					<input type="time"  value = "<?= $log->emp_log_out ?>" <?= $log->emp_log_out == "" ? "" : "readonly='readonly'" ?> <?= $log->emp_log_in != "" && $log->emp_log_out != "" ? "" : "name='emp_log_out[{$value->{$value::DB_TABLE_PK}}]'"  ?> >
				<?php else: ?>
					<input type="time"  name='emp_log_out[<?= $value->{$value::DB_TABLE_PK} ?>]' >
				<?php endif ?>
			</td>	
		</tr>
	<?php endforeach ?>
</table>
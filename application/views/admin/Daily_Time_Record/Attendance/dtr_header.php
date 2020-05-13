<?php if ($headings): ?>
	<thead>
		<tr>
			<th rowspan="2">Date</th>
		<?php foreach ($headings as $key => $value): 
			$sections = explode("-",$value);
			$timeIn = $sections[0];
			$timeOut = $sections[1];
		?>
				<th colspan="2"><?= date("h:i a", strtotime($timeIn)) ?> - <?= date("h:i a", strtotime($timeOut)) ?></th>
		<?php endforeach ?>
			<th rowspan="2">Total Late</th>
			<th rowspan="2">Total Undertime</th>
		<?php foreach ($overtime as $key => $value): ?>
			<th colspan="2">OVERTIME</th>
		<?php endforeach ?>
		</tr>
		<tr>
			<?php foreach ($headings as $key => $value): ?>
				<th>IN</th>
				<th>OUT</th>
			<?php endforeach ?>
			<?php foreach ($overtime as $key => $value): ?>
				<th><?= date("h:i a", strtotime($value['obj']->emp_ot_from)) ?></th>
				<th><?= date("h:i a", strtotime($value['obj']->emp_ot_to)) ?></th>
			<?php endforeach ?>
		</tr>
	</thead>
<?php else: ?>
	<thead>
		<tr>
			<th>No Schedule set</th>
		</tr>
		</thead>
<?php endif ?>
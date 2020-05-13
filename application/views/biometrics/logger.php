<?php
/**
 * @Author: khrey
 * @Date:   2015-09-11 07:59:00
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-09-11 11:24:56
 */
?>
<?= $day ?>
<hr>
<?= $date ?>
<hr>
<?= $time ?>
<hr>
<?php foreach ($birthdays as $key => $value): ?>
	<div style="background: #222;width:200px;padding:5px;display:block;color:white;margin:5px">
		<?= $value->fullName() ?>
	</div>
<?php endforeach ?>
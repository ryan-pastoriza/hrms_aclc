<?php if ($deptSched): ?>
	<?php foreach ($deptSched as $key => $value): ?>
		<tr>
		  <td><?= $value->nfds_day ?> </a></td>
		  <td><?= $value->nfds_time_in ?> </a></td>
		  <td><?= $value->nfds_time_out ?> </a></td>
		  <td> 
		    <div class="btn-group">
		      <a href='#' type="button" class="text-red dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		        <span class="glyphicon glyphicon-trash"></span>
		      </a>
		      <ul class="dropdown-menu">
		        <li><span class='label alert-warning'>Are you sure?</span></li>
		        <li><a href="#" class="deleteDepartment" department_id=" <?= $value->department_id ?> ">Yes</a></li>
		        <li><a href="#" id="no">No</a></li>
		      </ul>
		    </div>
		  </td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<h1 class="title">No Schedule set.</h1>
<?php endif ?>

<?php foreach ($allDepartments as $key => $value): ?>
	<tr>
	  <td> <a href="#" data-type="text" data-title="Enter Department Name"  data-pk="<?= $value->department_id ?>" class="editable deptName editable-click" > <?= $value->department_name ?> </a></td>
	  <td> 
	    <div class="btn-group">
	      <button type="button" class="btn btn-xs btn-flat btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	        <span class="glyphicon glyphicon-trash"></span>
	      </button>
	      <ul class="dropdown-menu">
	        <li><span class='label alert-warning'>Are you sure?</span></li>
	        <li><a href="#" class="deleteDepartment" department_id=" <?= $value->department_id ?> ">Yes</a></li>
	        <li><a href="#" id="no">No</a></li>
	      </ul>
	    </div>
	  </td>
	</tr>
<?php endforeach ?>
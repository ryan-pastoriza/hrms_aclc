<?php
	$this->load->view('admin/Schedule/Department_Schedule/widget/jscripts');
?>
	<table class="table table-bordered table-striped" id="schedTable">
		<thead>
			<tr>
			    <th>Schedule Day</th>
			    <th>Time In</th>
			    <th>Time Out</th>
			    <th>Actions</th>
			</tr>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all" id='deptLV'>
<?php if ($deptSched): ?>
	        <?php 
	          $this->load->view('admin/widgets/department_schedule/dept_sched_listview');
	         ?>
<?php else: ?>
			<tr>
				<td><h3 class="text-info"><i class="fa fa-info"></i> Choose a Department Name</h3></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
<?php endif ?>
	    </tbody>
	</table>
	<div class="col-md-12">
	</div>
</div><!-- end of content wrapper-->
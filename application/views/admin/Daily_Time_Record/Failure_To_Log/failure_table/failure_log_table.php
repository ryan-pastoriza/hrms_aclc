<?php
/**
 * @Author: gian
 * @Date:   2016-04-11 08:08:55
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-11 11:43:29
 */
	$this->load->view('admin/Daily_Time_Record/Failure_To_Log/failure_table/jscripts');

?>
<div class="box box-primary">
    <div class="box-header">
      	<h3 class="box-title">Employee Failure Logs</h3>
      	<div class="pull-right box-tools">
        	<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
      	</div>
      	<br />
      	<div>
      		<label> Name : </label> <form><input type="text" id="lfrEmpSearch" class="form-control" style="font-size: 1.3em;"></form>
      	</div>
    </div>
    <div class="box-body">
    	
      	<table class="table table-bordered table-striped" id="failureTable">
			<thead>
				<tr>
				    <th>Date Filed</th>
				    <th>Login</th>
				    <th>Logout</th>
				    <th>Reasons</th>
				</tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all" id='deptLV'>
		    </tbody>
		</table>
		<div class="col-md-12">
		</div>
    </div>
</div>
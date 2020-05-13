<?php
/**
 * @Author: gian
 * @Date:   2016-04-04 08:47:36
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-04 08:49:11
 */
$this->load->view('admin/Schedule/Employee_Schedule/widget/dept_sched_menu/jscripts');
?>
<div class="box collapsed-box">
	<div class="box-header with-border">
		<h3 class="box-title">More Options</h3>
		<div class="pull-right box-tools">
	        <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
	      </div>
	</div>
	<div class="box-body">
		<div class="btn-group">
          <button type="button" class="btn btn-warning btn-flat revertToDeptBTN">Revert To Department's Schedule</button>
          <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#" class='revertAllFromDeptBtn'>Revert all employees of the same department</a></li>
            <li><a href="#" class='revertAllBtn' >Revert all employees schedule</a></li>
          </ul>
        </div>
	</div>
</div>
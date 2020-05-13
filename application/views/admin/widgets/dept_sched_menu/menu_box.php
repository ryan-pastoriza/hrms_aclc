<?php
/**
 * @Author: khrey
 * @Date:   2015-09-17 16:33:06
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-13 13:56:35
 */
?>
<script type="text/javascript">
  $(document).on('click','.revertToDeptBTN',function(r){
    var t = $(this);
    t.attr('disabled','disabled');
    $.ajax({
              type: "post",
              url:"<?= base_url('index.php/admin/employee_schedule/revert_to_department') ?>",
              data: "employee_id="+ empSelected,
              dataType: 'json',
            success: function(e){
              $('#notifications').html(e.view);
                if (e.success == true) {
                  refresh_schedule_list();
                }
                t.removeAttr('disabled');
          },
          })
    })
  $(document).on('click','.revertAllFromDeptBtn',function(r){
    $.ajax({
              type: "post",
              url:"<?= base_url('index.php/admin/employee_schedule/revert_entire_dept') ?>",
              data: "employee_id="+ empSelected,
              dataType: 'json',
            success: function(e){
              $('#notifications').html(e.view);
                if (e.success == true) {
                  refresh_schedule_list();
                }
                t.removeAttr('disabled');
          },
          })
    })
  $(document).on('click','.revertAllBtn',function(r){
     $.ajax({
              type: "post",
              url:"<?= base_url('index.php/admin/employee_schedule/revert_all') ?>",
              dataType: 'json',
            success: function(e){
              $('#notifications').html(e.view);
                if (e.success == true) {
                  refresh_schedule_list();
                }
                t.removeAttr('disabled');
          },
          })
    })
</script>
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
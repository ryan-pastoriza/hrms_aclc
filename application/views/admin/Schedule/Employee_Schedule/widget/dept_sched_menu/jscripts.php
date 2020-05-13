<?php
/**
 * @Author: gian
 * @Date:   2016-04-04 08:48:14
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-04 08:48:24
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
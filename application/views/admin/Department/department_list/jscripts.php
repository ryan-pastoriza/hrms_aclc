<?php
/**
 * @Author: gian
 * @Date:   2016-04-01 09:20:01
 * @Last Modified by:   Gian
 * @Last Modified time: 2017-06-30 10:37:20
 */
?>
<script type="text/javascript">
var options
var tableOptions
var deptsTable
var anotherOptions

$(function(){
  tableOptions = {
          "ajax": "<?= base_url() ?>index.php/admin/departments/departments_list",
            fnDrawCallback: function(){
              $('.deptName').editable(options);
              $('.deptHead').editable(anotherOptions);
            },
        }
       options = {
            url:"<?= base_url() ?>index.php/admin/departments/update_department",
            mode:"inline",
            ajaxOptions: {
                            dataType: 'json'
                        },
            success: function(r,nval){
                        if (r.success != true) {
                          toastr.error(r.Msg);
                          return false;
                        }else{
                          toastr.success(r.Msg)
                        }
                          },
            send: "always",
       };

      anotherOptions = {
         url:"<?= base_url() ?>index.php/admin/departments/update_dept_head",
         mode:"inline",
         source:"<?= base_url() ?>index.php/admin/departments/all_emp",
         ajaxOptions: {
                            dataType: 'json'
                        },
            success: function(r,nval){
                      // console.log(r)
                        if (r.success != true) {
                          toastr.error(r.Msg);
                          return false;
                        }else{
                          toastr.success(r.Msg)
                        }
                    },
            send: "always",
      };
   

  deptsTable = $("#example1").dataTable(tableOptions);
});

$(document).on('click','.deleteDepartment',function(e){
  var t = $(this);
  var parentButton = t.parent().parent().parent().find('button');
      parentButton.attr('disabled','disabled');
     $.ajax(
            {
              type: "post",
              url:"<?= base_url() ?>index.php/admin/departments/delete_department",
              data: "department_id="+ t.attr('department_id'),
              dataType: "json",
              success: function(r){
                if (r.success == true) {
                  toastr.success(r.Msg)
                  reload_departments();
                }else{
                  toastr.error(r.Msg)
                }
              },
            })
  e.preventDefault();
})

function reload_departments () {
  deptsTable.api().ajax.reload();
}

</script>
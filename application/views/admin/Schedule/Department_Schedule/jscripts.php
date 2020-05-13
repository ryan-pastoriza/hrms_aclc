  <style type="text/css">
  .loading{
    position: absolute;
    top:30%;
    background: #fff;
    width:97%;
    font-size: 2em;
    text-align: center;
    border-bottom: 3px solid #333;
    border-top: 3px solid #333;
  }
</style>
<script type="text/javascript">
  var editableOptions;
  var dataTableOptions;
  var deptSchedsDataTable;

  $(function(){
      $(".timepicker").timepicker({
            showInputs: false
          });
      dataTableOptions = {
              "ajax": {
                    "url": "<?= base_url() ?>index.php/admin/department_schedule/view_sched",
                    "data": function ( d ) { 
                          d.department_id =  $('#deptSelect').val();
                          }
                        ,
                    "type": "POST",
                  },
              fnDrawCallback: function(){
                $('.editable').editable(editableOptions);
          $("#schedTable").css({opacity:"1"});
          $(".loading").remove();
                  },
        }
       editableOptions = {
            url:"<?= base_url() ?>index.php/admin/department_schedule/update_schedule",
            mode:"inline",
            ajaxOptions: {
                            dataType: 'json'
                        },
            success: function(r,nval){
                        if (r.success != true) {
                          $('#notifications').append(r.view);
                          return false;
                        };
                          },
            send: "always",
                };
      deptSchedsDataTable = $("#schedTable").DataTable(dataTableOptions);
    });

  function refresh_schedule_list(){
    $("#schedTable").css({opacity:"0.5"});
    $("#schedTable").prepend("<div class='loading'>Loading...</div>");
      deptSchedsDataTable.ajax.reload();
    }
  $(document).on('change',"#deptSelect",function(){
      refresh_schedule_list();
  });
  $(document).on('click','.deleteDeptSched',function(){
    $.post("<?= base_url('admin/department_schedule/') ?>",values,function(r){
            // do something
            });
  })
  $(document).on('click','.deleteDepartment',function(){
    var ddsnfds_id = $(this).attr('ddsnfds_id');
    $.post("<?= base_url('index.php/admin/department_schedule/remove_sched') ?>","ddsnfds_id="+ddsnfds_id,function(r){
      refresh_schedule_list();      
    });
  })
   $(document).on('change','.scheduling input[type=checkbox]',function(){
          var t = $(this);
          if (t.prop('checked') == true) {
            t.parent().removeClass('btn-default');
            t.parent().addClass('btn-info');
          }else{
            t.parent().removeClass('btn-info');
            t.parent().addClass('btn-default');
          }
        })
</script>
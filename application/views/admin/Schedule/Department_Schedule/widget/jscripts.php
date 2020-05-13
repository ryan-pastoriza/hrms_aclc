<?php
/**
 * @Author: gian
 * @Date:   2016-04-01 11:50:01
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-01 15:25:12
 */
?>
<script>

  $(document).on('change','#deptSelect',function(){
      var t = $(this);
      $('#addDepartmentForm [name=department_id]').val(t.val());
    })
  $(function(){
    var newFormData;
    var options = {
          beforeSubmit: function(formData){
                          $('#submit').attr('disabled','disabled');
                          $('#submit').html('Setting Schedule. . .');
                        },
         success: function(e){
                        // $('#notifications').append(e.view);
                        var title = "Department Schedule Setting Failed.";

                        if (e.success == true) {
                          // $('#addDepartmentForm input').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                          title = "Department Schedule Set.";
                          refresh_schedule_list();
                        }
                        $.gritter.add({
                          // title: title,
                          text: e.view,
                          sticky:true,
                          // time:6000
                        });
                          $('#submit').removeAttr('disabled');
                          $('#submit').html('Set');
                        },
        dataType: "json"
      };
    $('#addDepartmentForm').ajaxForm(options);
  });

</script>
 <script>
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

<style type="text/css">
.scheduling input[type=checkbox]{
  display: none;
}
.scheduling {
  margin-left: 5%;
}
</style>
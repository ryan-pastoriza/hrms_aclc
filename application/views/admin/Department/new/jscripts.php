<?php
/**
 * @Author: gian
 * @Date:   2016-03-31 17:04:23
 * @Last Modified by:   gian
 * @Last Modified time: 2016-03-31 17:04:35
 */
?>
<script>
$(function(){
  var newFormData;
  var options = {
         // target: '#notifications',   // target element(s) to be updated with server response 
        beforeSubmit: function(formData){
                                  $('#submit').attr('disabled','disabled');
                                  $('#submit').html('Adding');
                              },  // pre-submit callback 
       success: function(e){
                      $('#notifications').append(e.view);
                      if (e.success == true) {
                        $('#addDepartment input').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                      };
                                      $('#submit').removeAttr('disabled');
                                      $('#submit').html('Add');
                                      reload_departments();
                                    },
      dataType: "json"
    };
  $('#addDepartment').ajaxForm(options);
});
</script>
  <style type="text/css">
    .form-inline .form-group{
    margin-left: 0 !important;
    margin-right: 0 !important;
    }
  </style>
        <!-- Content Header (Page header) -->
  
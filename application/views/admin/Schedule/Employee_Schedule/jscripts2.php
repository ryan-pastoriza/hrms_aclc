<?php
/**
 * @Author: gian
 * @Date:   2016-04-01 15:52:52
 * @Last Modified by:   Gian
 * @Last Modified time: 2019-07-22 15:04:00
 */
?>
<script>
var dataTableOptions;
var empSchedsDataTablel
var empSelected;

$(function(){
  var newFormData;
  
  var autocomp;
  var tautocomplete = {
                        columns: ['Name','Age','Department','Status'],
                        norecord: "No Records Found",
                        placeholder:"Select Employee",
                        theme: "white",
                        regex: "^[a-zA-Z0-9\b \, \s]+$",
                        onchange: function(){
                          empSelected = autocomp.id();
                          refresh_schedule_list();
                        },
                        data: function () {
                              var data = <?= $allEmps ?>;

                              var filterData = [];

                              var searchData = eval("/" + autocomp.searchdata() + "/gi");

                              $.each(data, function (i, v) {
                                  if (v.fullName.search(new RegExp(searchData)) != -1) {
                                      filterData.push(v);
                                  }
                              });
                              return filterData;
                          }
                      };

  autocomp = $('#searchEmp').tautocomplete(tautocomplete);
  $(".timepicker").timepicker({
            showInputs: false
          });
})
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
        $(document).on('click','.deleteEmpSched',function(r){
          var id = $(this).attr('table_id');
          var table = $(this).attr('table');
          var emp_id = $(this).attr('employee_id');
          $.post("<?= base_url('index.php/admin/employee_schedule/remove_sched') ?>","table_id=" + id+"&table="+table+"&emp_id="+emp_id,function(r){
            refresh_schedule_list();
          });
        })
        $(document).on('click','#setSchedForm [type=submit]',function(r){
          alert();
          var btn = $(this);

          var options = {
          data: {employee_id: empSelected },
                        beforeSubmit: function(formData){
                                                  $('#submit').attr('disabled','disabled');
                                                  $('#submit').html('Adding');
                                              },  // pre-submit callback 
                       success: function(e){

                                    $('#submit').removeAttr('disabled');
                                    $('#submit').html('<i class="fa fa-plus"></i>Set');

                                    if (e.success == true) {
                                      $.gritter.add({
                                                    // title: "Schedule Set!",
                                                    text: e.view,
                                                    // class_name:"bg-green",
                                                    sticky:false,
                                                    time:6000
                                                  });
                                      refresh_schedule_list();
                                    }
                                    else{
                                        $.gritter.add({
                                                    // title       : "Schedule Not Set.",
                                                    text        : e.view,
                                                    // class_name  :"bg-red",
                                                    sticky      :false,
                                                    time        :6000
                                                  });
                                    }




                                      $('#notifications').append(e.view);
                                                      
                                                      if (e.success == true) {
                                                      }
                                                    },
                      dataType: "json"
                  };
            $('#setSchedForm').ajaxForm(options);
            $('#setSchedForm').trigger('submit');

            r.preventDefault();
        })
        $(document).on('click','.overrideBTN', function(){
          var btn = $(this);
          var options = {
                url: "<?= base_url('index.php/admin/employee_schedule/override_sched') ?>",
                 data: {employee_id: empSelected },
                success: function(e){
                  $.gritter.add({
                          // title: title,
                          text: e.view,
                          sticky:true,
                          // time:6000
                        });
                                        $('#submit').removeAttr('disabled');
                                        $('#submit').html('<i class="fa fa-plus"></i>Set');
                                        if (e.success == true) {
                                          refresh_schedule_list();
                                        };
                                        btn.parent().find('.close').trigger('click');
                              $.gritter.removeAll();
                                      },
                 dataType: "json"
              };
          
          $('#setSchedForm').ajaxForm(options);
          $('#setSchedForm').trigger('submit');
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
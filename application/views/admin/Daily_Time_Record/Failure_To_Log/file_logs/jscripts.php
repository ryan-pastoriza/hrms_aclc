<script type="text/javascript">
  var autocomp;
  var selectedName;
  

  $(function(){
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(moment().subtract(29, 'days'), moment());
    $('#reportrange').daterangepicker({
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    <?php if($this->userInfo->user_privilege == "admin"): ?>
      var tautocomplete = {
                             columns: ['Name','Department'],
                             norecord: "No Records Found",
                             placeholder:"Type Employee Name",
                             theme: "white",
                             regex: "^[a-zA-Z0-9\b \, \s]+$",
                             onchange: function(){
                              $('#position').val(tautocomplete.position());
                              $('#department').val(tautocomplete.department());
                              empSelected = autocomp.id();
                              selectedName = autocomp.text(); 
                              $('#empId').val(empSelected);
                              
                            },
                            department : function(){
                              return tautocomplete.data()[0].department;
                            },
                            position : function(){
                              return tautocomplete.data()[0].position;
                            },
                            data: function () {
                                  var data = <?= $empData ?>;

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
      autocomp = $('#empSearch').tautocomplete(tautocomplete);
      <?php endif; ?>


    $(document).on('change','#in',function(e){
      if ($(this).prop('checked')) {
          $('#inForm').show();

          $(".timepicker1").timepicker({
            showInputs: false
          });

          $(".timepicker1").val('');
      }else{

          $('#inForm').hide();
      }
    });

    $(document).on('change','#out',function(e){
      if ($(this).prop('checked')) {
          $('#outForm').show();

          $(".timepicker2").timepicker({
             showInputs: false
          });

          $(".timepicker2").val('');
      }else{
          $('#outForm').hide();
      }
    });
  });
  $(document).on('change','#log-date',function(){
    var val = $(this).val();
   
      <?php if($this->userInfo->user_privilege == 'admin'): ?>
         if (empSelected == "" || typeof empSelected == "undefined") {
            $('[sched-view]').html("<div class=\"alert alert-danger alert-dismissible\">\
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>\
                                    <h4><i class=\"icon fa fa-ban\"></i> Error!</h4>\
                                    Please specify the employee name.\
                                  </div>");
          }
          else{
            $('[sched-view]').html("<em class='text-info'> Fetching Attendance Information on "+val+" . . . </em>");
            $.post("<?= base_url('index.php/admin/failure_to_log/fetch_attendance') ?>","date="+val+"&emp_id="+empSelected,function(r){
                $('[sched-view]').html(r);
              })
          }
      <?php else: ?>
        $.post("<?= base_url('index.php/employee/failure_to_log/fetch_attendance') ?>","date="+val+"&emp_id="+empSelected,function(r){
          $('[sched-view]').html(r);
        })
      <?php endif ?>
  });
  $("#failureForm").bind("reset", function() {
    $('#inForm').hide();
    $('#outForm').hide();
  });
  $(document).on('click','[delete-efl]',function(){
    var efl_id = $(this).attr('delete-efl');
    
    $.post("<?= base_url('index.php/admin/failure_to_log/delete_flr')  ?>","id="+efl_id,function(r){
        ftl_table.ajax.reload();
      })
  });
 
</script>
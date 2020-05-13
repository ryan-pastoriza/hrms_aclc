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
  $("#failureForm").bind("reset", function() {
    $('#inForm').hide();
    $('#outForm').hide();
  });
 
</script>
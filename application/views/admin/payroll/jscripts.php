<script type="text/javascript">
  var autocomp;
  var empSelected;
  var tab;
  var selectedName;
  var tautocomplete;
  var dateLabel = moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY');
  $(function(){
    $('#dateRange').val(dateLabel);
    $('[name=cut_off_start]').val(moment().subtract('days', 29).format('YYYY-MM-DD'));
    $('[name=cut_off_end]').val(moment().format('YYYY-MM-DD'));

    $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#daterange-btn').daterangepicker(
      {
        ranges: {
          'Today':        [moment(), moment()],
          'Yesterday':    [moment().subtract('days', 1), moment().subtract('days', 1)],
          'Last 7 Days':  [moment().subtract('days', 6), moment()],
          'Last 30 Days': [moment().subtract('days', 29), moment()],
          'This Month':   [moment().startOf('month'), moment().endOf('month')],
          'Last Month':   [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        startDate: moment().subtract('days', 29),
        endDate: moment(),
      },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          dateLabel = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY');
          $('[name=cut_off_start]').val(start.format('YYYY-MM-DD'));
          $('[name=cut_off_end]').val(end.format('YYYY-MM-DD'));

           // $('#dateRange').val(dateLabel);

        }
    )    

      tautocomplete = {
        columns: ['Name','Department'],
        norecord: "No Records Found",
        placeholder:"Type Employee Name",
        theme: "white",
        regex: "^[a-zA-Z0-9\b \, \s]+$",
        onchange: function(){
          empSelected = autocomp.id();
          selectedName = autocomp.text();
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


  });

  $(document).on('change','#month-selector, #date-selector, #year-selector',function(){
    var month = $('#month-selector').val();
    var date = $('#date-selector').val();
    var year = $('#year-selector').val();

    $('[payroll-rec-view]').html("<center><h3><i class='fa fa-spinner fa-spin'></i> <em> &nbsp; Fetching Payroll Record . . .</em> </h3></center>")

    $.post("<?= base_url('index.php/admin/payroll/payroll_record_view') ?>","month="+month+"&date="+date+"&year="+year,function(r){
        $('[payroll-rec-view]').html(r);
      })

  });
  $(document).on('click','#add-adjustment-btn',function(){
    var amt       = $(this).closest('.row').find('#adjustment-amt').val();
    var parent    = $(this).closest('.row');
    var adj_name  = $(this).closest('.row').find('[name=adjustment_name]').val();

    if (amt != "" && empSelected != "") {
      var inputWidth = selectedName.length + 1;
      parent.append("<div class='col-sm-4'> \
                          <input type='text' readonly value='"+selectedName+"' style='border:none;background:#eee;padding:3px;width:100%'> \
                        </div> \
                        <div class='col-sm-4'> \
                            <input type='text' name='adjustments["+empSelected+"][name][]' value='"+adj_name+"' class='form-control'> \
                        </div> \
                        <div class='col-sm-3'> \
                            <input type='number' name='adjustments["+empSelected+"][amount][]' value='"+amt+"' class='form-control'> \
                        </div> \
                        <div class='col-sm-1'> \
                            <a href='#' remove-btn ><i class='text-red fa fa-minus'></i></a> \
                        </div> ");
      onkeypress="this.style.width = ((this.value.length + 1) * 8) + 'px';"

      parent.find('[autocomplete]').val('').focus();
      parent.find('#adjustment-amt').val('');

      return false
    }
  });
  $(document).on('click','[remove-btn]',function(){
    $(this).parents('[adjustment]').remove();
  });


  var appendSelected = function(){
    $('#genPayroll #selectedEmps').html('');

    $.each(emp_selector_tblselected,function(k,v){
      $('#genPayroll #selectedEmps').append('<input type="hidden" name="emps[]" value="'+v+'">');
    })
  }
  
</script>
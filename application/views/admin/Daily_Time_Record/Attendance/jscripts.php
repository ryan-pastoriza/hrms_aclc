<script type="text/javascript">
var autocomp;
var empSelected;
var tab;
var selectedName;
var dateLabel = moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY');
var startDate = moment().subtract('days', 29).format('YYYY-MM-DD');
var endDate = moment().format('YYYY-MM-DD');
  
  $(document).ready(function() {
    <?php
      if ($this->userInfo->user_privilege != "admin") {
        echo "empSelected = '{$this->userInfo->employee_id}';
            set_header();
            // alert('asdasdas');
          ";

      }
    ?>

  $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
  $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  startDate: moment().subtract('days', 29),
                  endDate: moment(),
                },
          function (start, end) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');

            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            dateLabel = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY');
            set_header();
            // tab.ajax.reload();
          }
        )
<?php if($this->userInfo->user_privilege == "admin"): ?>
    var tautocomplete = {
                        columns: ['Name','Department'],
                        norecord: "No Records Found",
                        placeholder:"Type Employee Name",
                        theme: "white",
                        regex: "^[a-zA-Z0-9\b \, \s]+$",
                        onchange: function(){
                          empSelected   = autocomp.id();
                          selectedName  = autocomp.text();
                          if (autocomp.text() != "") {
                              set_header();
                          }
                          // display_log();
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
   
  });

$(document).on('click','[clear-log]',function(){
  var logType = $(this).attr('log-type');
  var logId = $(this).attr('clear-log');
  $.post("<?= base_url('index.php/admin/daily_time_record/clear_log') ?>","log_type="+logType+"&log_id="+logId,function(r){
      set_header();
  })
  return false;
});

$(document).on('click','[clear-ot-log]',function(){
    var logType = $(this).attr('log-type');
    var otId = $(this).attr('clear-ot-log');
    $.post("<?= base_url('index.php/admin/daily_time_record/clear_ot_log') ?>","log_type="+logType+"&ot_id="+otId,function(r){
        set_header();
    })

});


function init_tbl() {
  
  tabl = $('#dtr').DataTable({
      dom: 'Bfrtip',
      buttons:[/*'copyHtml5',*/
                  {
                    extend: 'excelHtml5',
                  },
                  {
                    extend: 'print',
                    customize: function(o){
                        var bod = o.document.body;
                        var theTable = $(bod).find('table');
                        var p2;
                        $(bod).find('h1').after("<div class='heading'><span style='min-width:40%;margin-right:1%;display:inline-block;float:left'> No. <u>"+ empSelected +"</u> </span> \
                                                <span style='min-width:55%;display:inline-block;float:left;text-align:right'> Pay Ending <span style='min-width:54.5%;display:inline-block;border-bottom:1px solid #000'>&nbsp</span></span><br> \
                                                <span style='min-width:50%; display:inline-block;float:left'>Name <span style='min-width:45%;display:inline-block;border-bottom:1px solid #000'>"+ selectedName +"</span> </span> \
                                                <span style='min-width:45%; display:inline-block;float:left;text-align:right'>Position <span style='min-width:50%;display:inline-block;border-bottom:1px solid #000'>&nbsp;&nbsp;</span></span>\
                                                <span style='min-width:65%; display:inline-block;float:left'>Dept. <span style='min-width:60%;display:inline-block;border-bottom:1px solid #000'></span> </span> \
                                                <span style='min-width:35%; display:inline-block;float:left;text-align:right'>Age <span style='min-width:60%;display:inline-block;border-bottom:1px solid #000'></span> </span></div>"/*+dateLabel*/);
                        
                        var header = "<table class='added' style='border:1px solid #000;border-top-width:2px;border-bottom:0'> \
                                                        <tr><td width='60%'>\
                                                          <table> \
                                                          <tr> \
                                                            <th colspan='2' style='padding:2px;border-right:1px solid #000;font-size:0.7em;text-align:center'>Hours</th> \
                                                            <th style='padding:2px;font-size:0.7em;border-right:3px double #000'>Rate</th> \
                                                            <th style='padding:2px;font-size:0.7em;border-right:2px double #000'>Amount</th> \
                                                            <td rowspan='7' style='max-width:30px !important;font-size:0.7em;text-align:center;white-space:nowrap;transform-origin:100% 60%;transform: rotate(270deg);'>DEDUCTIONS</td>\
                                                            <th colspan='2' style='text-align:center;min-width:100px;font-size:0.7em; border:1px solid #000;border-left:2px solid #000;border-top:0;'>ABSENCES</th>\
                                                            <td style='min-width:20px;border:1px solid #000;font-size:0.7em;border-right:0;border-top:0;'>&nbsp;</td>\
                                                          </tr> \
                                                          <tr> \
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0' width='50%'>Reg.</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0' width='50%'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px double #000;border-left:0;border-right:3px double #000'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-right:2px solid'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-right:0'>Fines</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;min-width:50px'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                          </tr>\
                                                          <tr> \
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-bottom:3px double #000' width='50%'>Over.</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-bottom:3px double #000' width='50%'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-bottom:3px double #000;border-right:3px double #000'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-bottom:3px double #000;border-right:2px solid #000'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-right:0;font-size:.6em'>Withholding Tax</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                          </tr>\
                                                          <tr> \
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-bottom:0;' width='50%'>&nbsp;</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-bottom:0;' width='50%'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-bottom:0;border-right:3px double'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-bottom:0;border-right:2px solid #000'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-right:0'>S.S.S.</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                          </tr>\
                                                          <tr> \
                                                              <td colspan='3' style='padding:2px;font-size:0.7em;border:3px double #000;border-left:0' width='50%'>Total Earnings</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:3px double #000;border-left:0;border-right:2px solid #000' width='50%'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-right:0'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                          </tr>\
                                                          <tr> \
                                                              <td colspan='3' style='padding:2px;font-size:0.7em;border:3px double #000;border-left:0' width='50%'>Less Deductions</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:3px double #000;border-right:2px solid #000;border-left:0' width='50%'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-right:0'>.</td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                              <td style='padding:2px;font-size:0.7em;border:1px solid #000;'></td>\
                                                          </tr>\
                                                          <tr> \
                                                              <th colspan='3' style='padding:2px;font-size:0.7em;border-right:3px double #000' width='50%'>NET PAY</th>\
                                                              <td style='padding:2px;font-size:0.7em;border-right:2px solid #000' width='50%'></td>\
                                                              <td colspan='3' style='padding:2px;font-size:0.7em;border:1px solid #000;border-left:0;border-top:3px double #000;border-right:0;border-bottom:0'>TOTAL</td>\
                                                          </tr>\
                                                          </table> \
                                                        </td>\
                                                        </tr>\
                                                      </table>";
                        $(bod).find('table').before(header);
                        if ($(bod).find('table.dataTable tr').length > 15) {
                            p2 = $(bod).find('table.dataTable tr:nth-child(n+50)')                 
                        };
                        
                        $(bod).wrapInner('<div class="wrapper" />');
                        theTable.after("<div class='theFoot'>I hereby certify that the above records are true and correct.<br><br><br><br> \
                                          <div style='float:right;margin-right:5px;'> \
                                            <span style='width:1.7in;border-top:1px solid #000;display:block'>\
                                              <center>EMPLOYEE'S SIGNATURE</center>\
                                            </span>\
                                            <br>\
                                          </div>\
                                          </div>");
                    }
                  }
              ],
      fnDrawCallback: function(){
        <?php if($this->userInfo->user_privilege == 'admin'){ ?>
         $('.ot-log-editable').editable({
            'mode':'inline',
            'type':"time",
            'url' : "<?= base_url('index.php/admin/daily_time_record/set_ot_log') ?>",
            params :function(params){
                params.emp_ot_id = $(this).attr('emp-ot-id');
                params.log_type  = $(this).attr('log-type');

                return params;
            },
            success: function(r){
                set_header();
            },
            send: "always"
        })

        $('.log-editable').editable({
          'mode' : 'inline',
          'type' : "time",
          'url'  : "<?= base_url('index.php/admin/daily_time_record/set_log') ?>",
          params: function (params) {
              params.date = $(this).attr('data-date');
              params.has_log = $(this).attr('data-has_log');
              params.employee_id = empSelected;
              params.emp_log_sched_type = $(this).attr('data-emp_log_sched_type');
            return params;
          },
          success: function(r){
            set_header();
          },
          send: "always"
        });
        <?php } ?>
       
      },
      paging: false,

   });
}
function set_header() {
  $('#dtr').css({border:'none'});
  $('#dtr').html("<h2 class='disabled'><i class='fa fa-gear fa-spin'></i> <small><em>Fetching Attendance Data . . . </em></small></h2>");
$.post("<?= $this->userInfo->user_privilege == "admin" ? base_url('index.php/admin/daily_time_record/dtr_header') : base_url('index.php/employee/dtr/dtr_header'); ?>","employee_id="+empSelected+"&fromDate="+startDate+"&toDate="+endDate,function(r){
    if (typeof(tabl) !== "undefined") {
      $('#dtr').DataTable().destroy();
    }
      $('#dtr').html(r);
      init_tbl();
    })
}
function display_log(){
      tab.ajax.reload(function(r){
        if (r.data.length > 0) {
          if(r.data[0][0] == '<span class="text-red">DTR Report Limit</span>'){
            $('#myModal').modal();
          }
        }
      });
}
</script>
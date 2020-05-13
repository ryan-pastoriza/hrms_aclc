<?php
/**
 * @Author: gian
 * @Date:   2015-11-03 10:53:51
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-19 13:44:13
 */
?>
<script type="text/javascript" src="<?= base_url();?>assets/momentjs/moment.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
  /* initialize the external events
   -----------------------------------------------------------------*/
  function ini_events(ele) {
    ele.each(function () {

      // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
      // it doesn't need to have a start or end
      var eventObject = {
        title: $.trim($(this).text()) // use the element's text as the event title
      };

      // store the Event Object in the DOM element so we can get to it later
      $(this).data('eventObject', eventObject);

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 1070,
        revert: true, // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
      });

    });
  }
  ini_events($('#external-events div.external-event'));

  /* initialize the calendar
   -----------------------------------------------------------------*/
  //Date for the calendar events (dummy data)
  // var date = new Date();
  // var d = date.getDate(),
  //         m = date.getMonth(),
  //         y = date.getFullYear();
    $('#myCalendar').fullCalendar({
      header: {
        left:   'prev,next today',
        center: 'title',
        right:  'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      dayClick: function(date,jsEvent,view){
        var now = new moment();
        var time = now.format("hh:mm A");
        var dateS = date;
        var formatedDate = dateS.format("YYYY-MM-DD");
        var d = $('#ModalfromDate').val(formatedDate +" "+ time);
        // var d = $('#fromDate').val();
        if(d != ""){
          dateToWord(new Date(d));
        }
        $("#add_event_modal").modal('show');
      },
      eventClick: function(event) {
        // alert(event.event_id);
        $.post("<?= base_url('index.php/admin/my_calendar/event_info'); ?>","id="+event.event_id,function(data){
          $('#event_title').val(data.title);
          $('#eventFromDate').val(twelveHourFormat(data.fromDate));
          if(data.toDate != null){
            $('#eventEndLabel').html('Event End Date');
            $('#eventToDate').val(twelveHourFormat(data.toDate));

          }else{
            // $('#eventEnd').hide();
            $('#eventEndLabel').html('');
            $('#eventToDate').val('Every '+ data.type);
          }
          
          $('#eventType').val(data.type_name);
          $('#eventDescription').val(data.description);
        },'json');
        $('#event_information').modal('show');
      },
      //Random default events
      events:"<?= base_url('index.php/admin/my_calendar/show_all_events'); ?>"
    });
$(".my-colorpicker1").colorpicker();
$(".my-colorpicker2").colorpicker();

  function twelveHourFormat(date){
    var d = new Date(date);
    var hh = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var dd = "AM";
    var h = hh;
    if(h >= 12){
      h = hh-12;
      dd = "PM";
    }
    if(h == 0){
      h = 12;
    }

    m = m < 10 ? "0"+m:m;
    s = s < 10 ? "0"+s:s;

    /* if you want 2 digit hours:
      h = h<10?"0"+h:h; */

    var pattern = new RegExp("0?"+hh+":"+m+":"+s);
    var replacement = h+":"+m;
    /* if you want to add seconds
    replacement += ":"+s;  */
    replacement += " "+dd;    

    return date.replace(pattern,replacement);
  }
});
</script>
<section class="content-header">
  <h1>
    Calendar
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Calendar</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-4">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h4 class="box-title">Add Events, Holidays</h4>
        </div>
        <div class="box-body">
          <?php
            $this->load->view('admin/widgets/event_calendar/event_form');
          ?>
        </div>
      </div>
    </div><!-- /.col -->
    
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-body no-padding">
          <!-- THE CALENDAR -->
          <div id="myCalendar"></div>
        </div><!-- /.box-body -->
      </div><!-- /. box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<!-- form modal -->
<div class="modal fade" id="add_event_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Events, Holidays</h4>
      </div>
      <div class="modal-body">
        <?php
          $this->load->view('admin/widgets/event_calendar/event_modal');
        ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- end form modal-->
<div class="modal fade modal-primary" id="event_information">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Event &amp; Holiday</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="row">
            <div class="col-sm-12">

              <div class="form-group">
                <label class="col-sm-3 control-label" style="font-size:12px;text-align:left;">
                  Title
                </label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="event_title" style="border:none;background-color:#FFF;" readonly/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" style="font-size:12px;text-align:left;">
                  Event Start Date
                </label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="eventFromDate" style="border:none;background-color:#FFF;" readonly/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" style="font-size:12px;text-align:left;" id="eventEndLabel">
                  Event End Date
                </label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="eventToDate" style="border:none;background-color:#FFF;" readonly/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" style="font-size:12px;text-align:left;">
                  Description
                </label>
                <div class="col-sm-9">
                  <textarea class="form-control pull-right" id="eventDescription" style="resize:none;background-color:#FFF;border:none;" readonly></textarea>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>


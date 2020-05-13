<?php
/**
 * @Author: gian
 * @Date:   2015-11-17 10:36:46
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-15 11:38:17
 */
?>
<script>

  $(function(){
    //radio button
    $('input#dynamic').change(function(){
      if($(this).prop("checked")){
        $('#dynamic-text').show();
        $('input#dynamic').val("dynamic");
        $('input#fixed').removeAttr("checked");
        $('input#dynamic').attr("checked","checked");
        $('#toD').fadeOut();
      }
    });
    $('input#fixed').change(function(){
      if($(this).prop("checked")){
        $('#dynamic-text').hide();
        $('#date_number').val("");
        $('#date_day').val("");
        $('#date_month').val("");
        $('input#dynamic').removeAttr("checked");
        $('input#fixed').attr("checked","checked");
        $('#toD').fadeIn();
      }
    });
    
    $('#pay').change(function(){
      if($(this).prop("checked")){
        $('#pay').val(1);
        $('#pay').attr('checked','checked');
      }else{
         $('#pay').val(0);
         $('#pay').removeAttr("checked");
      }
    });
    $('#work').change(function(){
      if($(this).prop("checked")){
        $('#work').val(1);
        $('#work').attr('checked','checked');
      }else{
         $('#work').removeAttr("checked");
         $('#work').val(0);
      }
    });
    $('#datetimepicker1').datetimepicker({
      format: 'YYYY-MM-DD hh:mm A'
    });
    $('#datetimepicker2').datetimepicker({
      format: 'YYYY-MM-DD hh:mm A'
    });
    
    $(document).click(function(){
      var d =  $('#fromDate').val();
      if(d != ""){
        dateToWord(new Date(d));
      }
    });
  });

  $(function(){
    var newFormData;
    var options = {
      beforeSubmit: function(formData){
        $('#submit').attr('disabled','disabled');
        $('#submit').html('Submitting');
      },
      success: function(e){
        $('#notifications').append(e.view);
        if(e.success == true){
          $('#addNewEvent input').not(':button, :submit, :reset, :hidden').val('');
          $('#addNewEvent textarea').not(':button, :submit, :reset, :hidden').val('');
          $('#myCalendar').fullCalendar('addEventSource',"<?= base_url('index.php/admin/my_calendar/event_last_input_id'); ?>");
        }
          $('input#fixed').trigger('click');
          $('input#fixed').val("fixed");
          $('#pay').trigger('click');
          $('#work').trigger('click');
          $('#pay').prop('checked',true);
          $('#work').prop('checked',true);
          $('#submit').removeAttr('disabled');
          $('#submit').html('Add Event');
      },
      dataType: 'json',
    }
    $('#addNewEvent').ajaxForm(options);
  });

  function dateToWord(d){
    var dateNum = ['1st','2nd','3rd','4th','5th'],
        dateDays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
        dateMonth = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    return $('#date_number').val(dateNum[Math.floor(d.getDate()/7.2)])+''+$('#date_day').val(dateDays[d.getDay()])+''+$('#date_month').val(dateMonth[d.getMonth()]);
  }
</script>
<?php echo form_open_multipart('admin/my_calendar/add_event',array('id'=>'addNewEvent' , 'class' => 'form-horizontal', 'data-toggle' => "validator")) ?>
    <div class="row">
      <div class="col-sm-12">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;">Title</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" placeholder="eg. Christmas party !" name="title" required>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;">From Date</label>
          <div class="col-sm-9">
            <div class="input-group date" id='datetimepicker1'>
              <input type="text" class="form-control" id="fromDate" name="fromDate" required>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>

        <div class="form-group" id="toD">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;" >To Date</label>
          <div class="col-sm-9">
            <div class="input-group date" id='datetimepicker2'>
              <input type="text" class="form-control" id="toDate" name="toDate">
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <input type="radio" id="fixed" name="check" value="Fixed" checked >Fixed &nbsp;&nbsp;
            <input type="radio" id="dynamic" name="check" value="dynamic" >Dynamic
          </div>
        </div>

        <div class="form-group" id="dynamic-text" hidden>
          <div class="col-sm-12">
            <div class="col-sm-3">
              <input type="text" class="form-control" id="date_number" name="dateNum" placeholder="eg. 1st">
            </div>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="date_day" name="dateDay" placeholder="eg. Sunday">
            </div>
            <label class="col-sm-1 control-label" style="font-size:12px;text-align:left;">of</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="date_month" name="dateMonth" placeholder="eg. November">
            </div>
          </div>
        </div> 

        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="pay" id="pay" checked="checked" value="1">Pay
              </label>
              <label>
                <input type="checkbox" name="work" id="work" checked="checked" value="1">Work
              </label>
            </div>
          </div>
        </div> 

        <div class="form-group">
          <label class="col-sm-3 control-label" style="font-size:12px;text-align:left;">Color</label>
          <div class="col-sm-9">
            <div class="input-group my-colorpicker1">
              <input type="text" class="form-control" name="backgroundColor"/>
              <div class="input-group-addon">
                <i></i>
              </div>
            </div><!-- /.input group -->
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;">Description</label>
          <div class="col-sm-9">
            <textarea class="form-control" placeholder="eg. This is a holiday !" style="resize:none;" name="description"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button class="btn btn-primary pull-right" id='submit' data-disable="true">Add Event</button>
          </div>
        </div>
      </div>
    </div>
</form>
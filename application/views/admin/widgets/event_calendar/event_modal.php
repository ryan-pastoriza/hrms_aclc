<?php
/**
 * @Author: gian
 * @Date:   2015-11-17 11:03:18
 * @Last Modified by:   gian
 * @Last Modified time: 2015-11-23 14:44:45
 */
?>
<script>

  $(function(){
    //radio button
    $('#Modalpay').val(1);
    $('#Modalwork').val(1);

    $('input#Modaldynamic').change(function(){
      if($(this).prop("checked")){
        $('#Modaldynamic-text').show();
        $('input#Modaldynamic').val("dynamic");
        $('input#Modalfixed').removeAttr("checked");
        $('input#Modaldynamic').attr("checked","checked");
        $('#ModaltoD').fadeOut();
      }
    });
    $('input#Modalfixed').change(function(){
      if($(this).prop("checked")){
        $('#Modaldynamic-text').hide();
        $('#Modaldate_number').val("");
        $('#Modaldate_day').val("");
        $('#Modaldate_month').val("");
        $('input#Modaldynamic').removeAttr("checked");
        $('input#ModalFixed').attr("checked","checked");
        $('#ModaltoD').fadeIn();
      }
    });
    $('#Modalpay').click(function(){
      if($(this).prop("checked")){
        $('#Modalpay').val(1);
         $('#Modalpay').attr('checked','checked');
      }else{
         $('#Modalpay').val(0);
          $('#Modalpay').removeAttr("checked");
      }
    });
    $('#Modalwork').click(function(){
      if($(this).prop("checked")){
        $('#Modalwork').val(1);
        $('#Modalwork').attr('checked','checked');
      }else{
         $('#Modalwork').val(0);
         $('#Modalwork').removeAttr('checked');
      }
    });
    $('#datetimepicker3').datetimepicker({
      format: 'YYYY-MM-DD hh:mm A'
    });
    $('#datetimepicker4').datetimepicker({
      format: 'YYYY-MM-DD hh:mm A'
    });
    
    $(document).click(function(){
      var d =  $('#ModalfromDate').val();
      if(d != ""){
        dateToWordModal(new Date(d));
      }
    });
  });

  $(function(){
    var newFormData;
    var options2 = {
      beforeSubmit: function(formData){
        $('#Modalsubmit').attr('disabled','disabled');
        $('#Modalsubmit').html('Submitting');
      },
      success: function(e){
        $('#notifications').append(e.view);
        if(e.success == true){
          $('#addNewEventModal input').not(':button, :submit, :reset, :hidden').val('');
          $('#addNewEventModal textarea').not(':button, :submit, :reset, :hidden').val('');
          $('#myCalendar').fullCalendar('addEventSource',"<?= base_url('index.php/admin/my_calendar/event_last_input_id'); ?>");
       	}
          $('input#Modalfixed').trigger("click");
          $('input#Modalfixed').val("fixed");
          $('#Modalpay').trigger('click');
		  $('#Modalwork').trigger('click');
          $('#Modalpay').prop('checked',true);
          $('#Modalwork').prop('checked',true);
          $('#Modalsubmit').removeAttr('disabled');
          $('#Modalsubmit').html('Add Event');
      },
      dataType: 'json',
    }
    $('#addNewEventModal').ajaxForm(options2);
  });

  function dateToWordModal(d){
    var dateNum = ['1st','2nd','3rd','4th','5th'],
        dateDays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
        dateMonth = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    return $('#Modaldate_number').val(dateNum[Math.floor(d.getDate()/7.2)])+''+$('#Modaldate_day').val(dateDays[d.getDay()])+''+$('#Modaldate_month').val(dateMonth[d.getMonth()]);
  }
</script>
<?php echo form_open_multipart('admin/my_calendar/add_event_modal',array('id'=>'addNewEventModal' , 'class' => 'form-horizontal', 'data-toggle' => "validator")) ?>
    <div class="row">
      <div class="col-sm-12">

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;">Title</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" placeholder="eg. Christmas party !" name="Modaltitle" required>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;">From Date</label>
          <div class="col-sm-9">
            <div class="input-group date" id='datetimepicker3'>
              <input type="text" class="form-control" id="ModalfromDate" name="ModalfromDate" required>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>

        <div class="form-group" id="ModaltoD">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;" >To Date</label>
          <div class="col-sm-9">
            <div class="input-group date" id='datetimepicker4'>
              <input type="text" class="form-control" id="ModaltoDate" name="ModaltoDate">
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <input type="radio" id="Modalfixed" name="Modalcheck" value="Fixed" checked >Fixed &nbsp;&nbsp;
            <input type="radio" id="Modaldynamic" name="Modalcheck" value="dynamic" >Dynamic
          </div>
        </div>

        <div class="form-group" id="Modaldynamic-text" hidden>
          <div class="col-sm-12">
            <div class="col-sm-3">
              <input type="text" class="form-control" id="Modaldate_number" name="ModaldateNum" placeholder="eg. 1st">
            </div>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="Modaldate_day" name="ModaldateDay" placeholder="eg. Sunday">
            </div>
            <label class="col-sm-1 control-label" style="font-size:12px;text-align:left;">of</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="Modaldate_month" name="ModaldateMonth" placeholder="eg. November">
            </div>
          </div>
        </div> 

        <div class="form-group">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="Modalpay" id="Modalpay" checked="checked">Pay
              </label>
              <label>
                <input type="checkbox" name="Modalwork" id="Modalwork" checked="checked">Work
              </label>
            </div>
          </div>
        </div> 

        <div class="form-group">
          <label class="col-sm-3 control-label" style="font-size:12px;text-align:left;">Color</label>
          <div class="col-sm-9">
            <div class="input-group my-colorpicker2">
              <input type="text" class="form-control" name="ModalbackgroundColor"/>
              <div class="input-group-addon">
                <i></i>
              </div>
            </div><!-- /.input group -->
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label" style="font-size:12px;text-align:left;">Description</label>
          <div class="col-sm-9">
            <textarea class="form-control" placeholder="eg. This is a holiday !" style="resize:none;" name="Modaldescription"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button class="btn btn-primary pull-right" id='Modalsubmit' data-disable="true">Add Event</button>
          </div>
        </div>

      </div>
    </div>
</form>
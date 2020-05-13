<script>
$(function(){
  // $.ajaxSetup({
  //     data: {
  //         csrf_test_name: $.cookie('csrf_cookie_name')
  //     }
  // });
  var newFormData;
  var options = { 
        // target: '#notifications',   // target element(s) to be updated with server response 
        beforeSubmit: function(formData){
                                  $('#submit').attr('disabled','disabled');
                                  $('#submit').html('Submitting');
                              },  // pre-submit callback 
        success: function(e){
                $('#notifications').append(e.view);
                if (e.success == true) {
                  $('#addNewForm input').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                };
                                $('.img-prev').attr('src','<?=base_url()?>images/no-image.fw.png');
                                $('#submit').removeAttr('disabled');
                                $('#submit').html('Submit');
                              },
        dataType:  'json',
        // 'xml', 'script', or 'json' (expected server response type) 
        // data: {csrf_test_name: $.cookie('csrf_cookie_name')}
    };
  $('#addNewForm').ajaxForm(options);
});


  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onloadend = function () { // set image data as background of div
          $('.img-prev').attr('src', this.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  $(document).on('change','#fileupload',function(){
    readURL(this);
  });

</script>
  <style type="text/css">
    .form-inline .form-group{
    margin-left: 0 !important;
    margin-right: 0 !important;
    }
  </style>
        <!-- Content Header (Page header) -->
        

        <!-- Main content -->
        <section class="content">
          <div class="bs-example">
          <?php echo form_open_multipart('admin/personnel_information/save_employee',array('id'=>'addNewForm' , 'class' => 'form-horizontal', 'data-toggle' => "validator")) ?>
             <h3>Employee ID: <input type="text" name="employee_id" disabled="disabled"></h3>
             <h2 class="text-center"> <span class="label label-info">Personal Information</span></h2><br>
                <div class="form-group">
                    <label for="employee_fname" class="control-label  col-lg-4 col-xs-12 col-md-3 col-sm-3">First Name</label>
                    <div class="col-md-9 col-sm-9 col-lg-4 col-lg-4">
                        <input type="text" class="form-control"  id="remoteValidator" name="employee_fname" placeholder="John" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="employee_mname" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Middle Name</label>
                    <div class="col-md-9 col-sm-9 col-lg-4">
                        <input type="text" class="form-control" name="employee_mname" placeholder="Doe" >
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="employee_lname" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Last Name</label>
                    <div class="col-md-9 col-sm-9 col-lg-4">
                        <input type="text" class="form-control" name="employee_lname" placeholder="Smith" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="employee_ext" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Extension </label>
                    <div class="col-md-9 col-sm-9 col-lg-4">
                        <input type="text" class="form-control" name="employee_ext" placeholder="Jr.">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="employee_bday" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3 ">Birthday</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                    <input type="date" class="form-control" name="employee_bday" placeholder="mm/dd/yy"/>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
               
                <div class="form-group">
                  <label for="employee_status" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Status</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                    <select class="form-control" name="employee_status">
                      <option>Single</option>
                      <option>Married</option>
                      <option>Divorce</option>
                      <option>Widow</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="employee_gender" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Gender</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                    <select class="form-control" name="employee_gender" required>
                      <option>Male</option>
                      <option>Female</option>
                    </select>
                  </div>
                </div>
           
                <div class="form-group">
                  <label for="employee_mobile" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Mobile Number</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                    <input type="number" class="form-control" name="employee_mobile" placeholder="09123456789" maxlength="11" minlength="11" />
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="employee_phone" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Phone Number</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                    <input type="number" class="form-control" name="employee_phone" placeholder="(085)341-6141"/>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
            <h2 class="text-center"> <span class="label label-info">Employment Information</span></h2><br>
            <div class="form-group">
              <label for="department_name" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3 ">Department</label>
              <div class="col-md-9 col-sm-9 col-lg-4">
                <select class="form-control" name="department_id" >
                  <option value="">-- SELECT --</option>
                  <?php foreach ($depts as $key => $value): ?>
                    <option value="<?= $value->department_id ?>"><?= $value->department_name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="employment_hired_date" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Hired Date</label>
              <div class="col-md-9 col-sm-9 col-lg-4">
                <input type="date" class="form-control" name="employment_hired_date" placeholder="mm/dd/yy" />
              </div>
            </div>
                
            <div class="form-group">
              <label for="employment_rate" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Rate </label>
              <div class="col-md-9 col-sm-9 col-lg-4">
                  <input type="number" class="form-control" name="employment_rate" placeholder="305">
                  <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="form-group">
              <label for="employment_job_title" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Job Title </label>
              <div class="col-md-9 col-sm-9 col-lg-4">
                  <input type="text" class="form-control" name="employment_job_title" placeholder="Lecturer" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-3 col-sm-offset-3 col-lg-offset-4 col-md-9 col-sm-9 col-lg-4">
                   <button class="btn btn-block btn-primary" data-disable="true" id='submit'>Add</button>
                </div>
            </div>
        </div>
      </form>
    </section>
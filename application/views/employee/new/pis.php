<div id="printable_pi">
<div id="notifications"></div>
      <section class="content">
        <div class="bs-example">
        <?php echo form_open_multipart('admin/personnel_information/save_employee',array('id'=>'addNewForm' , 'class' => 'form-horizontal', 'data-toggle' => "validator")) ?>
           <!-- <h3>Employee ID: <input style="border:none; background-color:white;"  type="text" name="employee_id" =""></h3> -->
           <h2 class="text-center"> <span class="label label-info">Personal Information</span></h2><br>
            <?php if ($this->uri->segment(2) == 'employee'): ?>
              <!-- <input style="border:none; background-color:white;"  type="hidden" name="new" value='1'> -->
            <?php endif ?>
              <div class="form-group">
                  <label class="control-label  col-lg-4 col-xs-12 col-md-3 col-sm-3"></label>
                  <div class="col-md-9 col-sm-9 col-lg-4 col-lg-4">
                      <center>
                        <img class="img-prev" src="<?=base_url()?>images/no-image.fw.png" style="width:180px;height:180px;border-radius:100%;border:1px solid #CCC"><br/><br />
                      </center>
                  </div>
              </div>

              <div class="form-group">
                  <!-- <label for="imageFile" class="control-label  col-lg-4 col-xs-12 col-md-3 col-sm-3"></label>
                  <div class="col-md-9 col-sm-9 col-lg-4 col-lg-4">
                      <input style="border:none; background-color:white;"  type="file" class="form-control btn btn-block btn-primary" name="userfile" id="fileupload">
                  </div> -->
              </div>
              <div class="form-group">
                <label class="control-label  col-lg-4 col-xs-12 col-md-3 col-sm-3">Employee ID</label>
                <div class="col-md-9 col-sm-9 col-lg-4 col-lg-4">
                    <input style="border:none; background-color:white;"  type="text" class="form-control"  name="employee_id" <?= "value='{$this->userInfo->employee_id}'" ?> >
                    <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="form-group">
                  <label for="employee_fname" class="control-label  col-lg-4 col-xs-12 col-md-3 col-sm-3">First Name</label>
                  <div class="col-md-9 col-sm-9 col-lg-4 col-lg-4">
                      <input style="border:none; background-color:white;"  type="text" class="form-control"  id="remoteValidator" name="employee_fname" placeholder="John" value="<?= $this->userInfo->employee_fname ?>">
                      <div class="help-block with-errors"></div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="employee_mname" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Middle Name</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                      <input style="border:none; background-color:white;"  type="text" class="form-control" name="employee_mname" placeholder="Doe" value="<?= $this->userInfo->employee_mname ?>">
                      <div class="help-block with-errors"></div>
                  </div>
              </div> 
               <div class="form-group">
                  <label for="employee_lname" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Last Name</label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                      <input style="border:none; background-color:white;"  type="text" class="form-control" name="employee_lname" placeholder="Smith" value="<?= $this->userInfo->employee_lname ?>">
                      <div class="help-block with-errors"></div>
                  </div>
              </div>
               <div class="form-group">
                  <label for="employee_ext" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Extension </label>
                  <div class="col-md-9 col-sm-9 col-lg-4">
                      <input style="border:none; background-color:white;"  type="text" class="form-control" name="employee_ext" placeholder="Jr." value="<?= $this->userInfo->employee_ext ?>">
                      <div class="help-block with-errors"></div>
                  </div>
              </div>
              <div class="form-group">
                <label for="employee_bday" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3 ">Birthday</label>
                <div class="col-md-9 col-sm-9 col-lg-4">
                  <input style="border:none; background-color:white;"  type="text" class="form-control" name="employee_bday" placeholder="05/23/1995" value="<?= $this->userInfo->employee_bday ?>"/>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
             
              <div class="form-group">
                <label for="employee_status" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" value="<?= $this->userInfo->employee_status ?>">Status</label>
                <div class="col-md-9 col-sm-9 col-lg-4">
                    <input style="border:none; background-color:white;"  type="text" class="form-control" name="employee_status" placeholder="Single" value="<?= $this->userInfo->employee_status ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="employee_gender" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Gender</label>
                <div class="col-md-9 col-sm-9 col-lg-4">
                    <input style="border:none; background-color:white;"  type="text" class="form-control" name="employee_gender" placeholder="Male" value="<?= $this->userInfo->employee_gender ?>">
                </div>
              </div>
         
              <div class="form-group">
                <label for="employee_mobile" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Mobile Number</label>
                <div class="col-md-9 col-sm-9 col-lg-4">
                  <input style="border:none; background-color:white;"  type="number" class="form-control" name="employee_mobile" placeholder="09123456789" maxlength="11" minlength="11" value="<?= $this->userInfo->employee_mobile ?>"/>
                  <div class="help-block with-errors"></div>
                </div>
              </div>

              <div class="form-group">
                <label for="employee_phone" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Phone Number</label>
                <div class="col-md-9 col-sm-9 col-lg-4">
                  <input style="border:none; background-color:white;"  type="number" class="form-control" name="employee_phone" placeholder="(085)341-6141" value="<?= $this->userInfo->employee_telephone ?>" />
                  <div class="help-block with-errors"></div>
                </div>
              </div>






          <h2 class="text-center"> <span class="label label-info">Employment Information</span></h2><br>
          <div class="form-group">
            <label for="department_name" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3 ">Department</label>
            <div class="col-md-9 col-sm-9 col-lg-4">
              <input style="border:none; background-color:white;"  type="text" class="form-control" name="department_id" placeholder="HR" value="<?= $this->userInfo->department_name ?>"/>
            </div>
          </div>
          
          <div class="form-group">
            <label for="employment_hired_date" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Hired Date</label>
            <div class="col-md-9 col-sm-9 col-lg-4">
              <input style="border:none; background-color:white;"  type="text" class="form-control" name="employment_hired_date" placeholder="05/23/1995"  value="<?= $this->userInfo->employment_hired_date ?>"/>
            </div>
          </div>
              
          <div class="form-group">
            <label for="employment_rate" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3">Rate </label>
            <div class="col-md-9 col-sm-9 col-lg-4">
                <input style="border:none; background-color:white;"  type="number" class="form-control" name="employment_rate" placeholder="305" value="<?= $this->userInfo->employment_rate ?>">
                <div class="help-block with-errors"></div>
            </div>
          </div>

          <div class="form-group">
            <label for="employment_job_title" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Job Title </label>
            <div class="col-md-9 col-sm-9 col-lg-4">
                <input style="border:none; background-color:white;"  type="text" class="form-control" name="employment_job_title" placeholder="Lecturer" value="<?= $this->userInfo->employment_job_title ?>">
                <div class="help-block with-errors"></div>
            </div>
          </div>
            <div class="form-group">
            <label for="employment_type" class="control-label col-lg-4 col-xs-12 col-md-3 col-sm-3" >Employment Type </label>
            <div class="col-md-9 col-sm-9 col-lg-4">
                <input style="border:none; background-color:white;"  type="text" class="form-control" name="employment_type" placeholder="Contractual" value="<?= $this->userInfo->employment_type ?>">
            </div>
          </div>

          <div class="form-group">
              <div class="col-md-offset-3 col-sm-offset-3 col-lg-offset-4 col-md-9 col-sm-9 col-lg-4">
              </div>
          </div>
      </div>
    </form>
      <div class="pull-right">
       <a href='#' class="btn btn-success" id="printThis_pi" ><i class="fa fa-print"></i> Print</a>
      </div>
  </section>
</div>


<style type="text/css">

  input:not(#file_upload) {
    pointer-events:none;
  }

  #notifications{
    position: fixed;
    top:2%;
    right:2%;
    z-index: 100000;
  }
</style>

<script>
    $(document).on('click','#printThis_pi',function(e){
      $('#printable_pi').print();
      e.preventDefault();
    });
</script>
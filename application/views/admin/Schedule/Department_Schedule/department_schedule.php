<style type="text/css">
    .scheduling input[type=checkbox]{
      display: none;
    }
    .scheduling {
      margin-left: 5%;
    }
  
    }
  </style>
  <div class="bs-example">
<div class="col-sm-8 col-md-8">
  <div class="box">
    <div class="box-header with-border">
      <div class="box-title ">
        <div class="col-md-4">
          <div class="input-group">
              <span class="input-group-addon">
                Choose Department
              </span>
              <select class="form-control" id="deptSelect">
                  <option value="">--Select--</option>
                  <?php foreach ($allDepts as $key => $value): ?>
                    <option value="<?= $value->department_id ?>"><?= $value->department_name ?></option>
                  <?php endforeach ?>
              </select>
          </div>
        </div>
      </div>
    </div>
    <div class="box-body row">
      <div class="col-md-12">
        <?php 
          $this->load->view('admin/Schedule/Department_Schedule/widget/dept_daily_scheds');
        ?>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
    <div class="box box-info collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title">Set Department Schedule <small>Expand to open form</small></h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
        </div><!-- /. tools -->
      </div><!-- /.box-header -->
      <div class="box-body pad">
        <?php 
           echo form_open('admin/department_schedule/save_nonflexi_sched',array('id'=>'addDepartmentForm' , 'class' => 'form-horizontal', 'data-toggle' => "validator"))
         ?>
         <form action="">
        <div class="form-group">
          <div class='scheduling'>
                  <div class="btn-group">
                  <input type="hidden" name="department_id">
                    <label for="mon" type="button" class="btn btn-default btn-md">Mon<input type="checkbox" name="sched_days[]" id="mon" value="mon"></label>
                    <label for="tue" type="button" class="btn btn-default btn-md">Tue<input type="checkbox" name="sched_days[]" id="tue" value="tue"></label>
                    <label for="wed" type="button" class="btn btn-default btn-md">Wed<input type="checkbox" name="sched_days[]" id="wed" value="wed"></label>
                    <label for="thu" type="button" class="btn btn-default btn-md">Thur<input type="checkbox" name="sched_days[]" id="thu" value="thu"></label>
                    <label for="fri" type="button" class="btn btn-default btn-md">Fri<input type="checkbox" name="sched_days[]" id="fri" value="fri"></label>
                    <label for="sat" type="button" class="btn btn-default btn-md">Sat<input type="checkbox" name="sched_days[]" id="sat" value="sat"></label>
                    <label for="sun" type="button" class="btn btn-default btn-md">Sun<input type="checkbox" name="sched_days[]" id="sun" value="sun"></label>
                  </div>
          </div>
          <div class="col-md-8 col-xs-9 col-sm-8" style="margin-top:5%;margin-left:5%;">    
                <div class="bootstrap-timepicker">
                  <div class="form-group">
                    <label for="time_in" >Time in:</label>
                    <div class="input-group">
                      <input type="text" name="sched_time[time_in]" class="form-control timepicker" id="time_in"/>
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                </div>
                <div class="bootstrap-timepicker">
                  <div class="form-group">
                    <label for="time_out">Time out:</label>
                    <div class="input-group">
                      <input type="text" name="sched_time[time_out]" class="form-control timepicker" id="time_out"/>
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                </div>
                <div class="box-footer">
                   <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-plus"></i> Set</button>
                </div>
          </div>
      </div>
        </form>
    </div><!-- /.box -->
  </div>
</div>
</div>
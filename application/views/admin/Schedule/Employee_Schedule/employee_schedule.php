<?php
/**
 * @Author: gian
 * @Date:   2016-04-01 15:53:30
 * @Last Modified by:   gian
 * @Last Modified time: 2016-04-04 08:56:52
 */
  $this->load->view('admin/Schedule/Employee_Schedule/jscripts');
?>

        <!-- Content Header (Page header) -->
  <!-- <section class="content" style="min-height:20%;"> -->
    <div class="bs-example">
    <div class="col-md-12 col-lg-8 col-sm-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <div class="col-md-12 col-lg-6 col-sm-12">
              <input type="text" name="employee_id" id="searchEmp" class="form-control" placeholder="Select Employee">
            </form>
          </div>
        </div>
        <div class="box-body">
          <?php 
            $this->load->view('admin/Schedule/Employee_Schedule/widget/emp_daily_schedule');
           ?>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-lg-4">
        <div class="col-md-12">
          <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Set Employee Schedule <small>Expand to open form</small></h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                 <?php 
                     echo form_open('admin/employee_schedule/set_schedule',array('id'=>'setSchedForm' , 'class' => 'form-horizontal', 'data-toggle' => "validator"))
                   ?>
                <div class="box-body pad">
                  <div class="form-group">
                        <div class='scheduling col-md-12'>
                                <div class="btn-group">
                                  <label for="mon" type="button" class="btn btn-default btn-md">Mon<input type="checkbox" name="days[]" id="mon" value="mon"></label>
                                  <label for="tue" type="button" class="btn btn-default btn-md">Tue<input type="checkbox" name="days[]" id="tue" value="tue"></label>
                                  <label for="wed" type="button" class="btn btn-default btn-md">Wed<input type="checkbox" name="days[]" id="wed" value="wed"></label>
                                  <label for="thu" type="button" class="btn btn-default btn-md">Thur<input type="checkbox" name="days[]" id="thu" value="thu"></label>
                                  <label for="fri" type="button" class="btn btn-default btn-md">Fri<input type="checkbox" name="days[]" id="fri" value="fri"></label>
                                  <label for="sat" type="button" class="btn btn-default btn-md">Sat<input type="checkbox" name="days[]" id="sat" value="sat"></label>
                                  <label for="sun" type="button" class="btn btn-default btn-md">Sun<input type="checkbox" name="days[]" id="sun" value="sun"></label>
                                </div>
                        </div>
                        <div class="col-md-8 col-xs-9 col-sm-8">    
                            <div class="col-md-12">
                              <div class="bootstrap-timepicker">
                                <div class="form-group">
                                  <label for="time_in" >Time in:</label>
                                  <div class="input-group">
                                    <input type="text" name="sched[time_in]" class="form-control timepicker "/>
                                    <div class="input-group-addon ">
                                      <i class="fa fa-clock-o"></i>
                                    </div>
                                  </div>
                                </div>       
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="bootstrap-timepicker">
                                <div class="form-group">
                                  <label for="time_out">Time out:</label>
                                  <div class="input-group">
                                    <input type="text" name="sched[time_out]" class="form-control timepicker" id="time_out"/>
                                    <div class="input-group-addon">
                                      <i class="fa fa-clock-o"></i>
                                    </div>
                                  </div>                                  
                                </div>
                              </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer with-border">
               <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-plus"></i>Set</button>
            </div>
            </form>
          </div>
        </div>
        <div class="col-md-12">
            <?php $this->load->view('admin/Schedule/Employee_Schedule/widget/dept_sched_menu/menu_box'); ?>
        </div>
    </div>
  <!-- </section> -->
  
<?php
/**
 * @Author: gian
 * @Date:   2016-04-14 10:47:44
 * @Last Modified by:   gian
 * @Last Modified time: 2016-08-10 09:44:56
 */
$this->load->view('admin/Daily_Time_Record/Attendance/jscripts',[],FALSE);
?>
<style type="text/css">
 /*   #dtr, #dtr td, #dtr th{
      border: 1px solid #000;
    }*/
</style>

  <!-- <center> -->
  <!-- <form class="form-horizontal"> -->
    
      <?php  if ($this->userInfo->user_privilege == "admin"): ?>
      <div class="form-group">
        <label class="col-lg-2 col-md-3 col-sm-3 control-label">Employee Name:</label>
        <div class="col-lg-3 col-md-6 col-sm-6" >
          <input type="text" class="form-control" id="empSearch" style="font-size: 1.3em; width:100%" placeholder="Juan dela Cruz">
        </div>
      </div>
      <?php endif; ?>
      <div class="col-md-2">
        <div class="form-group">
          <!-- <form id="rangeForm"> -->
            <div class="input-group">
              <button href='#' class="btn btn-default pull-right" id="daterange-btn">
                <i class="fa fa-calendar"></i> <span>Select Date Span</span>
                <i class="fa fa-caret-down"></i>
              </button>
            </div>
          <!-- </form> -->
        </div>
      </div>
  <!-- </form> -->
  <!-- </center> -->
  <div class="col-sm-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <div id="reportrange">
          <span></span>
        </div>
      </div>
      <div class="box-body bg-white color-palette">
        <!-- <div class="col-md-12"> -->
          <table class="table table-bordered" id='dtr'>
            <thead>
              <tr>
                <th rowspan="2" width="2px">Days</th>
                <th colspan="2"><center>MORNING</center></th>
                <th colspan="2"><center>AFTERNOON</center></th>
                <th rowspan="2" width="100px">LATE</th>
                <th rowspan="2" width="100px">UNDER TIME</th>
                <th colspan="2">OVERTIME</th>
                <th rowspan="2" width="100px">Daily Total</th>
              </tr>
              <tr>
                <th width="100px">IN</th>
                <th width="100px">OUT</th>
                <th width="100px">IN</th>
                <th width="100px">OUT</th>
                <th width="100px">IN</th>
                <th width="100px">OUT</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        <!-- </div> -->
      </div>
    </div>
  </div>
<!-- </div> -->

<div class="modal modal-primary fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sorry. . .</h4>
      </div>
      <div class="modal-body">
        The current version of HRMS you are using can only provide DTR for 10 people.<br>
        Please Contact Engtech Global Solutions Inc. for inquiries and use of all the functionalities the full version can offer.
      </div>
      <div class="modal-footer">
        <span class="text">Contact Number: +63 - 85 - 815 - 5299 </span>
        <br>
        <span class="text">#999 H.D.S. Building, J.C. Aquino Ave.<br>
              Butuan City, Agusan del Norte
          </span>
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>



<div class="modal modal-primary fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sorry. . .</h4>
      </div>
      <div class="modal-body">
        The current version of HRMS you are using can only provide DTR for 10 people.<br>
        Please Contact Engtech Global Solutions Inc. for inquiries and use of all the functionalities the full version can offer.
      </div>
      <div class="modal-footer">
        <span class="text">Contact Number: +63 - 85 - 815 - 5299 </span>
        <br>
        <span class="text">#999 H.D.S. Building, J.C. Aquino Ave.<br>
              Butuan City, Agusan del Norte
          </span>
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
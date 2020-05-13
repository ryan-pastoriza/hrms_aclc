<style>
  #example2 td, #example2 tr, #example2 th{
    border: 1px solid #000;
  }
</style>
<div style="min-height:900px;">
  <section class="content-header">
      <h1>
        Daily Time Record
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> DTR</a></li>
      </ol>
  </section>
      <!-- <div class="col-md-11" style="border:1px solid none;">
          <img src="<?= base_url() ?>images/hris_header.jpg" >
      </div> -->
  <div class="col-sm-12 col-md-12 col-xs-12">
      <div class="box">
        <div class="box-header with-border">
           <div class="col-md-6">
              <div class="input-group">
                 <span class="input-group-addon">
                   Choose Employee Name
                 </span>
                 <select class="form-control" id="deptSelect">
                     <option value="">--Select--</option>
                     <?php foreach ($allDepts as $key => $value): ?>
                       <option value="<?= $value->employee_id ?>"><?= $value->employee_name ?></option>
                                  <?php endforeach ?>
                 </select>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                       <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="reservation"/>
                  </div><!-- /.input group -->
                </div><!-- /.form group -->
            </div>
        </div><!-- end of box-header -->
        <div class="box-body row">
            <div class="col-md-12">
                      <div class="box-body table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                          <thead>  
                            <tr>
                              <th rowspan="3"><br><center>DATE</center></th>
                              <th colspan="4"><br><center>REGULAR TIME</center></th>
                              <th colspan="4"><br><center>OVER TIME</center></th>
                              <th rowspan="2"><br><br><center>REMARKS</center></th>
                            </tr>
                            <tr>
                              <td colspan="2"><center>AM</center></td>
                              <td colspan="2"><center>PM</center></td>
                              <td colspan="2"><center>REGULAR DAY</center></td>
                              <td colspan="2"><center>SUN &amp; HOLIDAY</center></td>
                            </tr>
                           <tr>
                              <td>IN</td>
                              <td>OUT</td>
                              <td>IN</td>
                              <td>OUT</td>
                              <td>HRS.</td>
                              <td>MINS.</td>
                              <td>HRS.</td>
                              <td>MINS.</td>
                              <td></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php  
                              for($x = 1;$x<=31;$x++){
                             ?>
                                <tr>
                                  <td height="23" name="c1"><center><?php echo $x."<br />"; ?></center></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                            <?php  }    ?>
                          </tbody>
                        </table>
                      </div>
            </div>
        </div><!--end of box body-->
      </div><!--end of box-->
  </div><!--end of col-md-12 div-->
</div>
</div><!--end of content-wrapper-->









      
<?php
/**
 * @Author: gian
 * @Date:   2015-12-09 14:48:12
 * @Last Modified by:   gian
 * @Last Modified time: 2016-03-09 10:11:34
 */
  

$tbl =  lte_load_view('datatable', ['tableHeaders' => ['Employee',
                                                      'Department',
                                                      'Position'
                                                    ], 
                                  'tableRows' => [],
                                  'tableOptions' => [
                                                    'ajax' => ['url' => base_url('index.php/admin/payroll/employee_datatable_json')],
                                                    'buttons' => [
                                                                  'selectAll',
                                                                  'selectNone',
                                                                  ],
                                                    // 'selection' => 'multi',
                                                    'select' => 'multi',
                                                    'selector' =>  'td:first-child',
                                                    ],
                                  'tableId'           => 'emp-payroll-selector-table',
                                  'tblVarName'        => 'emp_selector_tbl',
                                  'selectionEnabled'  => true,
                                ]);

?>
<?php echo form_open_multipart('admin/payroll/generate_payroll', array('id'=>'genPayroll' , 'class' => 'form-horizontal', 'data-toggle' => "validator" ,'target' => '_blank','method' => 'POST')); 
  echo $tbl;
?>
  <input type="hidden" name="tbl_cb">
  <div id="selectedEmps"></div>
  <div class="col-sm-12">
    <!-- <form class="form-horizontal"> -->
      <div class="container-fluid">
        <div class="col-sm-12">
          <div class="row"> 

            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label col-sm-2" style="text-align:left;">Cut - off Dates :</label>
                <div class="col-sm-6">
                  <!-- <form id="rangeForm"> -->
                    <div class="input-group">
                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                        <i class="fa fa-calendar"></i> <span>Select Date Span</span>
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                  <!-- </form> -->
                </div>
              </div>
            </div>
            <div class="col-sm-6">
            <label>Payroll Date</label>
              <div class="row">
                <div class="col-sm-4">
                  <div class="input-group">
                      <span class="input-group-addon">Month</span>
                      <select class="form-control" name="payroll[month]">
                      <?php 
                        for($i = 1; $i <=12; $i++){
                          $selected = "";
                          if ($i == date('n')) {
                            $selected = "selected";
                          }
                          echo "<option {$selected} value='{$i}'>".date('F', strtotime('2000-'.$i."-20"))."</option>";
                        }
                      ?>
                      </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="input-group">
                      <span class="input-group-addon">Day</span>
                      <select class="form-control" name="payroll[day]">
                        <option>15th</option>
                        <option>End of Month</option>
                      </select>
                  </div>
                </div>
                 <div class="col-sm-4">
                  <div class="input-group">
                      <span class="input-group-addon">Year</span>
                      <select class="form-control" name="payroll[year]">
                      <?php 
                        for ($i=date('Y'); $i >= 2015; $i--) { 
                          echo "<option>{$i}</option>";
                        }
                       ?>
                      </select>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- end of row -->

          <div class="form-group">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h5 class="box-title">
                    <div id="reportrange">
                        <span></span>
                        <input type="hidden" name="cut_off_start">
                        <input type="hidden" name="cut_off_end">
                      </div>
                </h5>
              </div>
              <div class="box-body">
                <div class="container-fluid">
                  <div class="row"><!-- start of row -->
                    <div class="form-group">

                      <div class="col-sm-6">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Less</h3>
                          </div>
                          <div class="panel-body">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="sss"> SSS
                              </label>
                            </div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="philhealth"> Philhealth
                              </label>
                            </div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="pagibig"> Pag-Ibig
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Adjustments</h3>
                          </div>
                          <div class="panel-body">
                          <div class="row">
                                <div class="col-sm-4">
                                  <label for="" class="label label-default">Employee</label>
                                  <input type="text" class="form-control" placeholder="Name" id="empSearch">
                                </div>
                                <div class="col-sm-4">
                                  <label for="" class="label label-default">Adjustment Name</label>
                                  <input type="text" name="adjustment_name" placeholder="adjustment name" id="" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                  <label for="" class="label label-default">Amount</label>
                                  <?= lte_load_view('form_group',['formInputs' => [0 => ['prefix' => 'Php', 'attribs' => ['type' => 'number', 'step' => 'any', 'placeholder' => '0.00', 
                                    'id' => 'adjustment-amt'] ] ]]) ?>
                                  <!-- <input type="text" class="form-control" placeholder="Amount"> -->
                                </div>
                                <div class="col-sm-1" style="padding-top: 20px">
                                  <a href="#" class="btn btn-info btn-sm" id="add-adjustment-btn"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  </div><!-- end of row-->

                </div>
              </div>

            </div>
          <div class="pull-right" >
              <button class="btn btn-success">
              <i class="fa fa-retweet" onclick="appendSelected()"></i>
                Generate Payroll
              </button>
            </div>

          </div>
        </div>
      </div>
  </div>
</form>
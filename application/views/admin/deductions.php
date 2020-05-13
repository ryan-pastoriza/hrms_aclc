
<section class="content" style="min-height:500px;">
 
  <div class="col-md-12 col-sm-12 col-lg-12">
          <div class="box box-info">
              <div class="box-header">
                  <h3 class="box-title">Deductions</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
              </div><!-- /.box-header -->
              <div class="box-body pad">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#loans" aria-controls="loans" role="tab" data-toggle="tab"><label for="loans" type="button" class="btn btn-default btn-md">Loans</label></a></li>
                      <li role="presentation"><a href="#advances" aria-controls="advances" role="tab" data-toggle="tab"><label for="advances" type="button" class="btn btn-default btn-md">Cash Advances   </label></a></li>
                      <li role="presentation"><a href="#philhealth" aria-controls="philhealth" role="tab" data-toggle="tab"><label for="philhealth" type="button" class="btn btn-default btn-md">Philhealth</label></a></li>
                      <li role="presentation"><a href="#pagibig" aria-controls="pagibig" role="tab" data-toggle="tab"><label for="pagibig" type="button" class="btn btn-default btn-md">Pag-ibig</label></a></li>
                      <li role="presentation"><a href="#sss" aria-controls="sss" role="tab" data-toggle="tab"><label for="sss" type="button" class="btn btn-default btn-md">SSS</label></a></li>
                      <li role="presentation"><a href="#wtax" aria-controls="wtax" role="tab" data-toggle="tab"><label for="wtax" type="button" class="btn btn-default btn-md">WTax</label></a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                        
                        <div role="tabpanel" class="tab-pane active" id="loans">
                           <div class="box-body">
                              <form class="form-horizontal" role="form" style="text-align:right;">
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">ID:</label>
                                    <div class="col-sm-5">
                                      <input type="email" class="form-control" id="email" placeholder="Enter employee ID">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Employee Name:</label>
                                    <div class="col-sm-5"> 
                                      <input type="password" class="form-control" id="pwd" placeholder="Enter employee name">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Amount Credit:</label>
                                    <div class="col-sm-5"> 
                                      <input type="password" class="form-control" id="pwd" placeholder="Enter amount">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Amount Deduct:</label>
                                    <div class="col-sm-5">
                                      <input type="email" class="form-control" id="email" placeholder="Enter amount">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                  <label class="control-label col-sm-2" for="type" >Frequency:</label>
                                  <div class="col-sm-5"style="margin-left:0%;">
                                    <select class="form-control">
                                      <option>weekly</option>
                                      <option>every 15 days</option>
                                      <option>monthly</option>
                                      
                                    </select>
                                  </div>
                                </div>
                                  <div class="form-group"> 
                                    <div class=" col-sm-7">
                                      <button type="submit" class="btn btn-info">Submit</button>
                                      <button type="clear" class="btn btn-info">Clear</button>
                                    </div>
                                  </div>
                              </form>
                          </div>
                        </div>
                         <div role="tabpanel" class="tab-pane" id="advances">
                              <div class="box-body">
                              <form class="form-horizontal" role="form" style="text-align:right;">
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">ID:</label>
                                    <div class="col-sm-5">
                                      <input type="email" class="form-control" id="email" placeholder="Enter employee ID">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Employee Name:</label>
                                    <div class="col-sm-5"> 
                                      <input type="password" class="form-control" id="pwd" placeholder="Enter employee name">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Amount Credit:</label>
                                    <div class="col-sm-5"> 
                                      <input type="password" class="form-control" id="pwd" placeholder="Enter amount">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Amount Deduct:</label>
                                    <div class="col-sm-5">
                                      <input type="email" class="form-control" id="email" placeholder="Enter amount">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                  <label class="control-label col-sm-2" for="type" >Frequency:</label>
                                  <div class="col-sm-5"style="margin-left:0%;">
                                    <select class="form-control">
                                      <option>weekly</option>
                                      <option>every 15 days</option>
                                      <option>monthly</option>
                                      
                                    </select>
                                  </div>
                                </div>
                                  <div class="form-group"> 
                                    <div class="col-sm-7">
                                      <button type="submit" class="btn btn-info">Submit</button>
                                      <button type="clear" class="btn btn-info">Clear</button>
                                    </div>
                                  </div>
                              </form>
                              </div>
                         </div>
                         <div role="tabpanel" class="tab-pane" id="philhealth">
                              <div class="box-body">
                                <?php 
                                $this->load->view('admin/widgets/deductions/philhealth');
                               ?>
                              </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="pagibig">
                              <div class="box-body">
                                <?php 
                                $this->load->view('admin/widgets/deductions/pag_ibig');
                               ?>
                              </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="sss">
                              <div class="box-body">
                               <?php 
                                $this->load->view('admin/widgets/deductions/sss');
                               ?>
                              </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="wtax">
                              <div class="box-body">
                                <?php 
                                $this->load->view('admin/widgets/deductions/wtax');
                               ?>
                              </div>
                          </div>
                       
                  </div><!--end of tab content-->
              </div>
          </div>
  </div>
</section>
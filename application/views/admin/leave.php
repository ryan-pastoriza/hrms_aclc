
<script type="text/javascript">
var autocomp;
var selectedName;
var empSelected;
$(function(){
  var tautocomplete = {
                        columns: ['Name','Department'],
                        norecord: "No Records Found",
                        placeholder:"Type Employee Name",
                        theme: "white",
                        regex: "^[a-zA-Z0-9\b \, \s]+$",
                        onchange: function(){
                          empSelected = autocomp.id();
                          selectedName = autocomp.text();
                          display_log();
                        },
                        data: function () {
                              var data = <?= $empData ?>;

                              var filterData = [];

                              var searchData = eval("/" + autocomp.searchdata() + "/gi");

                              $.each(data, function (i, v) {
                                  if (v.fullName.search(new RegExp(searchData)) != -1) {
                                      filterData.push(v);
                                  }
                              });
                              return filterData;
                          }
                        };
    autocomp = $('#empSearch').tautocomplete(tautocomplete);

</script>

<section class="content-header">
  <div class="row">
   
  </div>
</section>
<section class="content" style="min-height:800px;">
  <form class="form-horizontal">
      <div class="form-group">
        <label class="col-lg-2 col-md-3 col-sm-3 control-label">Employee Name:</label>
        <div class="col-lg-3 col-md-6 col-sm-6" >
          <input type="text" class="form-control" id="empSearch" style="font-size: 1.3em; width:100%" placeholder="Juan dela Cruz">
        </div>
      </div>
  </form>
  <div class="col-md-9 col-sm-9 col-lg-9">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Add Leave Form <small>Expand to open form</small></h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box box-default">
                <div class="box-body pad">
                 
                 <div class="row"> <!-- row-->
                    <div class="col-sm-3" style="margin-left:2%;">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon">From</span>
                          <input type="date" class="form-control">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon">To</span>
                          <input type="date" class="form-control">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <form class="form-horizontal" role="form">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="type" >Type:</label>
                      <div class="col-sm-6">
                        <select class="form-control">
                          <option></option>
                          <option>Vacation Leave</option>
                          <option>Birthday Leave</option>
                          <option>Sick Leave</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2">Reason:</label>
                      <div class="col-sm-6"> 
                       <textarea class="form-control" placeholer="Reason"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2">Date Filed:</label>
                      <div class="col-sm-6">
                        <div class="input-group">
                          <input type="date" class="form-control">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group"> 
                      <div class="col-sm-offset-2 col-sm-7">
                        <button type="submit" class="btn btn-info">Submit</button>
                        <button type="clear" class="btn btn-info">Clear</button>
                      </div>
                    </div>

                <!-- </div> --> <!-- end of row-->
                 <!--  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-plus"></i>Add</button>
                  </div> -->
               </form>
              </div>
          </div><!-- /.box -->
      </div>
      </div>
  <div class="col-md-12 col-sm-9 col-lg-9">
          <div class="box box-info collapsed-box">
              <div class="box-header">
                  <h3 class="box-title">Leave Records <small>Expand to open form</small></h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /. tools -->
              </div><!-- /.box-header -->
              <div class="box-body pad">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><label for="employee" type="button" class="btn btn-default btn-md">Employee</label></a></li>
                      <li role="presentation"><a href="#vacation" aria-controls="vacation" role="tab" data-toggle="tab"><label for="vacation" type="button" class="btn btn-default btn-md">Vacation</label></a></li>
                      <li role="presentation"><a href="#others"   aria-controls="others" role="tab" data-toggle="tab"><label for="others" type="button" class="btn btn-default btn-md">Others</label></a></li>
                      <li role="presentation"><a href="#recorded" aria-controls="recorded" role="tab" data-toggle="tab"><label for="recorded" type="button" class="btn btn-default btn-md">Recorded</label></a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                        
                          <form class="form-horizontal" style="margin-top:3%;">
                            <div class="form-group">
                              <label class="col-lg-3 col-md-3 col-sm-3 control-label">Employee Name:</label>
                              <div class="col-lg-4 col-md-6 col-sm-6" >
                                <input type="text" class="form-control" id="empSearch" style="font-size: 1.3em; width:100%" placeholder="Juan dela Cruz">
                              </div>
                            </div>
                          </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vacation">
                           <div class="box-body">
                            <?php 
                              $this->load->view('admin/widgets/leave/leave_vacation');
                             ?>
                          </div>
                        </div>
                         <div role="tabpanel" class="tab-pane" id="others">
                           <div class="box-body">
                              <?php 
                                $this->load->view('admin/widgets/leave/leave_others');
                               ?>
                           </div>
                         </div>
                         <div role="tabpanel" class="tab-pane" id="recorded">
                            <div class="box-body">
                              <?php 
                                $this->load->view('admin/widgets/leave/leave_lists');
                               ?>
                           </div>
                         </div>
                  </div><!--end of tab content-->
              </div>
          </div>
  </div>
</section>